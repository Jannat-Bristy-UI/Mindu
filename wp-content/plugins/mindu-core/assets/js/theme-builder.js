/**
 * TP Theme Builder — admin app.
 *
 * Vanilla JS, no dependencies. All markup is built with createElement /
 * textContent so post titles and slugs are never injected as HTML.
 */
(function () {
	'use strict';

	if (typeof window.tpTB === 'undefined') {
		return;
	}

	var cfg = window.tpTB;
	var i18n = cfg.i18n;

	var state = {
		tab: cfg.initialTab || 'header',
		status: 'all',
		search: '',
		paged: 1,
		firstLoad: true,
		selected: {} // id -> row (cleared whenever the list re-renders)
	};

	var refs = {}; // live DOM references, filled by renderShell()
	var searchTimer = null;

	/* ------------------------------------------------------------------ utils */

	/**
	 * el('div', {class: 'x', onclick: fn}, childOrText, ...)
	 */
	function el(tag, attrs) {
		var node = document.createElement(tag);
		attrs = attrs || {};
		Object.keys(attrs).forEach(function (key) {
			var value = attrs[key];
			if (value === null || value === undefined || value === false) {
				return;
			}
			if (key.indexOf('on') === 0 && typeof value === 'function') {
				node.addEventListener(key.slice(2), value);
			} else if (key === 'dataset') {
				Object.keys(value).forEach(function (d) {
					node.dataset[d] = value[d];
				});
			} else {
				node.setAttribute(key, value === true ? '' : value);
			}
		});
		for (var i = 2; i < arguments.length; i++) {
			var child = arguments[i];
			if (child === null || child === undefined || child === false) {
				continue;
			}
			node.appendChild(typeof child === 'string' ? document.createTextNode(child) : child);
		}
		return node;
	}

	function icon(name) {
		return el('span', { class: 'dashicons ' + name, 'aria-hidden': 'true' });
	}

	function sprintf(template) {
		var args = Array.prototype.slice.call(arguments, 1);
		var index = 0;
		return String(template).replace(/%(\d+\$)?s/g, function (match, pos) {
			if (pos) {
				return String(args[parseInt(pos, 10) - 1]);
			}
			return String(args[index++]);
		});
	}

	function setBusy(button, busy) {
		if (!button) {
			return;
		}
		button.classList.toggle('is-busy', !!busy);
		button.disabled = !!busy;
	}

	function selectedIds() {
		return Object.keys(state.selected);
	}

	/* ------------------------------------------------------------------ api */

	function api(action, data) {
		var body = new FormData();
		body.append('action', action);
		body.append('nonce', cfg.nonce);
		body.append('tab', state.tab);
		Object.keys(data || {}).forEach(function (key) {
			var value = data[key];
			if (Array.isArray(value)) {
				value.forEach(function (item) {
					body.append(key + '[]', item);
				});
			} else {
				body.append(key, value);
			}
		});

		return window.fetch(cfg.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: body })
			.then(function (response) {
				return response.json().catch(function () {
					throw new Error(i18n.genericError);
				});
			})
			.then(function (json) {
				if (!json || !json.success) {
					var message = json && json.data && json.data.message ? json.data.message : i18n.genericError;
					throw new Error(message);
				}
				return json.data;
			});
	}

	/* ------------------------------------------------------------------ toasts */

	function toast(message, type) {
		var container = document.querySelector('.tp-tb-toasts');
		if (!container) {
			container = el('div', { class: 'tp-tb-toasts' });
			document.body.appendChild(container);
		}

		var item = el(
			'div',
			{ class: 'tp-tb-toast tp-tb-toast--' + (type || 'success'), role: 'status' },
			el(
				'span',
				{ class: 'tp-tb-toast-icon' },
				icon(type === 'error' ? 'dashicons-warning' : 'dashicons-yes-alt')
			),
			el('span', {}, message)
		);
		container.appendChild(item);

		window.setTimeout(function () {
			item.classList.add('is-leaving');
			window.setTimeout(function () {
				item.remove();
			}, 220);
		}, 3500);
	}

	/* ------------------------------------------------------------------ modal system */

	var modalState = { overlay: null, lastFocus: null };

	var FOCUSABLE = 'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

	/**
	 * openModal({title, subtitle, body, foot, small, noHead})
	 * noHead renders the "plain" variant (centered confirm) with a floating close.
	 */
	function openModal(options) {
		closeModal(true);

		modalState.lastFocus = document.activeElement;

		var modal = el('div', {
			class: 'tp-tb-modal'
				+ (options.small ? ' tp-tb-modal--sm' : '')
				+ (options.noHead ? ' tp-tb-modal--plain' : ''),
			role: 'dialog',
			'aria-modal': 'true',
			'aria-label': options.title
		});

		var closeBtn = el('button', {
			type: 'button',
			class: 'tp-tb-modal-close',
			'aria-label': i18n.cancel,
			onclick: function () {
				closeModal();
			}
		}, icon('dashicons-no-alt'));

		if (options.noHead) {
			modal.appendChild(closeBtn);
		} else {
			modal.appendChild(el(
				'div',
				{ class: 'tp-tb-modal-head' },
				el(
					'div',
					{ class: 'tp-tb-modal-titles' },
					el('h2', {}, options.title),
					options.subtitle ? el('p', {}, options.subtitle) : null
				),
				closeBtn
			));
		}

		var body = el('div', { class: 'tp-tb-modal-body' });
		body.appendChild(options.body);
		modal.appendChild(body);

		if (options.foot) {
			modal.appendChild(options.foot);
		}

		var overlay = el('div', {
			class: 'tp-tb-overlay',
			onclick: function (event) {
				if (event.target === overlay && !overlay.classList.contains('is-busy')) {
					closeModal();
				}
			}
		}, modal);

		overlay.addEventListener('keydown', function (event) {
			if (event.key === 'Escape') {
				if (!overlay.classList.contains('is-busy')) {
					event.stopPropagation();
					closeModal();
				}
				return;
			}

			// keep Tab focus inside the dialog
			if (event.key === 'Tab') {
				var focusables = modal.querySelectorAll(FOCUSABLE);
				if (!focusables.length) {
					return;
				}
				var first = focusables[0];
				var last = focusables[focusables.length - 1];
				if (event.shiftKey && document.activeElement === first) {
					event.preventDefault();
					last.focus();
				} else if (!event.shiftKey && document.activeElement === last) {
					event.preventDefault();
					first.focus();
				}
			}
		});

		document.body.appendChild(overlay);
		document.body.classList.add('tp-tb-modal-open');
		modalState.overlay = overlay;

		var focusable = modal.querySelector('input, select, button:not(.tp-tb-modal-close)');
		if (focusable) {
			focusable.focus();
		}

		return overlay;
	}

	function closeModal(immediate) {
		var overlay = modalState.overlay || document.querySelector('.tp-tb-overlay');
		if (!overlay) {
			return;
		}

		modalState.overlay = null;
		document.body.classList.remove('tp-tb-modal-open');

		var restoreFocus = function () {
			if (modalState.lastFocus && document.contains(modalState.lastFocus)) {
				modalState.lastFocus.focus();
			}
			modalState.lastFocus = null;
		};

		if (immediate) {
			overlay.remove();
			return;
		}

		if (overlay.classList.contains('is-closing')) {
			return;
		}

		overlay.classList.add('is-closing');
		window.setTimeout(function () {
			overlay.remove();
			restoreFocus();
		}, 190);
	}

	/**
	 * Freeze / unfreeze the open dialog while a request is in flight:
	 * spinner on the acting button, everything else disabled.
	 */
	function setModalBusy(busy, button) {
		var overlay = modalState.overlay || document.querySelector('.tp-tb-overlay');
		if (!overlay) {
			return;
		}
		overlay.classList.toggle('is-busy', !!busy);
		overlay.querySelectorAll('input, select, button').forEach(function (control) {
			if (control === button) {
				return;
			}
			control.disabled = !!busy;
		});
		setBusy(button, busy);
	}

	function confirmDialog(options) {
		var confirmBtn = el('button', {
			type: 'button',
			class: 'tp-tb-btn ' + (options.danger ? 'tp-tb-btn--danger' : 'tp-tb-btn--primary')
		}, options.confirmLabel || i18n.confirm);

		confirmBtn.addEventListener('click', function () {
			setModalBusy(true, confirmBtn);
			options.onConfirm(confirmBtn);
		});

		openModal({
			small: true,
			noHead: true,
			title: options.title,
			body: el(
				'div',
				{ class: 'tp-tb-confirm' },
				el(
					'div',
					{ class: 'tp-tb-confirm-icon' + (options.danger ? ' is-danger' : ''), 'aria-hidden': 'true' },
					icon(options.icon || 'dashicons-info-outline')
				),
				el('h3', {}, options.title),
				el('p', { class: 'tp-tb-confirm-msg' }, options.message)
			),
			foot: el(
				'div',
				{ class: 'tp-tb-modal-foot' },
				el('button', {
					type: 'button',
					class: 'tp-tb-btn',
					onclick: function () {
						closeModal();
					}
				}, i18n.cancel),
				confirmBtn
			)
		});
	}

	/* ------------------------------------------------------------------ fields */

	function fieldText(idAttr, label, value, placeholder, help) {
		var input = el('input', {
			type: 'text',
			id: idAttr,
			class: 'tp-tb-input',
			value: value || '',
			placeholder: placeholder || ''
		});
		var field = el(
			'div',
			{ class: 'tp-tb-field' },
			el('label', { for: idAttr }, label),
			input,
			help ? el('span', { class: 'tp-tb-help' }, help) : null
		);
		return { field: field, input: input };
	}

	/**
	 * Builder/type selection as a card radio group. The native radio input is
	 * visually hidden (still focusable, arrow-key navigable, announced); the
	 * card border, tint and top-right dot carry the selected state.
	 */
	function fieldTypeCards(selected) {
		var types = cfg.types[state.tab] || {};
		var grid = el('div', { class: 'tp-tb-type-grid', role: 'radiogroup', 'aria-label': i18n.typeLabel });
		var keys = Object.keys(types);
		var current = selected && types[selected] ? selected : keys[0];

		keys.forEach(function (key) {
			var type = types[key];
			grid.appendChild(el(
				'label',
				{ class: 'tp-tb-type-card' },
				el('input', { type: 'radio', name: 'tp_tb_type', value: key, checked: key === current }),
				el(
					'span',
					{ class: 'tp-tb-type-card-inner' },
					el('span', { class: 'tp-tb-type-card-dot', 'aria-hidden': 'true' }, icon('dashicons-yes')),
					icon(type.icon || 'dashicons-admin-generic'),
					el('span', { class: 'tp-tb-type-card-title' }, type.label),
					el('span', { class: 'tp-tb-type-card-desc' }, type.desc || '')
				)
			));
		});

		var field = el(
			'div',
			{ class: 'tp-tb-field' },
			el('label', {}, i18n.typeLabel),
			grid
		);

		return {
			field: field,
			value: function () {
				var checked = grid.querySelector('input:checked');
				return checked ? checked.value : keys[0];
			}
		};
	}

	function markInvalid(input, message) {
		input.classList.add('is-invalid');
		var existing = input.parentNode.querySelector('.tp-tb-field-error');
		if (existing) {
			existing.remove();
		}
		input.insertAdjacentElement('afterend', el('span', { class: 'tp-tb-field-error' }, message));
		input.addEventListener('input', function handler() {
			input.classList.remove('is-invalid');
			var error = input.parentNode.querySelector('.tp-tb-field-error');
			if (error) {
				error.remove();
			}
			input.removeEventListener('input', handler);
		});
		input.focus();
	}

	/**
	 * Custom checkbox control. Returns the wrapping label; the input carries
	 * the given aria-label and change handler.
	 */
	function checkbox(ariaLabel, onchange) {
		var input = el('input', { type: 'checkbox', 'aria-label': ariaLabel });
		if (onchange) {
			input.addEventListener('change', onchange);
		}
		var label = el(
			'label',
			{ class: 'tp-tb-check' },
			input,
			el('span', { class: 'tp-tb-check-box' }, icon('dashicons-yes'))
		);
		return { label: label, input: input };
	}

	/* ------------------------------------------------------------------ create modal */

	function openCreateModal() {
		var name = fieldText('tp-tb-new-name', i18n.nameLabel, '', i18n.namePlaceholder);
		var type = fieldTypeCards();

		function submit(button, openEditor) {
			var title = name.input.value.trim();
			if (!title) {
				markInvalid(name.input, i18n.nameRequired);
				return;
			}
			setModalBusy(true, button);

			api('tp_tb_create', { title: title, type: type.value() })
				.then(function (data) {
					if (openEditor && data.row && data.row.editUrl) {
						window.location.href = data.row.editUrl;
						return;
					}
					closeModal();
					toast(data.message || i18n.created, 'success');
					applyCounts(data.counts);
					state.status = 'all';
					state.search = '';
					state.paged = 1;
					refs.searchInput.value = '';
					updateFilterChips();
					loadList();
				})
				.catch(function (error) {
					setModalBusy(false, button);
					toast(error.message, 'error');
				});
		}

		var createBtn = el('button', { type: 'button', class: 'tp-tb-btn' }, i18n.create);
		var createEditBtn = el(
			'button',
			{ type: 'button', class: 'tp-tb-btn tp-tb-btn--primary' },
			icon('dashicons-edit'),
			i18n.createEdit
		);
		createBtn.addEventListener('click', function () { submit(createBtn, false); });
		createEditBtn.addEventListener('click', function () { submit(createEditBtn, true); });

		var body = el('div', {}, name.field, type.field);
		body.addEventListener('keydown', function (event) {
			if (event.key === 'Enter' && event.target === name.input) {
				event.preventDefault();
				submit(createEditBtn, true);
			}
		});

		openModal({
			title: sprintf(i18n.newTitle, cfg.tabs[state.tab].label),
			subtitle: i18n.newSubtitle,
			body: body,
			foot: el('div', { class: 'tp-tb-modal-foot' }, createBtn, createEditBtn)
		});
	}

	/* ------------------------------------------------------------------ edit details modal */

	function openEditModal(row) {
		var name = fieldText('tp-tb-edit-name', i18n.nameLabel, row.title);
		var slug = fieldText('tp-tb-edit-slug', i18n.slugLabel, row.slug, '', i18n.slugHelp);
		var type = fieldTypeCards(row.type);

		var statusSelect = el(
			'select',
			{ id: 'tp-tb-edit-status', class: 'tp-tb-select' },
			el('option', { value: 'publish', selected: row.status === 'publish' }, i18n.published),
			el('option', { value: 'draft', selected: row.status === 'draft' }, i18n.draft)
		);
		var statusField = el(
			'div',
			{ class: 'tp-tb-field' },
			el('label', { for: 'tp-tb-edit-status' }, i18n.statusLabel),
			statusSelect
		);

		var saveBtn = el('button', { type: 'button', class: 'tp-tb-btn tp-tb-btn--primary' }, i18n.saveChanges);
		saveBtn.addEventListener('click', function () {
			var title = name.input.value.trim();
			if (!title) {
				markInvalid(name.input, i18n.nameRequired);
				return;
			}
			setModalBusy(true, saveBtn);

			api('tp_tb_update', {
				post_id: row.id,
				title: title,
				slug: slug.input.value.trim(),
				type: type.value(),
				status: statusSelect.value
			})
				.then(function (data) {
					closeModal();
					toast(data.message || i18n.updated, 'success');
					applyCounts(data.counts);
					loadList();
				})
				.catch(function (error) {
					setModalBusy(false, saveBtn);
					toast(error.message, 'error');
				});
		});

		openModal({
			title: sprintf(i18n.editTitle, row.title),
			subtitle: i18n.editSubtitle,
			body: el('div', {}, name.field, slug.field, type.field, row.status === 'trash' ? null : statusField),
			foot: el(
				'div',
				{ class: 'tp-tb-modal-foot' },
				el('button', {
					type: 'button',
					class: 'tp-tb-btn',
					onclick: function () {
						closeModal();
					}
				}, i18n.cancel),
				saveBtn
			)
		});
	}

	/* ------------------------------------------------------------------ row + bulk actions */

	function rowAction(row, op, tr) {
		if (tr) {
			tr.classList.add('is-row-busy');
		}
		api('tp_tb_action', { post_id: row.id, op: op })
			.then(function (data) {
				closeModal();
				toast(data.message || i18n.updated, 'success');
				applyCounts(data.counts);
				loadList();
			})
			.catch(function (error) {
				if (tr) {
					tr.classList.remove('is-row-busy');
				}
				closeModal();
				toast(error.message, 'error');
			});
	}

	function quickStatusToggle(row, tr) {
		if (tr) {
			tr.classList.add('is-row-busy');
		}
		api('tp_tb_update', { post_id: row.id, status: row.status === 'publish' ? 'draft' : 'publish' })
			.then(function (data) {
				toast(data.message || i18n.updated, 'success');
				applyCounts(data.counts);
				loadList();
			})
			.catch(function (error) {
				if (tr) {
					tr.classList.remove('is-row-busy');
				}
				toast(error.message, 'error');
			});
	}

	function runBulk(op) {
		var ids = selectedIds();
		if (!ids.length) {
			return;
		}
		api('tp_tb_bulk', { op: op, ids: ids })
			.then(function (data) {
				closeModal();
				toast(data.message, 'success');
				applyCounts(data.counts);
				loadList();
			})
			.catch(function (error) {
				closeModal();
				toast(error.message, 'error');
			});
	}

	function bulkAction(op) {
		var count = selectedIds().length;
		if (!count) {
			return;
		}

		if (op === 'restore') {
			runBulk(op);
			return;
		}

		var isDelete = op === 'delete';
		confirmDialog({
			title: isDelete ? i18n.confirmBulkDeleteTitle : i18n.confirmBulkTrashTitle,
			message: sprintf(isDelete ? i18n.confirmBulkDeleteMsg : i18n.confirmBulkTrashMsg, String(count)),
			confirmLabel: isDelete ? i18n.delete : i18n.moveTrash,
			icon: isDelete ? 'dashicons-warning' : 'dashicons-trash',
			danger: true,
			onConfirm: function () {
				runBulk(op);
			}
		});
	}

	/* ------------------------------------------------------------------ selection */

	function clearSelection() {
		state.selected = {};
		updateBulkbar();
	}

	function toggleSelection(row, checked, tr) {
		if (checked) {
			state.selected[row.id] = row;
		} else {
			delete state.selected[row.id];
		}
		if (tr) {
			tr.classList.toggle('is-selected', checked);
		}
		updateSelectAll();
		updateBulkbar();
	}

	function updateSelectAll() {
		if (!refs.selectAll) {
			return;
		}
		var total = refs.rowChecks ? refs.rowChecks.length : 0;
		var count = selectedIds().length;
		refs.selectAll.checked = total > 0 && count === total;
		refs.selectAll.indeterminate = count > 0 && count < total;
	}

	function updateBulkbar() {
		var count = selectedIds().length;

		refs.bulkbar.innerHTML = '';
		if (!count) {
			refs.bulkbar.style.display = 'none';
			return;
		}
		refs.bulkbar.style.display = '';

		var actions = el('div', { class: 'tp-tb-bulkbar-actions' });

		actions.appendChild(el('button', {
			type: 'button',
			class: 'tp-tb-btn tp-tb-btn--ghost',
			onclick: function () {
				clearSelection();
				if (refs.rowChecks) {
					refs.rowChecks.forEach(function (check) {
						check.input.checked = false;
						check.tr.classList.remove('is-selected');
					});
				}
				updateSelectAll();
			}
		}, i18n.clearSelection));

		if (state.status === 'trash') {
			actions.appendChild(el('button', {
				type: 'button',
				class: 'tp-tb-btn',
				onclick: function () {
					bulkAction('restore');
				}
			}, icon('dashicons-undo'), i18n.restore));
			actions.appendChild(el('button', {
				type: 'button',
				class: 'tp-tb-btn tp-tb-btn--danger',
				onclick: function () {
					bulkAction('delete');
				}
			}, icon('dashicons-trash'), i18n.deleteForever));
		} else {
			actions.appendChild(el('button', {
				type: 'button',
				class: 'tp-tb-btn tp-tb-btn--danger',
				onclick: function () {
					bulkAction('trash');
				}
			}, icon('dashicons-trash'), i18n.moveTrash));
		}

		refs.bulkbar.appendChild(el(
			'div',
			{ class: 'tp-tb-bulkbar-info' },
			icon('dashicons-yes-alt'),
			el('span', {}, sprintf(i18n.selectedCount, String(count)))
		));
		refs.bulkbar.appendChild(actions);
	}

	/* ------------------------------------------------------------------ rendering */

	function renderShell() {
		var app = document.getElementById('tp-tb-app');
		app.innerHTML = '';

		var addBtn = el(
			'button',
			{ type: 'button', class: 'tp-tb-btn tp-tb-btn--primary', onclick: openCreateModal },
			icon('dashicons-plus-alt2'),
			i18n.addNew
		);

		app.appendChild(el(
			'div',
			{ class: 'tp-tb-header' },
			el(
				'div',
				{ class: 'tp-tb-heading' },
				el('div', { class: 'tp-tb-logo', 'aria-hidden': 'true' }, icon('dashicons-layout')),
				el(
					'div',
					{},
					el('h1', {}, 'Theme Builder'),
					el('p', {}, Object.keys(cfg.tabs).map(function (key) { return cfg.tabs[key].label; }).join(' · '))
				)
			),
			addBtn
		));

		// tabs
		refs.tabs = {};
		var tabBar = el('div', { class: 'tp-tb-tabs', role: 'tablist' });
		Object.keys(cfg.tabs).forEach(function (key) {
			var tab = cfg.tabs[key];
			var count = el('span', { class: 'tp-tb-tab-count' }, String(tab.count));
			var button = el(
				'button',
				{
					type: 'button',
					class: 'tp-tb-tab' + (key === state.tab ? ' is-active' : ''),
					role: 'tab',
					'aria-selected': key === state.tab ? 'true' : 'false',
					onclick: function () {
						switchTab(key);
					}
				},
				icon(tab.icon),
				tab.label,
				count
			);
			refs.tabs[key] = { button: button, count: count };
			tabBar.appendChild(button);
		});
		app.appendChild(tabBar);

		// panel: toolbar + bulk bar + table + footer
		refs.filters = {};
		var filterBar = el('div', { class: 'tp-tb-filters' });
		[
			{ key: 'all', label: i18n.all },
			{ key: 'publish', label: i18n.published },
			{ key: 'draft', label: i18n.draft },
			{ key: 'trash', label: i18n.trash }
		].forEach(function (filter) {
			var countSpan = el('span', {}, '');
			var chip = el(
				'button',
				{
					type: 'button',
					class: 'tp-tb-chip' + ('trash' === filter.key ? ' tp-tb-chip--trash' : '') + (state.status === filter.key ? ' is-active' : ''),
					onclick: function () {
						state.status = filter.key;
						state.paged = 1;
						updateFilterChips();
						loadList();
					}
				},
				filter.label,
				countSpan
			);
			refs.filters[filter.key] = { chip: chip, count: countSpan };
			filterBar.appendChild(chip);
		});

		refs.searchInput = el('input', {
			type: 'search',
			class: 'tp-tb-search-input',
			placeholder: i18n.searchPlaceholder,
			'aria-label': i18n.searchPlaceholder
		});
		refs.searchInput.addEventListener('input', function () {
			window.clearTimeout(searchTimer);
			searchTimer = window.setTimeout(function () {
				state.search = refs.searchInput.value.trim();
				state.paged = 1;
				loadList();
			}, 350);
		});

		refs.bulkbar = el('div', { class: 'tp-tb-bulkbar', style: 'display:none' });
		refs.tableWrap = el('div', { class: 'tp-tb-table-wrap' });
		refs.tfoot = el('div', { class: 'tp-tb-tfoot', style: 'display:none' });

		app.appendChild(el(
			'div',
			{ class: 'tp-tb-panel' },
			el(
				'div',
				{ class: 'tp-tb-toolbar' },
				filterBar,
				el('div', { class: 'tp-tb-search' }, icon('dashicons-search'), refs.searchInput)
			),
			refs.bulkbar,
			refs.tableWrap,
			refs.tfoot
		));

		renderSkeleton();
	}

	function switchTab(key) {
		if (state.tab === key) {
			return;
		}
		state.tab = key;
		state.status = 'all';
		state.search = '';
		state.paged = 1;
		refs.searchInput.value = '';

		Object.keys(refs.tabs).forEach(function (tabKey) {
			refs.tabs[tabKey].button.classList.toggle('is-active', tabKey === key);
			refs.tabs[tabKey].button.setAttribute('aria-selected', tabKey === key ? 'true' : 'false');
		});
		updateFilterChips();

		// keep the URL shareable without reloading
		if (window.history && window.history.replaceState) {
			var url = new URL(window.location.href);
			url.searchParams.set('tab', key);
			window.history.replaceState(null, '', url.toString());
		}

		loadList();
	}

	function updateFilterChips() {
		Object.keys(refs.filters).forEach(function (key) {
			refs.filters[key].chip.classList.toggle('is-active', state.status === key);
		});
	}

	function applyCounts(counts) {
		if (!counts) {
			return;
		}
		Object.keys(refs.tabs).forEach(function (key) {
			if (counts[key]) {
				refs.tabs[key].count.textContent = String(counts[key].all);
			}
		});
		var current = counts[state.tab];
		if (current) {
			refs.filters.all.count.textContent = String(current.all);
			refs.filters.publish.count.textContent = String(current.publish);
			refs.filters.draft.count.textContent = String(current.draft);
			refs.filters.trash.count.textContent = String(current.trash);
		}
	}

	function renderSkeleton() {
		var tbody = el('tbody');
		for (var i = 0; i < 4; i++) {
			tbody.appendChild(el(
				'tr',
				{ class: 'tp-tb-skeleton-row' },
				el('td', { class: 'tp-tb-col-check' }),
				el('td', { style: 'width:38%' }, el('span', { style: 'width:60%' })),
				el('td', {}, el('span', { style: 'width:80px' })),
				el('td', {}, el('span', { style: 'width:70px' })),
				el('td', { class: 'tp-tb-col-modified' }, el('span', { style: 'width:90px' })),
				el('td', {}, el('span', { style: 'width:120px;margin-left:auto' }))
			));
		}
		refs.tableWrap.innerHTML = '';
		refs.tableWrap.appendChild(buildTable(tbody, false));
	}

	function buildTable(tbody, withSelectAll) {
		var checkTh = el('th', { class: 'tp-tb-col-check' });

		if (withSelectAll) {
			var selectAll = checkbox(i18n.selectAll, function () {
				var checked = refs.selectAll.checked;
				refs.rowChecks.forEach(function (check) {
					check.input.checked = checked;
					check.tr.classList.toggle('is-selected', checked);
					if (checked) {
						state.selected[check.row.id] = check.row;
					} else {
						delete state.selected[check.row.id];
					}
				});
				updateSelectAll();
				updateBulkbar();
			});
			refs.selectAll = selectAll.input;
			checkTh.appendChild(selectAll.label);
		} else {
			refs.selectAll = null;
		}

		return el(
			'table',
			{ class: 'tp-tb-table' },
			el(
				'thead',
				{},
				el(
					'tr',
					{},
					checkTh,
					el('th', {}, i18n.template),
					el('th', {}, i18n.type),
					el('th', {}, i18n.status),
					el('th', { class: 'tp-tb-col-modified' }, i18n.modified),
					el('th', { class: 'tp-tb-col-actions' }, i18n.actions)
				)
			),
			tbody
		);
	}

	function iconButton(options) {
		var tag = options.href ? 'a' : 'button';
		var attrs = {
			class: 'tp-tb-icon-btn' + (options.danger ? ' tp-tb-icon-btn--danger' : ''),
			title: options.title,
			'aria-label': options.title
		};
		if (options.href) {
			attrs.href = options.href;
			if (options.newTab) {
				attrs.target = '_blank';
				attrs.rel = 'noopener';
			}
		} else {
			attrs.type = 'button';
			attrs.onclick = options.onclick;
		}
		return el(tag, attrs, icon(options.icon));
	}

	function buildRow(row) {
		var tr = el('tr');

		// --- selection cell
		var check = row.canDelete ? checkbox(sprintf(i18n.selectItem, row.title), function (event) {
			toggleSelection(row, event.target.checked, tr);
		}) : null;
		if (check) {
			refs.rowChecks.push({ input: check.input, row: row, tr: tr });
		}
		tr.appendChild(el('td', { class: 'tp-tb-col-check' }, check ? check.label : null));

		// --- template cell
		var titleLine = el('div', { class: 'tp-tb-item-title' });
		if (row.canEdit && row.status !== 'trash') {
			titleLine.appendChild(el('a', { href: row.editUrl }, row.title));
		} else {
			titleLine.appendChild(el('span', {}, row.title));
		}
		tr.appendChild(el(
			'td',
			{},
			titleLine,
			el('div', { class: 'tp-tb-item-slug' }, row.slug || '—')
		));

		// --- type cell
		tr.appendChild(el(
			'td',
			{},
			el(
				'span',
				{ class: 'tp-tb-type' + (row.isElementor ? ' tp-tb-type--elementor' : '') },
				icon(row.typeIcon || 'dashicons-edit'),
				row.typeLabel
			)
		));

		// --- status cell
		tr.appendChild(el(
			'td',
			{},
			el('span', { class: 'tp-tb-status tp-tb-status--' + row.status }, row.statusLabel)
		));

		// --- modified cell
		tr.appendChild(el(
			'td',
			{ class: 'tp-tb-col-modified' },
			el('span', { class: 'tp-tb-modified', title: row.modified }, row.modifiedAgo)
		));

		// --- actions cell
		var actions = el('div', { class: 'tp-tb-actions' });

		if (row.status === 'trash') {
			if (row.canDelete) {
				actions.appendChild(iconButton({
					icon: 'dashicons-undo',
					title: i18n.restore,
					onclick: function () {
						rowAction(row, 'restore', tr);
					}
				}));
				actions.appendChild(iconButton({
					icon: 'dashicons-trash',
					title: i18n.deleteForever,
					danger: true,
					onclick: function () {
						confirmDialog({
							title: i18n.confirmDeleteTitle,
							message: sprintf(i18n.confirmDeleteMsg, row.title),
							confirmLabel: i18n.delete,
							icon: 'dashicons-warning',
							danger: true,
							onConfirm: function () {
								rowAction(row, 'delete', tr);
							}
						});
					}
				}));
			}
		} else {
			if (row.canEdit) {
				actions.appendChild(iconButton({
					icon: row.isElementor ? 'dashicons-layout' : 'dashicons-welcome-write-blog',
					title: row.isElementor ? i18n.editWithElementor : i18n.edit,
					href: row.editUrl
				}));
				actions.appendChild(iconButton({
					icon: 'dashicons-admin-generic',
					title: i18n.editDetails,
					onclick: function () {
						openEditModal(row);
					}
				}));
				actions.appendChild(iconButton({
					icon: 'dashicons-admin-page',
					title: i18n.duplicate,
					onclick: function () {
						rowAction(row, 'duplicate', tr);
					}
				}));
				actions.appendChild(iconButton({
					icon: row.status === 'publish' ? 'dashicons-hidden' : 'dashicons-visibility',
					title: row.status === 'publish' ? i18n.switchDraft : i18n.publish,
					onclick: function () {
						quickStatusToggle(row, tr);
					}
				}));
			}
			if (row.previewUrl) {
				actions.appendChild(iconButton({
					icon: 'dashicons-external',
					title: i18n.preview,
					href: row.previewUrl,
					newTab: true
				}));
			}
			if (row.canDelete) {
				actions.appendChild(iconButton({
					icon: 'dashicons-trash',
					title: i18n.moveTrash,
					danger: true,
					onclick: function () {
						confirmDialog({
							title: i18n.confirmTrashTitle,
							message: sprintf(i18n.confirmTrashMsg, row.title),
							confirmLabel: i18n.moveTrash,
							icon: 'dashicons-trash',
							danger: true,
							onConfirm: function () {
								rowAction(row, 'trash', tr);
							}
						});
					}
				}));
			}
		}

		tr.appendChild(el('td', { class: 'tp-tb-col-actions' }, actions));
		return tr;
	}

	function renderEmpty() {
		var isSearch = state.search !== '';
		var isTrash = state.status === 'trash';

		var title;
		var message;
		var cta = null;

		if (isSearch) {
			title = i18n.emptySearchTitle;
			message = i18n.emptySearchMsg;
		} else if (isTrash) {
			title = i18n.emptyTrashTitle;
			message = i18n.emptyTrashMsg;
		} else {
			title = i18n.emptyTitle;
			message = sprintf(i18n.emptyMsg, cfg.tabs[state.tab].label);
			cta = el(
				'button',
				{ type: 'button', class: 'tp-tb-btn tp-tb-btn--primary', onclick: openCreateModal },
				icon('dashicons-plus-alt2'),
				i18n.addNew
			);
		}

		refs.tableWrap.innerHTML = '';
		refs.tableWrap.appendChild(el(
			'div',
			{ class: 'tp-tb-empty' },
			el('div', { class: 'tp-tb-empty-icon' }, icon(cfg.tabs[state.tab].icon)),
			el('h3', {}, title),
			el('p', {}, message),
			cta
		));
	}

	function renderList(data) {
		applyCounts(data.counts);

		// the visible rows changed — any previous selection is stale
		refs.rowChecks = [];
		clearSelection();

		if (!data.rows.length) {
			renderEmpty();
			refs.tfoot.style.display = 'none';
			return;
		}

		var tbody = el('tbody');
		data.rows.forEach(function (row) {
			tbody.appendChild(buildRow(row));
		});

		refs.tableWrap.innerHTML = '';
		refs.tableWrap.appendChild(buildTable(tbody, true));
		updateSelectAll();

		renderPagination(data);
	}

	function renderPagination(data) {
		var from = (data.paged - 1) * cfg.perPage + 1;
		var to = Math.min(data.paged * cfg.perPage, data.total);

		refs.tfoot.innerHTML = '';
		refs.tfoot.style.display = '';
		refs.tfoot.appendChild(el(
			'span',
			{ class: 'tp-tb-tfoot-info' },
			sprintf(i18n.paginationInfo, String(from), String(to), String(data.total))
		));

		if (data.totalPages <= 1) {
			return;
		}

		var nav = el('div', { class: 'tp-tb-pagination' });

		function pageButton(label, page, options) {
			options = options || {};
			return el('button', {
				type: 'button',
				class: 'tp-tb-page-btn' + (options.active ? ' is-active' : ''),
				disabled: options.disabled,
				'aria-label': options.aria || label,
				onclick: function () {
					if (page !== state.paged) {
						state.paged = page;
						loadList();
					}
				}
			}, label);
		}

		nav.appendChild(pageButton('‹', Math.max(1, data.paged - 1), { disabled: data.paged <= 1, aria: i18n.prev }));

		for (var page = 1; page <= data.totalPages; page++) {
			if (data.totalPages > 7 && page > 2 && page < data.totalPages - 1 && Math.abs(page - data.paged) > 1) {
				if (nav.lastChild && nav.lastChild.textContent !== '…') {
					nav.appendChild(el('span', { class: 'tp-tb-tfoot-info' }, '…'));
				}
				continue;
			}
			nav.appendChild(pageButton(String(page), page, { active: page === data.paged }));
		}

		nav.appendChild(pageButton('›', Math.min(data.totalPages, data.paged + 1), { disabled: data.paged >= data.totalPages, aria: i18n.next }));

		refs.tfoot.appendChild(nav);
	}

	/* ------------------------------------------------------------------ data */

	function loadList() {
		if (state.firstLoad) {
			renderSkeleton();
		}
		refs.tableWrap.classList.add('is-loading');

		api('tp_tb_list', {
			status: state.status,
			search: state.search,
			paged: state.paged
		})
			.then(function (data) {
				// requested page may be empty after a delete — step back once
				if (!data.rows.length && data.paged > 1) {
					state.paged = data.paged - 1;
					loadList();
					return;
				}
				renderList(data);
			})
			.catch(function (error) {
				toast(error.message, 'error');
				if (state.firstLoad) {
					renderEmpty();
				}
			})
			.then(function () {
				state.firstLoad = false;
				refs.tableWrap.classList.remove('is-loading');
			});
	}

	/* ------------------------------------------------------------------ boot */

	function init() {
		var app = document.getElementById('tp-tb-app');
		if (!app) {
			return;
		}
		renderShell();
		loadList();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
