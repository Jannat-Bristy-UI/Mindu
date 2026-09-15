<?php
/**
 * TP Theme Builder — modern admin UI for Header / Footer / Offcanvas templates.
 *
 * Replaces the default CPT list screens for tp_header / tp_footer / tp_offcanvas
 * with a single AJAX-driven admin page (tabs, modal create, bulk management).
 * The CPT registration files stay untouched — this layer only swaps the admin UI.
 *
 * @package Mindu_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class TP_Theme_Builder {

	const PAGE_SLUG        = 'tp-theme-builder';
	const PARENT_SLUG      = 'edit.php?post_type=tp_header';
	const NONCE            = 'tp_tb_nonce';
	const TYPE_META        = '_tp_tb_type';
	const LEGACY_TYPE_META = '_mindu_tb_type';
	const PER_PAGE         = 10;

	/**
	 * @var TP_Theme_Builder|null
	 */
	private static $instance = null;

	/**
	 * Admin page hook suffix, used to scope asset loading.
	 *
	 * @var string
	 */
	private $hook_suffix = '';

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'admin_menu', array( $this, 'register_menu' ), 99 );
		add_action( 'current_screen', array( $this, 'redirect_native_list_screens' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'in_admin_header', array( $this, 'hide_admin_notices' ), 1000 );

		add_action( 'wp_ajax_tp_tb_list', array( $this, 'ajax_list' ) );
		add_action( 'wp_ajax_tp_tb_create', array( $this, 'ajax_create' ) );
		add_action( 'wp_ajax_tp_tb_update', array( $this, 'ajax_update' ) );
		add_action( 'wp_ajax_tp_tb_action', array( $this, 'ajax_action' ) );
		add_action( 'wp_ajax_tp_tb_bulk', array( $this, 'ajax_bulk' ) );
	}

	/* -------------------------------------------------------------------------
	 * Config
	 * ---------------------------------------------------------------------- */

	/**
	 * Tab map: tab key => post type.
	 */
	public function get_tabs() {
		$tabs = array(
			'header'    => array(
				'label'     => esc_html__( 'Header', 'mindu-core' ),
				'post_type' => 'tp_header',
				'icon'      => 'dashicons-align-wide',
			),
			'footer'    => array(
				'label'     => esc_html__( 'Footer', 'mindu-core' ),
				'post_type' => 'tp_footer',
				'icon'      => 'dashicons-align-full-width',
			),
			'offcanvas' => array(
				'label'     => esc_html__( 'Offcanvas', 'mindu-core' ),
				'post_type' => 'tp_offcanvas',
				'icon'      => 'dashicons-menu-alt3',
			),
		);

		return apply_filters( 'tp_tb_tabs', $tabs );
	}

	/**
	 * Builder types offered in the Add New / Edit modals.
	 */
	public function get_types( $tab ) {
		$types = array(
			'elementor'        => array(
				'label' => esc_html__( 'Edit with Elementor', 'mindu-core' ),
				'desc'  => esc_html__( 'Design visually with the Elementor builder.', 'mindu-core' ),
				'icon'  => 'dashicons-layout',
			),
			'elementor_canvas' => array(
				'label' => esc_html__( 'Elementor Canvas', 'mindu-core' ),
				'desc'  => esc_html__( 'Elementor on a blank full-width canvas template.', 'mindu-core' ),
				'icon'  => 'dashicons-media-default',
			),
			'editor'           => array(
				'label' => esc_html__( 'WordPress Editor', 'mindu-core' ),
				'desc'  => esc_html__( 'Build with the default WordPress editor.', 'mindu-core' ),
				'icon'  => 'dashicons-edit',
			),
		);

		return apply_filters( 'tp_tb_types', $types, $tab );
	}

	private function get_tab_by_post_type( $post_type ) {
		foreach ( $this->get_tabs() as $key => $tab ) {
			if ( $tab['post_type'] === $post_type ) {
				return $key;
			}
		}
		return '';
	}

	private function page_url( $tab = '' ) {
		$url = admin_url( self::PARENT_SLUG . '&page=' . self::PAGE_SLUG );
		if ( $tab ) {
			$url = add_query_arg( 'tab', $tab, $url );
		}
		return $url;
	}

	/* -------------------------------------------------------------------------
	 * Menu + native screen takeover
	 * ---------------------------------------------------------------------- */

	/**
	 * Remove the auto-added CPT submenus and register the single builder page.
	 * Runs after tp_register_mindu_builder_menu() (priority 9) and core's
	 * _add_post_type_submenus().
	 */
	public function register_menu() {
		foreach ( $this->get_tabs() as $tab ) {
			remove_submenu_page( self::PARENT_SLUG, 'edit.php?post_type=' . $tab['post_type'] );
			remove_submenu_page( self::PARENT_SLUG, 'post-new.php?post_type=' . $tab['post_type'] );
		}

		$this->hook_suffix = add_submenu_page(
			self::PARENT_SLUG,
			esc_html__( 'Theme Builder', 'mindu-core' ),
			esc_html__( 'Theme Builder', 'mindu-core' ),
			'edit_posts',
			self::PAGE_SLUG,
			array( $this, 'render_page' ),
			0
		);
	}

	/**
	 * Send the native edit.php list screens of our CPTs to the custom UI.
	 * Append &tp_classic=1 to reach the native list screen (escape hatch).
	 */
	public function redirect_native_list_screens( $screen ) {
		if ( ! $screen || 'edit' !== $screen->base || ! empty( $_GET['tp_classic'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return;
		}

		$tab = $this->get_tab_by_post_type( $screen->post_type );
		if ( $tab ) {
			wp_safe_redirect( $this->page_url( $tab ) );
			exit;
		}
	}

	/**
	 * Suppress native WP admin notices on the Theme Builder screen only —
	 * the panel has its own toast notification system. Other admin screens
	 * are untouched. Runs on in_admin_header, before the notice actions fire.
	 */
	public function hide_admin_notices() {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

		if ( ! $screen || ! $this->hook_suffix || $screen->id !== $this->hook_suffix ) {
			return;
		}

		remove_all_actions( 'admin_notices' );
		remove_all_actions( 'all_admin_notices' );
		remove_all_actions( 'user_admin_notices' );
		remove_all_actions( 'network_admin_notices' );
	}

	/* -------------------------------------------------------------------------
	 * Assets
	 * ---------------------------------------------------------------------- */

	public function enqueue_assets( $hook_suffix ) {
		if ( $hook_suffix !== $this->hook_suffix ) {
			return;
		}

		$base_url  = plugin_dir_url( dirname( __DIR__, 2 ) . '/mindu-core.php' ) . 'assets/';
		$base_path = dirname( __DIR__, 2 ) . '/assets/';

		wp_enqueue_style(
			'tp-theme-builder',
			$base_url . 'css/theme-builder.css',
			array( 'dashicons' ),
			file_exists( $base_path . 'css/theme-builder.css' ) ? filemtime( $base_path . 'css/theme-builder.css' ) : '1.0.0'
		);

		wp_enqueue_script(
			'tp-theme-builder',
			$base_url . 'js/theme-builder.js',
			array(),
			file_exists( $base_path . 'js/theme-builder.js' ) ? filemtime( $base_path . 'js/theme-builder.js' ) : '1.0.0',
			true
		);

		$requested_tab = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$tabs          = $this->get_tabs();

		$tabs_data  = array();
		$types_data = array();
		foreach ( $tabs as $key => $tab ) {
			$counts             = wp_count_posts( $tab['post_type'] );
			$tabs_data[ $key ]  = array(
				'label' => $tab['label'],
				'icon'  => $tab['icon'],
				'count' => (int) $counts->publish + (int) $counts->draft + (int) $counts->pending,
			);
			$types_data[ $key ] = $this->get_types( $key );
		}

		wp_localize_script(
			'tp-theme-builder',
			'tpTB',
			array(
				'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
				'nonce'      => wp_create_nonce( self::NONCE ),
				'tabs'       => $tabs_data,
				'types'      => $types_data,
				'initialTab' => isset( $tabs[ $requested_tab ] ) ? $requested_tab : 'header',
				'perPage'    => self::PER_PAGE,
				'i18n'       => array(
					'searchPlaceholder'     => __( 'Search templates…', 'mindu-core' ),
					'addNew'                => __( 'Add New', 'mindu-core' ),
					'all'                   => __( 'All', 'mindu-core' ),
					'published'             => __( 'Published', 'mindu-core' ),
					'draft'                 => __( 'Draft', 'mindu-core' ),
					'pending'               => __( 'Pending', 'mindu-core' ),
					'trash'                 => __( 'Trash', 'mindu-core' ),
					'template'              => __( 'Template', 'mindu-core' ),
					'type'                  => __( 'Type', 'mindu-core' ),
					'status'                => __( 'Status', 'mindu-core' ),
					'modified'              => __( 'Modified', 'mindu-core' ),
					'actions'               => __( 'Actions', 'mindu-core' ),
					'edit'                  => __( 'Edit', 'mindu-core' ),
					'editWithElementor'     => __( 'Edit with Elementor', 'mindu-core' ),
					'editDetails'           => __( 'Edit details', 'mindu-core' ),
					'duplicate'             => __( 'Duplicate', 'mindu-core' ),
					'publish'               => __( 'Publish', 'mindu-core' ),
					'switchDraft'           => __( 'Switch to draft', 'mindu-core' ),
					'moveTrash'             => __( 'Move to trash', 'mindu-core' ),
					'restore'               => __( 'Restore', 'mindu-core' ),
					'deleteForever'         => __( 'Delete permanently', 'mindu-core' ),
					'preview'               => __( 'Preview', 'mindu-core' ),
					'cancel'                => __( 'Cancel', 'mindu-core' ),
					'create'                => __( 'Create', 'mindu-core' ),
					'createEdit'            => __( 'Create & Edit', 'mindu-core' ),
					'saveChanges'           => __( 'Save Changes', 'mindu-core' ),
					'nameLabel'             => __( 'Template Name', 'mindu-core' ),
					'namePlaceholder'       => __( 'e.g. Main Header', 'mindu-core' ),
					'nameRequired'          => __( 'Please enter a template name.', 'mindu-core' ),
					'slugLabel'             => __( 'Slug', 'mindu-core' ),
					'slugHelp'              => __( 'The theme selects templates by slug. Change with care.', 'mindu-core' ),
					'typeLabel'             => __( 'Builder / Type', 'mindu-core' ),
					'statusLabel'           => __( 'Status', 'mindu-core' ),
					/* translators: %s: tab label (Header/Footer/Offcanvas) */
					'newTitle'              => __( 'New %s Template', 'mindu-core' ),
					'newSubtitle'           => __( 'Give your template a name and choose how to build it.', 'mindu-core' ),
					/* translators: %s: template title */
					'editTitle'             => __( 'Edit “%s”', 'mindu-core' ),
					'editSubtitle'          => __( 'Update the name, slug, builder type and status.', 'mindu-core' ),
					'confirmTrashTitle'     => __( 'Move to trash?', 'mindu-core' ),
					/* translators: %s: template title */
					'confirmTrashMsg'       => __( '“%s” will be moved to the trash. You can restore it later.', 'mindu-core' ),
					'confirmDeleteTitle'    => __( 'Delete permanently?', 'mindu-core' ),
					/* translators: %s: template title */
					'confirmDeleteMsg'      => __( '“%s” will be deleted permanently. This cannot be undone.', 'mindu-core' ),
					'confirm'               => __( 'Confirm', 'mindu-core' ),
					'delete'                => __( 'Delete', 'mindu-core' ),
					'created'               => __( 'Template created.', 'mindu-core' ),
					'updated'               => __( 'Template updated.', 'mindu-core' ),
					'genericError'          => __( 'Something went wrong. Please try again.', 'mindu-core' ),
					'emptyTitle'            => __( 'No templates yet', 'mindu-core' ),
					/* translators: %s: tab label */
					'emptyMsg'              => __( 'Create your first %s template to get started.', 'mindu-core' ),
					'emptySearchTitle'      => __( 'No results found', 'mindu-core' ),
					'emptySearchMsg'        => __( 'Try a different search or filter.', 'mindu-core' ),
					'emptyTrashTitle'       => __( 'Trash is empty', 'mindu-core' ),
					'emptyTrashMsg'         => __( 'Trashed templates will appear here.', 'mindu-core' ),
					/* translators: 1: first item, 2: last item, 3: total */
					'paginationInfo'        => __( 'Showing %1$s–%2$s of %3$s', 'mindu-core' ),
					'prev'                  => __( 'Previous', 'mindu-core' ),
					'next'                  => __( 'Next', 'mindu-core' ),
					/* translators: %s: number of selected items */
					'selectedCount'         => __( '%s selected', 'mindu-core' ),
					'clearSelection'        => __( 'Clear selection', 'mindu-core' ),
					'selectAll'             => __( 'Select all', 'mindu-core' ),
					/* translators: %s: template title */
					'selectItem'            => __( 'Select “%s”', 'mindu-core' ),
					'confirmBulkTrashTitle' => __( 'Trash selected templates?', 'mindu-core' ),
					/* translators: %s: number of selected items */
					'confirmBulkTrashMsg'   => __( '%s selected templates will be moved to the trash. You can restore them later.', 'mindu-core' ),
					'confirmBulkDeleteTitle' => __( 'Delete selected templates?', 'mindu-core' ),
					/* translators: %s: number of selected items */
					'confirmBulkDeleteMsg'  => __( '%s selected templates will be deleted permanently. This cannot be undone.', 'mindu-core' ),
				),
			)
		);
	}

	/* -------------------------------------------------------------------------
	 * Page shell (everything else is rendered by JS via AJAX)
	 * ---------------------------------------------------------------------- */

	public function render_page() {
		?>
		<div class="wrap tp-tb-wrap">
			<div id="tp-tb-app" class="tp-tb" aria-live="polite">
				<noscript>
					<div class="tp-tb-fallback"><?php esc_html_e( 'Theme Builder requires JavaScript. Please enable it in your browser.', 'mindu-core' ); ?></div>
				</noscript>
				<div class="tp-tb-boot">
					<span class="tp-tb-spinner" aria-hidden="true"></span>
					<?php esc_html_e( 'Loading Theme Builder…', 'mindu-core' ); ?>
				</div>
			</div>
		</div>
		<?php
	}

	/* -------------------------------------------------------------------------
	 * AJAX helpers
	 * ---------------------------------------------------------------------- */

	/**
	 * Verify nonce, resolve + authorize the requested tab. Sends JSON error and
	 * exits on failure; returns [ tab_key, tab_config ] on success.
	 */
	private function guard_request() {
		check_ajax_referer( self::NONCE, 'nonce' );

		$tab_key = isset( $_POST['tab'] ) ? sanitize_key( wp_unslash( $_POST['tab'] ) ) : '';
		$tabs    = $this->get_tabs();

		if ( ! isset( $tabs[ $tab_key ] ) ) {
			wp_send_json_error( array( 'message' => __( 'Invalid request.', 'mindu-core' ) ), 400 );
		}

		$pto = get_post_type_object( $tabs[ $tab_key ]['post_type'] );
		if ( ! $pto || ! current_user_can( $pto->cap->edit_posts ) ) {
			wp_send_json_error( array( 'message' => __( 'You are not allowed to manage these templates.', 'mindu-core' ) ), 403 );
		}

		return array( $tab_key, $tabs[ $tab_key ] );
	}

	/**
	 * Resolve a post that belongs to the given tab's post type, or bail.
	 */
	private function guard_post( $tab ) {
		$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
		$post    = $post_id ? get_post( $post_id ) : null;

		if ( ! $post || $post->post_type !== $tab['post_type'] ) {
			wp_send_json_error( array( 'message' => __( 'Template not found.', 'mindu-core' ) ), 404 );
		}

		return $post;
	}

	/**
	 * Effective builder type of a post. Falls back to the legacy meta key and,
	 * for templates created before this UI existed, to Elementor's edit-mode
	 * meta. Unknown stored types map onto the closest current type.
	 */
	private function resolve_type( $post, $tab_key ) {
		$type = get_post_meta( $post->ID, self::TYPE_META, true );
		if ( ! $type ) {
			$type = get_post_meta( $post->ID, self::LEGACY_TYPE_META, true );
		}

		$types = $this->get_types( $tab_key );
		if ( isset( $types[ $type ] ) ) {
			return $type;
		}

		if ( $type ) {
			return $this->is_elementor_type( $type ) ? 'elementor' : 'editor';
		}

		return 'builder' === get_post_meta( $post->ID, '_elementor_edit_mode', true ) ? 'elementor' : 'editor';
	}

	private function is_elementor_type( $type ) {
		return in_array( $type, array( 'elementor', 'elementor_canvas', 'elementor_offcanvas' ), true );
	}

	/**
	 * Apply the meta that makes a builder type functional: Elementor edit mode
	 * and the Elementor Canvas page template.
	 */
	private function apply_type_meta( $post_id, $type ) {
		update_post_meta( $post_id, self::TYPE_META, $type );

		if ( $this->is_elementor_type( $type ) ) {
			update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
			if ( ! get_post_meta( $post_id, '_elementor_template_type', true ) ) {
				update_post_meta( $post_id, '_elementor_template_type', 'wp-post' );
			}
			if ( defined( 'ELEMENTOR_VERSION' ) && ! get_post_meta( $post_id, '_elementor_version', true ) ) {
				update_post_meta( $post_id, '_elementor_version', ELEMENTOR_VERSION );
			}
		} else {
			update_post_meta( $post_id, '_elementor_edit_mode', 'editor' );
		}

		if ( 'elementor_canvas' === $type ) {
			update_post_meta( $post_id, '_wp_page_template', 'elementor_canvas' );
		} else {
			delete_post_meta( $post_id, '_wp_page_template' );
		}
	}

	/**
	 * Serialize one post row for the JS app.
	 */
	private function format_row( $post, $tab_key, $tab ) {
		$type  = $this->resolve_type( $post, $tab_key );
		$types = $this->get_types( $tab_key );

		$status_labels = array(
			'publish' => __( 'Published', 'mindu-core' ),
			'draft'   => __( 'Draft', 'mindu-core' ),
			'pending' => __( 'Pending', 'mindu-core' ),
			'trash'   => __( 'Trash', 'mindu-core' ),
		);

		$is_elementor = $this->is_elementor_type( $type );

		return array(
			'id'          => $post->ID,
			'title'       => $post->post_title ? $post->post_title : __( '(no title)', 'mindu-core' ),
			'slug'        => $post->post_name,
			'type'        => $type,
			'typeLabel'   => isset( $types[ $type ] ) ? $types[ $type ]['label'] : ucfirst( $type ),
			'typeIcon'    => isset( $types[ $type ] ) ? $types[ $type ]['icon'] : 'dashicons-edit',
			'isElementor' => $is_elementor,
			'status'      => $post->post_status,
			'statusLabel' => isset( $status_labels[ $post->post_status ] ) ? $status_labels[ $post->post_status ] : $post->post_status,
			'modified'    => date_i18n( get_option( 'date_format' ), get_post_timestamp( $post, 'modified' ) ),
			/* translators: %s: human-readable time difference */
			'modifiedAgo' => sprintf( __( '%s ago', 'mindu-core' ), human_time_diff( get_post_timestamp( $post, 'modified' ) ) ),
			'editUrl'     => $is_elementor
				? admin_url( 'post.php?post=' . $post->ID . '&action=elementor' )
				: get_edit_post_link( $post->ID, 'raw' ),
			'previewUrl'  => get_permalink( $post ),
			'canEdit'     => current_user_can( 'edit_post', $post->ID ),
			'canDelete'   => current_user_can( 'delete_post', $post->ID ),
		);
	}

	/**
	 * Status counts + tab counts, sent with every response so the UI chips
	 * stay in sync after mutations.
	 */
	private function get_counts() {
		$out = array();
		foreach ( $this->get_tabs() as $key => $tab ) {
			$counts      = wp_count_posts( $tab['post_type'] );
			$out[ $key ] = array(
				'all'     => (int) $counts->publish + (int) $counts->draft + (int) $counts->pending,
				'publish' => (int) $counts->publish,
				'draft'   => (int) $counts->draft,
				'pending' => (int) $counts->pending,
				'trash'   => (int) $counts->trash,
			);
		}
		return $out;
	}

	/* -------------------------------------------------------------------------
	 * AJAX: list
	 * ---------------------------------------------------------------------- */

	public function ajax_list() {
		list( $tab_key, $tab ) = $this->guard_request();

		$status = isset( $_POST['status'] ) ? sanitize_key( wp_unslash( $_POST['status'] ) ) : 'all';
		if ( ! in_array( $status, array( 'all', 'publish', 'draft', 'trash' ), true ) ) {
			$status = 'all';
		}

		$search = isset( $_POST['search'] ) ? sanitize_text_field( wp_unslash( $_POST['search'] ) ) : '';
		$paged  = isset( $_POST['paged'] ) ? max( 1, absint( $_POST['paged'] ) ) : 1;

		$query = new WP_Query(
			array(
				'post_type'      => $tab['post_type'],
				'post_status'    => 'all' === $status ? array( 'publish', 'draft', 'pending' ) : $status,
				's'              => $search,
				'paged'          => $paged,
				'posts_per_page' => self::PER_PAGE,
				'orderby'        => 'modified',
				'order'          => 'DESC',
			)
		);

		$rows = array();
		foreach ( $query->posts as $post ) {
			$rows[] = $this->format_row( $post, $tab_key, $tab );
		}

		wp_send_json_success(
			array(
				'rows'       => $rows,
				'total'      => (int) $query->found_posts,
				'totalPages' => (int) $query->max_num_pages,
				'paged'      => $paged,
				'counts'     => $this->get_counts(),
			)
		);
	}

	/* -------------------------------------------------------------------------
	 * AJAX: create
	 * ---------------------------------------------------------------------- */

	public function ajax_create() {
		list( $tab_key, $tab ) = $this->guard_request();

		$pto = get_post_type_object( $tab['post_type'] );
		if ( ! current_user_can( $pto->cap->create_posts ) ) {
			wp_send_json_error( array( 'message' => __( 'You are not allowed to create templates.', 'mindu-core' ) ), 403 );
		}

		$title = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
		if ( '' === $title ) {
			wp_send_json_error( array( 'message' => __( 'Please enter a template name.', 'mindu-core' ) ), 400 );
		}

		$type  = isset( $_POST['type'] ) ? sanitize_key( wp_unslash( $_POST['type'] ) ) : '';
		$types = $this->get_types( $tab_key );
		if ( ! isset( $types[ $type ] ) ) {
			wp_send_json_error( array( 'message' => __( 'Invalid builder type.', 'mindu-core' ) ), 400 );
		}

		$post_id = wp_insert_post(
			array(
				'post_title'  => $title,
				'post_type'   => $tab['post_type'],
				'post_status' => 'publish',
			),
			true
		);

		if ( is_wp_error( $post_id ) ) {
			wp_send_json_error( array( 'message' => $post_id->get_error_message() ), 500 );
		}

		$this->apply_type_meta( $post_id, $type );

		wp_send_json_success(
			array(
				'message' => __( 'Template created.', 'mindu-core' ),
				'row'     => $this->format_row( get_post( $post_id ), $tab_key, $tab ),
				'counts'  => $this->get_counts(),
			)
		);
	}

	/* -------------------------------------------------------------------------
	 * AJAX: update (title / slug / type / status — any subset)
	 * ---------------------------------------------------------------------- */

	public function ajax_update() {
		list( $tab_key, $tab ) = $this->guard_request();
		$post = $this->guard_post( $tab );

		if ( ! current_user_can( 'edit_post', $post->ID ) ) {
			wp_send_json_error( array( 'message' => __( 'You are not allowed to edit this template.', 'mindu-core' ) ), 403 );
		}

		$update = array( 'ID' => $post->ID );

		if ( isset( $_POST['title'] ) ) {
			$title = sanitize_text_field( wp_unslash( $_POST['title'] ) );
			if ( '' === $title ) {
				wp_send_json_error( array( 'message' => __( 'Template name cannot be empty.', 'mindu-core' ) ), 400 );
			}
			$update['post_title'] = $title;
		}

		if ( isset( $_POST['slug'] ) ) {
			$slug = sanitize_title( wp_unslash( $_POST['slug'] ) );
			if ( $slug && $slug !== $post->post_name ) {
				$update['post_name'] = wp_unique_post_slug( $slug, $post->ID, $post->post_status, $post->post_type, $post->post_parent );
			}
		}

		if ( isset( $_POST['status'] ) ) {
			$status = sanitize_key( wp_unslash( $_POST['status'] ) );
			if ( in_array( $status, array( 'publish', 'draft' ), true ) ) {
				$update['post_status'] = $status;
			}
		}

		if ( count( $update ) > 1 ) {
			$result = wp_update_post( $update, true );
			if ( is_wp_error( $result ) ) {
				wp_send_json_error( array( 'message' => $result->get_error_message() ), 500 );
			}
		}

		if ( isset( $_POST['type'] ) ) {
			$type  = sanitize_key( wp_unslash( $_POST['type'] ) );
			$types = $this->get_types( $tab_key );
			if ( isset( $types[ $type ] ) && $type !== $this->resolve_type( $post, $tab_key ) ) {
				$this->apply_type_meta( $post->ID, $type );
			}
		}

		wp_send_json_success(
			array(
				'message' => __( 'Template updated.', 'mindu-core' ),
				'row'     => $this->format_row( get_post( $post->ID ), $tab_key, $tab ),
				'counts'  => $this->get_counts(),
			)
		);
	}

	/* -------------------------------------------------------------------------
	 * AJAX: single-row management actions (trash / restore / delete / duplicate)
	 * ---------------------------------------------------------------------- */

	public function ajax_action() {
		list( $tab_key, $tab ) = $this->guard_request();
		$post = $this->guard_post( $tab );

		$op = isset( $_POST['op'] ) ? sanitize_key( wp_unslash( $_POST['op'] ) ) : '';

		switch ( $op ) {

			case 'trash':
				$this->require_cap( 'delete_post', $post->ID );
				if ( ! wp_trash_post( $post->ID ) ) {
					$this->bail_generic();
				}
				$this->send_action_response( __( 'Template moved to trash.', 'mindu-core' ) );
				break;

			case 'restore':
				$this->require_cap( 'delete_post', $post->ID );
				if ( ! wp_untrash_post( $post->ID ) ) {
					$this->bail_generic();
				}
				// Untrash defaults to draft since WP 5.6 — restore to publish
				// to match what the user had before trashing in this UI.
				wp_publish_post( $post->ID );
				$this->send_action_response( __( 'Template restored.', 'mindu-core' ) );
				break;

			case 'delete':
				$this->require_cap( 'delete_post', $post->ID );
				if ( ! wp_delete_post( $post->ID, true ) ) {
					$this->bail_generic();
				}
				$this->send_action_response( __( 'Template deleted permanently.', 'mindu-core' ) );
				break;

			case 'duplicate':
				$this->require_cap( 'edit_post', $post->ID );
				$new_id = $this->duplicate_post( $post );
				if ( is_wp_error( $new_id ) ) {
					wp_send_json_error( array( 'message' => $new_id->get_error_message() ), 500 );
				}
				$this->send_action_response( __( 'Template duplicated.', 'mindu-core' ) );
				break;

			default:
				wp_send_json_error( array( 'message' => __( 'Invalid action.', 'mindu-core' ) ), 400 );
		}
	}

	/* -------------------------------------------------------------------------
	 * AJAX: bulk actions (trash / restore / delete)
	 * ---------------------------------------------------------------------- */

	public function ajax_bulk() {
		list( , $tab ) = $this->guard_request();

		$op = isset( $_POST['op'] ) ? sanitize_key( wp_unslash( $_POST['op'] ) ) : '';
		if ( ! in_array( $op, array( 'trash', 'restore', 'delete' ), true ) ) {
			wp_send_json_error( array( 'message' => __( 'Invalid action.', 'mindu-core' ) ), 400 );
		}

		$ids = isset( $_POST['ids'] ) ? array_filter( array_map( 'absint', (array) wp_unslash( $_POST['ids'] ) ) ) : array();
		if ( empty( $ids ) ) {
			wp_send_json_error( array( 'message' => __( 'No templates selected.', 'mindu-core' ) ), 400 );
		}

		$done   = 0;
		$failed = 0;

		foreach ( $ids as $post_id ) {
			$post = get_post( $post_id );

			if ( ! $post || $post->post_type !== $tab['post_type'] || ! current_user_can( 'delete_post', $post_id ) ) {
				$failed++;
				continue;
			}

			switch ( $op ) {
				case 'trash':
					$result = wp_trash_post( $post_id );
					break;
				case 'restore':
					$result = wp_untrash_post( $post_id );
					if ( $result ) {
						wp_publish_post( $post_id );
					}
					break;
				default:
					$result = wp_delete_post( $post_id, true );
			}

			if ( $result ) {
				$done++;
			} else {
				$failed++;
			}
		}

		if ( 0 === $done ) {
			wp_send_json_error( array( 'message' => __( 'The selected templates could not be processed.', 'mindu-core' ) ), 500 );
		}

		switch ( $op ) {
			case 'trash':
				/* translators: %s: number of templates */
				$message = sprintf( _n( '%s template moved to trash.', '%s templates moved to trash.', $done, 'mindu-core' ), number_format_i18n( $done ) );
				break;
			case 'restore':
				/* translators: %s: number of templates */
				$message = sprintf( _n( '%s template restored.', '%s templates restored.', $done, 'mindu-core' ), number_format_i18n( $done ) );
				break;
			default:
				/* translators: %s: number of templates */
				$message = sprintf( _n( '%s template deleted permanently.', '%s templates deleted permanently.', $done, 'mindu-core' ), number_format_i18n( $done ) );
		}

		if ( $failed ) {
			/* translators: %s: number of templates */
			$message .= ' ' . sprintf( _n( '%s failed.', '%s failed.', $failed, 'mindu-core' ), number_format_i18n( $failed ) );
		}

		wp_send_json_success(
			array(
				'message' => $message,
				'done'    => $done,
				'failed'  => $failed,
				'counts'  => $this->get_counts(),
			)
		);
	}

	/* -------------------------------------------------------------------------
	 * Internals
	 * ---------------------------------------------------------------------- */

	private function require_cap( $cap, $post_id ) {
		if ( ! current_user_can( $cap, $post_id ) ) {
			wp_send_json_error( array( 'message' => __( 'You are not allowed to do that.', 'mindu-core' ) ), 403 );
		}
	}

	private function bail_generic() {
		wp_send_json_error( array( 'message' => __( 'Something went wrong. Please try again.', 'mindu-core' ) ), 500 );
	}

	private function send_action_response( $message ) {
		wp_send_json_success(
			array(
				'message' => $message,
				'counts'  => $this->get_counts(),
			)
		);
	}

	/**
	 * Duplicate a template including all meta (Elementor data is slashed so
	 * its JSON survives wp_insert_post/add_post_meta stripslashes).
	 *
	 * @return int|WP_Error New post ID.
	 */
	private function duplicate_post( $post ) {
		$new_id = wp_insert_post(
			array(
				/* translators: %s: original template title */
				'post_title'   => sprintf( __( '%s (Copy)', 'mindu-core' ), $post->post_title ),
				'post_type'    => $post->post_type,
				'post_status'  => 'draft',
				'post_content' => wp_slash( $post->post_content ),
			),
			true
		);

		if ( is_wp_error( $new_id ) ) {
			return $new_id;
		}

		$skip = array( '_edit_lock', '_edit_last', '_wp_old_slug' );
		$meta = get_post_meta( $post->ID );

		foreach ( $meta as $key => $values ) {
			if ( in_array( $key, $skip, true ) ) {
				continue;
			}
			foreach ( $values as $value ) {
				add_post_meta( $new_id, $key, wp_slash( maybe_unserialize( $value ) ) );
			}
		}

		return $new_id;
	}
}

TP_Theme_Builder::instance();
