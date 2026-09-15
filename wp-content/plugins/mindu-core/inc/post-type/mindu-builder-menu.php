<?php
/**
 * Registers the "Mindu Builder" top-level admin menu.
 *
 * The tp_header, tp_footer and tp_offcanvas post types point their
 * `show_in_menu` at this menu's slug (edit.php?post_type=tp_header), so
 * WordPress core adds their list screens as submenus automatically via
 * _add_post_type_submenus(). Clicking the parent opens the Headers list.
 */
function tp_register_mindu_builder_menu() {

	add_menu_page(
		esc_html__( 'Mindu Builder', 'tp-core' ),
		esc_html__( 'Mindu Builder', 'tp-core' ),
		'edit_posts',
		'edit.php?post_type=tp_header',
		'',
		'dashicons-layout',
		58
	);

}
add_action( 'admin_menu', 'tp_register_mindu_builder_menu', 9 );