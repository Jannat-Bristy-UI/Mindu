/**
 * TP Animation — IntersectionObserver driver for the Elementor entrance
 * animation system. Vanilla JS, no dependencies.
 *
 * Loaded in the <head> on purpose: the .tp-anim-ready flag must reach <html>
 * before the body renders so the CSS hidden states apply without a flash,
 * and only when this driver is actually able to run (JS on + IO supported +
 * no reduced-motion preference). Everything else waits for DOMContentLoaded.
 */
(function () {
	'use strict';

	var root = document.documentElement;

	// Without IntersectionObserver we do nothing at all — the CSS hidden
	// states stay dormant and every element renders normally.
	if ( ! ( 'IntersectionObserver' in window ) ) {
		return;
	}

	// Reduced motion: skip entirely. (The CSS media query also covers the
	// case where the preference changes mid-session.)
	if ( window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}

	root.classList.add( 'tp-anim-ready' );

	var HORIZONTAL = [ 'tp-fade-left', 'tp-fade-right', 'tp-slide-left', 'tp-slide-right' ];
	var observer = null;

	function markDone( element ) {
		element.classList.add( 'tp-anim-done' );
	}

	/**
	 * Validate a data attribute as a CSS time value (".8s", "1.5s", "200ms")
	 * and pass it through unchanged; plain numbers (legacy saves from the old
	 * millisecond controls) are converted to "Nms". Returns '' if unusable.
	 */
	function cssTime( value ) {
		if ( ! value ) {
			return '';
		}
		value = String( value ).trim();
		if ( /^(\d+)?(\.\d+)?m?s$/.test( value ) && value !== 's' && value !== 'ms' ) {
			return value;
		}
		if ( /^\d+$/.test( value ) ) {
			return value + 'ms';
		}
		return '';
	}

	function onIntersect( entries ) {
		for ( var i = 0; i < entries.length; i++ ) {
			var entry = entries[ i ];
			var element = entry.target;

			if ( ! entry.isIntersecting ) {
				continue;
			}

			// Animations always run once: animate in, stop observing, then
			// release will-change when the entrance transition ends.
			element.classList.add( 'tp-animation-in' );
			observer.unobserve( element );
			element.addEventListener( 'transitionend', function handler( event ) {
				if ( event.target === this ) {
					this.removeEventListener( 'transitionend', handler );
					markDone( this );
				}
			} );
		}
	}

	/**
	 * Prepare one element: copy its data attributes onto CSS custom
	 * properties and start observing. Safe to call repeatedly.
	 */
	function setup( element ) {
		if ( element.tpAnimBound ) {
			return;
		}
		element.tpAnimBound = true;

		var duration = cssTime( element.getAttribute( 'data-tp-duration' ) );
		if ( duration ) {
			element.style.setProperty( '--tp-duration', duration );
		}

		var delay = cssTime( element.getAttribute( 'data-tp-delay' ) );
		if ( delay ) {
			element.style.setProperty( '--tp-delay', delay );
		}

		var distance = element.getAttribute( 'data-tp-distance' );
		if ( distance !== null && distance !== '' ) {
			element.style.setProperty( '--tp-distance', parseInt( distance, 10 ) + 'px' );
		}

		// A horizontal entrance offset could otherwise create a horizontal
		// scrollbar; overflow-x: clip on <html> (CSS) prevents that without
		// creating a scroll container. Only engaged when actually needed.
		if ( HORIZONTAL.indexOf( element.getAttribute( 'data-tp-animation' ) || '' ) !== -1 ) {
			root.classList.add( 'tp-anim-clip' );
		}

		observer.observe( element );
	}

	/**
	 * Scan the document for animation elements. Idempotent — already-bound
	 * elements are skipped — so it doubles as a public refresh() for content
	 * injected after load (popups, AJAX-loaded sections, …).
	 */
	function init() {
		// Never run inside the Elementor editor/preview: elements must stay
		// visible and editable there (CSS enforces this too).
		if ( document.body && ( document.body.classList.contains( 'elementor-editor-active' ) || document.body.classList.contains( 'elementor-edit-mode' ) ) ) {
			return;
		}

		if ( ! observer ) {
			observer = new IntersectionObserver( onIntersect, {
				threshold: 0,
				rootMargin: '0px 0px -10% 0px'
			} );
		}

		var elements = document.querySelectorAll( '.tp-animation[data-tp-animation]' );
		for ( var i = 0; i < elements.length; i++ ) {
			setup( elements[ i ] );
		}
	}

	// Public API for late-injected content.
	window.tpAnimation = { refresh: init };

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}

	// Catch anything rendered between DOMContentLoaded and full load
	// (e.g. templates printed late by other plugins).
	window.addEventListener( 'load', init );
})();
