<?php

/**
 * Common Content Controls Trait
 *
 * @mixin \Elementor\Widget_Base
*/

trait Hero_Content_Trait {

    public function hero_content_controls( $id, $label = 'Hero', $selector = '',$fields = []) {

    $fields = wp_parse_args( $fields, [
        'title_content' => true,
        'button'        => true,
        'explore'       => true,
        'image'         => true,
        'video'         => true,
    ] );
    

    // =======================
    // Title & Content
    // =======================
    if ( $fields['title_content'] ) {

        $this->start_controls_section(
            $id . '_section_content',
            [
                'label' => esc_html__( $label . ' Title & Content', 'elementor-addon' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            $id . '_sub_title',
            [
                'label'       => esc_html__( 'Sub Title', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Hello World', 'elementor-addon' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            $id . '_title',
            [
                'label'   => esc_html__( 'Title', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Hello World', 'elementor-addon' ),
            ]
        );

        $this->add_control(
            $id . '_content',
            [
                'label'   => esc_html__( 'Content', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Content Here', 'elementor-addon' ),
            ]
        );


        $this->end_controls_section();
    }


    // =======================
    // Button
    // =======================
    // if ( $fields['vector'] ) {

    //     $this->start_controls_section(
    //         $id . '_section_vector',
    //         [
    //             'label' => esc_html__( $label . ' Vector', 'elementor-addon' ),
    //             'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
    //         ]
    //     );

       
    //     // vector controls
    //     $this->add_control(
    //         $id . '_vector_type',
    //         [
    //             'label'   => esc_html__( 'Vector Type', 'elementor-addon' ),
    //             'type'    => \Elementor\Controls_Manager::SELECT,
    //             'default' => 'svg',
    //             'toggle'  => false,
    //            'options' => [
    //                 'svg'   => esc_html__( 'SVG', 'elementor-addon' ),
    //                 'image' => esc_html__( 'Image', 'elementor-addon' ),
    //             ],
    //         ]
    //     );

    //     $this->add_control(
    //         $id . '_svg',
    //         [
    //             'label'     => esc_html__( 'SVG Code', 'elementor-addon' ),
    //             'type'      => \Elementor\Controls_Manager::TEXTAREA,
    //             'rows'      => 10,
    //             'condition' => [
    //                 $id . '_vector_type' => 'svg',
    //             ],
    //         ]
    //     );

    //     $this->add_control(
    //         $id . '_vector_image',
    //         [
    //             'label'       => esc_html__( 'Vector Image', 'elementor-addon' ),
    //             'type'        => \Elementor\Controls_Manager::MEDIA,
    //             'media_types' => [ 'image' ],
    //             'condition'   => [
    //                 $id . '_vector_type' => 'image',
    //             ],
    //         ]
    //     );

    //     $this->end_controls_section();
    // }

    // =======================
    // Button
    // =======================
    if ( $fields['button'] ) {

        $this->start_controls_section(
            $id . '_section_button',
            [
                'label' => esc_html__( $label . ' Button', 'elementor-addon' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            $id . '_button_text',
            [
                'label'   => esc_html__( 'Button Text', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Button Text', 'elementor-addon' ),
            ]
        );

        $this->add_control(
            $id . '_button_url',
            [
                'label' => esc_html__( 'Link', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::URL,
                'options' => [ 'url', 'is_external', 'nofollow' ],
                'default' => [
                    'url' => '#',
                ],
                'label_block' => true,
            ]
        );

        $this->end_controls_section();
    }

    // =======================
    // Explore Button
    // =======================
    if ( $fields['explore'] ) {

        $this->start_controls_section(
            $id . '_explore',
            [
                'label' => esc_html__( $label . ' Explore Button', 'elementor-addon' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            $id . '_button_explore_text',
            [
                'label'   => esc_html__( 'Explore Button Text', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Explore Button Text', 'elementor-addon' ),
            ]
        );

        $this->add_control(
            $id . '_button_explore_url',
            [
                'label'   => esc_html__( 'URL', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => '#explore',
            ]
        );

        $this->end_controls_section();
    }

    // =======================
    // Background Image
    // =======================
    if ( $fields['image'] ) {

        $this->start_controls_section(
            $id . '_section_image',
            [
                'label' => esc_html__( $label . ' BG Image', 'elementor-addon' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            $id . '_image',
            [
                'label' => esc_html__( 'Choose Image', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            $id . '_image_position',
            [
                'label'   => esc_html__( 'Position', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'center center',
                'options' => [
                    'center center' => 'Center Center',
                    'top center'    => 'Top Center',
                    'bottom center' => 'Bottom Center',
                    'center left'   => 'Center Left',
                    'center right'  => 'Center Right',
                ],
            ]
        );

        $this->add_control(
            $id . '_image_size',
            [
                'label'   => esc_html__( 'Size', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover'   => 'Cover',
                    'contain' => 'Contain',
                    'auto'    => 'Auto',
                ],
            ]
        ); 

         // Padding
        $this->add_responsive_control(
            $id . '_padding',
            [
                'label' => esc_html__( 'Padding', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector =>
                        'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    // =======================
    // Video
    // =======================
    if ( $fields['video'] ) {

        $this->start_controls_section(
            $id . '_section_video',
            [
                'label' => esc_html__( $label . ' Video', 'elementor-addon' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            $id . '_video_text',
            [
                'label'       => esc_html__( 'Video Text', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Text Here', 'elementor-addon' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            $id . '_video_text_link',
            [
                'label'       => esc_html__( 'Video Text Link', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => '#',
                'label_block' => true,
            ]
        );

        $this->add_control(
            $id . '_video_url',
            [
                'label'       => esc_html__( 'Video URL', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => '#',
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        }
    }

}