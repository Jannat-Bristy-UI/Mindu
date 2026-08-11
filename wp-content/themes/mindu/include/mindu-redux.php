<?php

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    $opt_name = 'mindu';

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        'display_name'         => $theme->get( 'Name' ),
        'display_version'      => $theme->get( 'Version' ),
        'menu_title'           => esc_html__( 'Mindu Options', 'mindu' ),
        'customizer'           => true,
    );

    Redux::set_args( $opt_name, $args );




    // Section-1 (Header Info options)
    Redux::set_section( 
        $opt_name, 
        array(
            'title'  => esc_html__( 'Header Info', 'mindu' ),
            'id'     => 'header-info-options',
            'desc'   => esc_html__( 'All header info options here.', 'mindu' ),
            'icon'   => 'el el-home',
            'fields' => array(

                // Header Switch fields
                array(
                    'id'       => 'header-top-switcher',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Display Header Info', 'mindu'),
                    'default' => true,                    
                ),

                array(
                    'id'       => 'header-right-switcher',
                    'type'     => 'switch', 
                    'title'    => esc_html__('Display Header Right Content', 'mindu'),
                    'default' => true,                    
                ),



                array(
                    'id'       => 'header-phone',
                    'type'     => 'text', 
                    'title'    => esc_html__('Header Phone Number', 'mindu'),
                    'default' => esc_html__('+256 856 963', 'mindu'),
                    'hint'  => array(
                        'content' => 'If you remove phone number text, the button will not be displayed.',
                    ),                       
                ),


                array(
                    'id'       => 'header-mail',
                    'type'     => 'text', 
                    'title'    => esc_html__('Header Email', 'mindu'),
                    'default' => esc_html__('mindu@gmail.com', 'mindu'),
                    'hint'  => array(
                        'content' => 'If you remove email address text, the button will not be displayed.',
                    ),                       
                ),

                array(
                    'id'       => 'header-time',
                    'type'     => 'text', 
                    'title'    => esc_html__('Header Time', 'mindu'),
                    'default' => esc_html__('Open for Learning: Mon - Sat 8.00 - 18.00', 'mindu'),
                    'hint'  => array(
                        'content' => 'If you remove time text, the button will not be displayed.',
                    ),                       
                )

            )
        ) 
    );



    // Section-2 (Header Logo options)
    Redux::set_section( 
        $opt_name, 
        array(
            'title'  => esc_html__( 'Header Logo', 'mindu' ),
            'id'     => 'header-logo-options',
            'desc'   => esc_html__( 'All header logo options here.', 'mindu' ),
            'icon'   => 'el el-home',
            'fields' => array(
                array(
                    'id'       => 'header-logo',
                    'type'     => 'media', 
                    'url'      => true,
                    'title'    => esc_html__('Header Black Logo', 'mindu'),
                    'desc'     => esc_html__('Please upload your black logo.', 'mindu'),
                    'subtitle' => esc_html__('Upload any media using the WordPress native uploader', 'mindu'),
                    'default'  => array(
                        'url'=> get_template_directory_uri() . '/assets/img/logo/logo.png'
                    ),                           
                ),

                array(
                    'id'       => 'header-logo-white',
                    'type'     => 'media', 
                    'url'      => true,
                    'title'    => esc_html__('Header white Logo', 'mindu'),
                    'desc'     => esc_html__('Please upload your white logo.', 'mindu'),
                    'subtitle' => esc_html__('Upload any media using the WordPress native uploader', 'mindu'),
                    'default'  => array(
                        'url'=> get_template_directory_uri() . '/assets/img/logo/logo-white.png'
                    ),                           
                )

            )
        ) 
    );



    // Section-3 (Header Button options)
    Redux::set_section( 
        $opt_name, 
        array(
            'title'  => esc_html__( 'Header Button', 'mindu' ),
            'id'     => 'header-button-options',
            'desc'   => esc_html__( 'All header button options here.', 'mindu' ),
            'icon'   => 'el el-home',
            'fields' => array(

                array(
                    'id'       => 'header-button-text',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Button Text', 'mindu' ),
                    'desc'     => esc_html__( 'Button text here.', 'mindu' ),
                    'subtitle' => esc_html__( 'Button text here.', 'mindu' ),
                    'default' => esc_html__( 'Login', 'mindu' ),
                    'hint'     => array(
                        'content' => 'If you remove button text, the button will not be displayed.',
                    ),
                ),

                array(
                    'id'       => 'header-button-url',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Button URL', 'mindu' ),
                    'desc'     => esc_html__( 'Enter the button URL here.', 'mindu' ),
                    'subtitle' => esc_html__( 'Button URL here.', 'mindu' ),
                )

            )
        ) 
    );



    // Section-4 (Header Offcanvas options)
    Redux::set_section( 
        $opt_name, 
        array(
            'title'  => esc_html__( 'Header Offcanvas', 'mindu' ),
            'id'     => 'header-offcanvas-options',
            'desc'   => esc_html__( 'All header offcanvas options here.', 'mindu' ),
            'icon'   => 'el el-home',
            'fields' => array(

                array(
                    'id'       => 'offcanvas-content',
                    'type'     => 'textarea',
                    'title'    => esc_html__( 'Offcanvas Content', 'mindu' ),
                    'default' => esc_html__( 'Lorem ipsum dolor sit amet, consect etur adipiscing elit.', 'mindu' ),
                ),

                array(
                    'id'       => 'offcanvas-gallery',
                    'type'     => 'gallery',
                    'title'    => esc_html__( 'Offcanvas Gallery', 'mindu' ),
                    'desc'     => esc_html__( 'You can set offcanvas gallery from here.', 'mindu' ),
                ),

                array(
                    'id'       => 'offcanvas-phone',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Offcanvas Phone', 'mindu' ),
                    'default'  => esc_html__( '+42077001007', 'mindu' ),
                ),

                array(
                    'id'       => 'offcanvas-mail',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Offcanvas Email', 'mindu' ),
                    'default'  => esc_html__( 'info@mindu.com', 'mindu' ),
                ),

                array(
                    'id'       => 'offcanvas-address',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Offcanvas Address', 'mindu' ),
                    'default'  => esc_html__( '123 Main Street, City, Country', 'mindu' ),
                ),

                array(
                    'id'       => 'offcanvas-address-url',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Offcanvas Address URL', 'mindu' ),
                    'default'  => esc_html__( '#', 'mindu' ),
                ),

                array(
                    'id'       => 'offcanvas-fb-url',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Offcanvas Facebook URL', 'mindu' ),
                    'default'  => esc_html__( '#', 'mindu' ),
                ),

                array(
                    'id'       => 'offcanvas-x-url',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Offcanvas Twitter URL', 'mindu' ),
                    'default'  => esc_html__( '#', 'mindu' ),
                ),

                array(
                    'id'       => 'offcanvas-dr-url',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Offcanvas Dribbble URL', 'mindu' ),
                    'default'  => esc_html__( '#', 'mindu' ),
                ),

                array(
                    'id'       => 'offcanvas-inst-url',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Offcanvas Instagram URL', 'mindu' ),
                    'default'  => esc_html__( '#', 'mindu' ),
                )

            )
        ) 
    );



    // Section-5 (Footer options)
    Redux::set_section( 
        $opt_name, 
        array(
            'title'  => esc_html__( 'Footer Options', 'mindu' ),
            'id'     => 'footer-options',
            'desc'   => esc_html__( 'All footer options here.', 'mindu' ),
            'icon'   => 'el el-home',
            'fields' => array(

                array(
                    'id'       => 'footer-copyright',
                    'type'     => 'textarea',
                    'title'    => esc_html__( 'Footer Copyright ', 'mindu' ),
                    'default' => esc_html__( '© 2026 Copyrights by aqlova Co. All Rights Reserved. Developed by ThemePure', 'mindu' ),
                ),

            )
        ) 
    );






