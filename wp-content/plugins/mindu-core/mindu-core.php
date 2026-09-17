<?php
/**
 * Plugin Name: Mindu Core
 * Description: Mindu core plugin for mindu theme.
 * Version:     1.0.0
 * Author:      Elementor Developer
 * Author URI:  https://developers.elementor.com/
 * Text Domain: mindu-core
 *
 * Requires Plugins: elementor
 * Elementor tested up to: 3.25.0
 * Elementor Pro tested up to: 3.25.0
*/


// ==================== Core Components ====================

// Load Core Helper Files
require_once( __DIR__ . '/inc/plugin-helper.php' );
require_once( __DIR__ . '/inc/breadcrumb.php' );


// Register Post Types Part files
require_once( __DIR__ . '/inc/post-type/tp-services.php');
require_once( __DIR__ . '/inc/post-type/header-post-type.php' );
require_once( __DIR__ . '/inc/post-type/footer-post-type.php' );
require_once( __DIR__ . '/inc/post-type/offcanvas-type.php' );
require_once( __DIR__ . '/inc/post-type/mindu-builder-menu.php' ); 


// theme builder admin UI (header / footer / offcanvas)
require_once( __DIR__ . '/inc/settings/theme-builder.php' );


// Load Trait files (Content & Style)
require_once( __DIR__ . '/inc/trait/common-trait.php' );
require_once( __DIR__ . '/inc/trait/common-icon.php' );
require_once( __DIR__ . '/inc/trait/content-trait/hero-content-trait.php' );
	
require_once( __DIR__ . '/inc/trait/style-trait/typo-style-trait.php' );
require_once( __DIR__ . '/inc/trait/style-trait/button-style-trait.php' );
require_once( __DIR__ . '/inc/trait/style-trait/icon-style-trait.php' );



// ==================== Register Elementor Widgets ====================

function register_mindu_widget( $widgets_manager ) {

	// Load Widgets Files
	require_once( __DIR__ . '/widgets/header-search.php' );
	require_once( __DIR__ . '/widgets/icon-list.php' );
	require_once( __DIR__ . '/widgets/header-menu.php' );
	require_once( __DIR__ . '/widgets/header-offcanvas.php' );
	require_once( __DIR__ . '/widgets/header-language.php' );
	require_once( __DIR__ . '/widgets/heading.php' );
	require_once( __DIR__ . '/widgets/hero.php' );
	require_once( __DIR__ . '/widgets/icon-box.php' );
	require_once( __DIR__ . '/widgets/image-box.php' );
	require_once( __DIR__ . '/widgets/image-flip.php' );
	require_once( __DIR__ . '/widgets/brand.php' );
	require_once( __DIR__ . '/widgets/button.php' );
	require_once( __DIR__ . '/widgets/team.php' );
	require_once( __DIR__ . '/widgets/team-slider.php' );
	require_once( __DIR__ . '/widgets/testimonial.php' );
	require_once( __DIR__ . '/widgets/faq.php' );
	require_once( __DIR__ . '/widgets/video.php' );
	require_once( __DIR__ . '/widgets/icon.php' );
	require_once( __DIR__ . '/widgets/blog-post.php' );
}

add_action( 'elementor/widgets/register', 'register_mindu_widget' );









function mindu_widget_categories( $elements_manager ) {

	$elements_manager->add_category(
		'mindu-category',
		[
			'title' => esc_html__( 'Mindu Category', 'textdomain' ),
			'icon' => 'fa fa-plug',
		]
	);


}
add_action( 'elementor/elements/categories_registered', 'mindu_widget_categories' );

