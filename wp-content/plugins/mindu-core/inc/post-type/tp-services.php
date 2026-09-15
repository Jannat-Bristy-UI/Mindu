<?php

function services_single_template( $template ) {

	if ( is_singular( 'tp-services' ) ) {

		$new_template = __DIR__ . '/single-service.php';

		if ( file_exists( $new_template ) ) {
			return $new_template;
		}
	}

	return $template;
}

add_filter( 'template_include', 'services_single_template', 99 );



/**
 * Register Services Post Type & Service Category.
 */
function tp_register_services_post_type() {

	// Service Post Type.
	$service_labels = array(
		'name'               => __( 'Services', 'text-domain' ),
		'singular_name'      => __( 'Service', 'text-domain' ),
		'menu_name'          => __( 'Services', 'text-domain' ),
		'add_new'            => __( 'Add New', 'text-domain' ),
		'add_new_item'       => __( 'Add New Service', 'text-domain' ),
		'edit_item'          => __( 'Edit Service', 'text-domain' ),
		'new_item'           => __( 'New Service', 'text-domain' ),
		'view_item'          => __( 'View Service', 'text-domain' ),
		'search_items'       => __( 'Search Services', 'text-domain' ),
		'not_found'          => __( 'No services found.', 'text-domain' ),
		'not_found_in_trash' => __( 'No services found in Trash.', 'text-domain' ),
	);

	$service_args = array(
		'labels'             => $service_labels,
		'public'             => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'has_archive'        => true,
		'rewrite'            => array(
			'slug' => 'services',
		),
		'supports'           => array(
			'title',
			'editor',
			'thumbnail',
			'excerpt',
		),
		'menu_icon'          => 'dashicons-admin-tools',
	);

	register_post_type( 'tp-services', $service_args );


	// Service Category Taxonomy.
	$category_labels = array(
		'name'              => __( 'Service Categories', 'text-domain' ),
		'singular_name'     => __( 'Service Category', 'text-domain' ),
		'search_items'      => __( 'Search Service Categories', 'text-domain' ),
		'all_items'         => __( 'All Service Categories', 'text-domain' ),
		'parent_item'       => __( 'Parent Service Category', 'text-domain' ),
		'parent_item_colon' => __( 'Parent Service Category:', 'text-domain' ),
		'edit_item'         => __( 'Edit Service Category', 'text-domain' ),
		'update_item'       => __( 'Update Service Category', 'text-domain' ),
		'add_new_item'      => __( 'Add New Service Category', 'text-domain' ),
		'new_item_name'     => __( 'New Service Category Name', 'text-domain' ),
		'menu_name'         => __( 'Categories', 'text-domain' ),
	);

	$category_args = array(
		'labels'            => $category_labels,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'hierarchical'      => true,
		'rewrite'           => array(
			'slug' => 'service-category',
		),
	);

	register_taxonomy(
		'service-cat',
		array( 'tp-services' ),
		$category_args
	);
}
add_action( 'init', 'tp_register_services_post_type' );