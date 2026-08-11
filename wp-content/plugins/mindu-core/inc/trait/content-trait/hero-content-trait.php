<?php

trait Hero_Content_Trait {

    protected function register_hero_controls(): void {

        $this->start_controls_section(
			'section_hero',
			[
				'label' => esc_html__( 'Hero', 'elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'hero_style',
			[
				'label'   => esc_html__( 'Hero Style', 'elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'hero_style_01',
				'options' => [
					'hero_style_01'  => esc_html__( 'Hero Style-01', 'elementor-addon' ),
					'hero_style_02' => esc_html__( 'Hero Style-02', 'elementor-addon' ),
				],
			]
		);

        $this->end_controls_section();

        //====== Hero Content ========
        
            $this->start_controls_section(
                'hero_section_content',
                [
                    'label' => esc_html__( 'Hero Content', 'elementor-addon' ),
                    'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );

            // Sub Title
            $this->add_control(
                'hero_sub_title',
                [
                    'label'       => esc_html__( 'Sub Title', 'elementor-addon' ),
                    'type'        => \Elementor\Controls_Manager::TEXT,
                    'default'     => 'Hello World' ,
                    'label_block' => true,
                ]
            );

            // Title
            $this->add_control(
                'hero_title',
                [
                    'label'   => esc_html__( 'Title', 'elementor-addon' ),
                    'type'    => \Elementor\Controls_Manager::TEXTAREA,
                    'default' => 'Hero Title',
                ]
            );

            // Content
            $this->add_control(
                'hero_content',
                [
                    'label'   => esc_html__( 'Content', 'elementor-addon' ),
                    'type'    => \Elementor\Controls_Manager::TEXTAREA,
                    'default' => 'Hero content here',
                ]
            );

            // Alignment
            $this->add_responsive_control(
                'hero_alignment',
                    [
                        'label'   => esc_html__( 'Alignment', 'elementor-addon' ),
                        'type'    => \Elementor\Controls_Manager::CHOOSE,
                        'options' => [
                            'left' => [
                                'title' => esc_html__( 'Left', 'elementor-addon' ),
                                'icon'  => 'eicon-text-align-left',
                            ],
                            'center' => [
                                'title' => esc_html__( 'Center', 'elementor-addon' ),
                                'icon'  => 'eicon-text-align-center',
                            ],
                            'right' => [
                                'title' => esc_html__( 'Right', 'elementor-addon' ),
                                'icon'  => 'eicon-text-align-right',
                            ],
                        ],
                        'default'   => 'left',
                        'toggle'    => true,
                        'selectors' => [
                            // Wrapper
                            '{{WRAPPER}} .el-hero-content' => 'text-align: {{VALUE}};',

                            // Sub title wrapper (design maintain)
                            '{{WRAPPER}} .el-hero-content .tp-hero-ratings-wrap' => 'display:inline-flex;',

                            // Title
                            '{{WRAPPER}} .el-hero-content .el-title' => 'text-align: {{VALUE}};',

                            // Paragraph
                            '{{WRAPPER}} .el-hero-content .el-content' => 'text-align: {{VALUE}};',
                        ],
                    ]
                );

            $this->end_controls_section();

        // End===>



        //=========== Button ==========
        $this->start_controls_section(
            'section_button',
            [
                'label' => esc_html__( 'Hero Button', 'elementor-addon' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Button Text
        $this->add_control(
            'button_text',
            [
                'label'       => esc_html__( 'Button Text', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Find Courses', 'elementor-addon' ),
                'placeholder' => esc_html__( 'Enter button text', 'elementor-addon' ),
            ]
        );

        // Button Link
        $this->add_control(
            'button_url',
            [
                'label'       => esc_html__( 'Link', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'options'     => [ 'url', 'is_external', 'nofollow' ],
                'default'     => [
                    'url'         => '#',
                    'is_external' => false,
                    'nofollow'    => false,
                ],
                'label_block' => true,
            ]
        );

        // Icon Type
        $this->add_control(
            'icon_type',
            [
                'label'   => esc_html__( 'Icon Type', 'textdomain' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'icon',
                'options' => [
                    'icon' => [
                        'title' => esc_html__( 'Icon', 'textdomain' ),
                        'icon'  => 'eicon-star',
                    ],
                    'svg' => [
                        'title' => esc_html__( 'SVG', 'textdomain' ),
                        'icon'  => 'eicon-code',
                    ],
                ],
                'toggle' => false,
            ]
        );

        // Elementor Icon
       $this->add_control(
				'button_icon',
				[
					'label' => esc_html__( 'Choose Icon', 'textdomain' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
                        'value' => 'fas fa-arrow-right',
                        'library' => 'fa-solid',
                    ],
					'condition' => [
						'icon_type' => 'icon',
					],
				]
			);

        // SVG Code
        $this->add_control(
            'svg_code',
            [
                'label'     => esc_html__( 'SVG Code', 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::TEXTAREA,
                'condition' => [
                    'icon_type' => 'svg',
                ],
            ]
        );

        $this->end_controls_section();


        // =======================
        // Explore Button
        // =======================
        $this->start_controls_section(
			'section_explore_button',
			[
				'label' => esc_html__( 'Button Explore', 'elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				// 'condition' => [
				// 	'design_layout' => 'style_1',
				// ],
			]
		);

		$this->add_control(
			'button_explore_text',
			[
				'label' => esc_html__( 'Button Text', 'elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Button Text', 'elementor-addon' ),
			]
		);

		$this->add_control(
			'button_explore_url',
			[
				'label' => esc_html__( 'URL', 'elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '#explore', 'elementor-addon' ),
			]
		);

		$this->end_controls_section();


        // =======================
        // Hero Background Image
        // =======================

        $this->start_controls_section(
            'hero_section_image',
            [
                'label' => esc_html__( 'Hero Background', 'elementor-addon' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'hero_image',
            [
                'label'   => esc_html__( 'Choose Image', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        // Position
        $this->add_control(
            'hero_image_position',
            [
                'label'   => esc_html__( 'Position', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'center center',
                'options' => [
                    'left top'      => 'Left Top',
                    'left center'   => 'Left Center',
                    'left bottom'   => 'Left Bottom',
                    'center top'    => 'Center Top',
                    'center center' => 'Center Center',
                    'center bottom' => 'Center Bottom',
                    'right top'     => 'Right Top',
                    'right center'  => 'Right Center',
                    'right bottom'  => 'Right Bottom',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tp-hero-area' => 'background-position: {{VALUE}};',
                ],
            ]
        );

        // Size
        $this->add_control(
            'hero_image_size',
            [
                'label'   => esc_html__( 'Size', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'auto'    => 'Auto',
                    'cover'   => 'Cover',
                    'contain' => 'Contain',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tp-hero-area' => 'background-size: {{VALUE}};',
                ],
            ]
        );

        // Repeat
        $this->add_control(
            'hero_image_repeat',
            [
                'label'   => esc_html__( 'Repeat', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'no-repeat',
                'options' => [
                    'no-repeat' => 'No Repeat',
                    'repeat'    => 'Repeat',
                    'repeat-x'  => 'Repeat X',
                    'repeat-y'  => 'Repeat Y',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tp-hero-area' => 'background-repeat: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        // =======================
        // Hero Video
        // =======================
        $this->start_controls_section(
            'section_video',
            [
                'label' => esc_html__( 'Video', 'elementor-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                // 'condition' => [
                //     'design_layout' => 'style_1',
                // ],
            ]
        );

        $this->add_control(
            'video_text',
            [
                'label' => esc_html__( 'Video Text', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Text Here', 'elementor-addon' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'video_text_link',
            [
                'label' => esc_html__( 'Video Text Link', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( '#', 'elementor-addon' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'video_url',
            [
                'label' => esc_html__( 'Video URL', 'elementor-addon' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( '#', 'elementor-addon' ),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

    }
}