<?php


//============ By Elementor -> Render Site Header & Footer ================ 
    /**
     * Source:
     * - tpmeta_field() → Pure Metafields Plugin
     * - Elementor\Plugin → Elementor
     * - get_template_part() → WordPress Core
    */

    // Function to display the site header.
    function mindu_header(){
        $tp_page_header = function_exists('tpmeta_field') ? tpmeta_field('tp_page_header') : '';
        
        // "Header যদি Object হিসেবে আসে, তাহলে Object-এর ভিতর থেকে ID নাও। আর যদি সরাসরি ID আসে, তাহলে সেটাকে integer বানিয়ে নাও।"
        $header_id = is_object($tp_page_header) ? $tp_page_header->ID : (int) $tp_page_header;

        // চেক করা হচ্ছে Elementor Plugin Active আছে কিনা এবং Header ID সঠিক আছে কিনা।
        // দুটোই ঠিক থাকলে Elementor Header দেখানো হবে, না হলে Theme-এর Default Header দেখানো হবে।     
        if ( class_exists( '\Elementor\Plugin' ) && $header_id ) {
            echo \Elementor\Plugin::$instance->frontend->get_builder_content( $header_id, true );
        } else {
            get_template_part( 'template-parts/header/header-1' );
        } 

    }

    // mindu_before_header hook চালু হলে mindu_header() function-টি চালানো হবে। 
    add_action('mindu_before_header', 'mindu_header');


    // Function to display the site footer.
    function mindu_footer(){

        $tp_page_footer = function_exists('tpmeta_field') ? tpmeta_field('tp_page_footer') : '';
        
        $footer_id = is_object($tp_page_footer) ? $tp_page_footer->ID : (int) $tp_page_footer;

        if ( class_exists( '\Elementor\Plugin' ) && $footer_id ) {
            echo \Elementor\Plugin::$instance->frontend->get_builder_content( $footer_id, true );
        } else {
            get_template_part( 'template-parts/footer/footer-1' );
        }   
    }

// Function End -----



//============ Customizer → Render global Header Logo  ====================

    // Main Header Logo Dynamic function
    function header_logo() {
        
        global $mindu;
        $header_logo = $mindu['header-logo']['url'] ?? get_template_directory_uri(). '/assets/img/logo/logo.png'; // Fallback to default logo if not set
        ?>

        <a href="<?php echo home_url(); ?>">
            <img width="85" src="<?php echo esc_url($header_logo); ?>" alt="<?php echo get_bloginfo(); ?>">
        </a>

        <?php
    }


    //Transparent Header Logo Dynamic function
    function header_transparent_logo() {
        
        global $mindu;
        $header_logo = $mindu['header-logo']['url'] ?? get_template_directory_uri(). '/assets/img/logo/logo.png'; // Fallback to default logo if not set
        $header_logo_white = $mindu['header-logo-white']['url'] ?? get_template_directory_uri(). '/assets/img/logo/logo-white.png'; // Fallback to default white logo if not set
        ?>

        <a href="<?php echo home_url(); ?>">
            <img class="logo-1" width="85" src="<?php echo esc_url($header_logo_white); ?>" alt="<?php echo get_bloginfo(); ?>">
            <img class="logo-2 d-none" width="85" src="<?php echo esc_url($header_logo); ?>" alt="<?php echo get_bloginfo(); ?>">
        </a>


        <?php
    }

// Function End -----


// Function to display dynamic footer copyright using Customizer variables
function mindu_footer_copyright() {
    global $mindu;
    $footer_copyright = $mindu['footer-copyright'] ?? __( '© 2026 Copyrights by aqlova Co. All Rights Reserved. Developed by ThemePure', 'mindu' ); // Fallback to default copyright if not set    
    
    ?>
    <p class="mb-0"><?php echo esc_html($footer_copyright); ?></p>
    <?php
}



// Header_main_menu Dynamic function
function header_main_menu() {
    wp_nav_menu( array(
        'theme_location' => 'main-menu',
        'container' => '',
        'menu_class' => '',
        'fallback_cb' => 'Mindu_Walker_Nav_Menu ::fallback',
        'walker' => new Mindu_Walker_Nav_Menu, 
    ) );
}


// Footer_menu Dynamic function
function footer_menu() {
    wp_nav_menu( array(
        'theme_location' => 'footer-menu',
        'container' => '',
        'menu_class' => '',
    ) );
}


// Language_menu Dynamic function
function language_menu() {
    wp_nav_menu( array(
        'theme_location' => 'lang-menu',
        'container' => '',
        'menu_class' => '',
    ) );
}



// mindu_pagination For Blog Page
function mindu_blog_pagination() {

    $pages = paginate_links( array(
        'type' => 'array',

        'prev_text' => __(
            '<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.75 5.75H0.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M5.75 10.75L0.75 5.75L5.75 0.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>',
            'mindu'
        ),

        'next_text' => __(
            '<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.75 5.75H10.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M5.75 10.75L10.75 5.75L5.75 0.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>',
            'mindu'
        ),
    ) );

    if ( $pages ) {
        echo '<ul class="tp-pagination">';
        
        foreach ( $pages as $page ) {
            echo '<li>' . $page . '</li>';
        }

        echo '</ul>';
    }
}



/**
 * Generate custom search form
 *
 * @param string $form Form HTML.
 * @return string Modified form HTML.
 */
function mindu_search_form( $form ) {
	$form = '
        <div class="tp-sidebar-search p-relative mb-40">
            <form role="search" method="get" action="' . home_url( '/' ) . '">
                <input name="s" value="' . get_search_query() . '" class="tp-input" type="text" placeholder="Search ...">
                <button class="tp-sidebar-search-btn" type="submit" >
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.97222 13.1944C10.4087 13.1944 13.1944 10.4087 13.1944 6.97222C13.1944 3.53578 10.4087 0.75 6.97222 0.75C3.53578 0.75 0.75 3.53578 0.75 6.97222C0.75 10.4087 3.53578 13.1944 6.97222 13.1944Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M14.75 14.7502L11.3667 11.3669" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </form>
        </div>
    ';

	return $form;
}
add_filter( 'get_search_form', 'mindu_search_form' );


// Tag Dynamic function for blog post
function mindu_post_tag(){
    $tags = get_the_tags();
    ?>

    <?php foreach($tags as $tag) : ?>   
        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"><?php echo esc_html($tag->name); ?></a>
    <?php endforeach; ?>

   <?php
}






