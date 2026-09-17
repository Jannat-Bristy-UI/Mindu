<?php

class Mindu_Icon_List extends \Elementor\Widget_Base {

    use Icon_Style_Trait;

    public function get_name(): string {
        return 'mindu-icon-list';
    }

    public function get_title(): string {
        return esc_html__( 'Theme Icon List', 'elementor-addon' );
    }

    public function get_icon(): string {
        return 'eicon-bullet-list';
    }

    public function get_categories(): array {
        return [ 'mindu-category' ];
    }

    public function get_keywords(): array {
        return [ 'icon', 'list', 'svg', 'repeater' ];
    }

    protected function register_controls(): void {
        $this->register_controls_section();
        $this->register_style_section();
    }

    //=========================================================
    // Content Tab
    //=========================================================

    protected function register_controls_section() {

        $this->start_controls_section(
            'section_icon_list',
            [
                'label' => esc_html__( 'Icon List', 'elementor-addon' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'text',
            [
                'label'       => esc_html__( 'Text', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'List Item', 'elementor-addon' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'         => esc_html__( 'Link', 'elementor-addon' ),
                'type'          => \Elementor\Controls_Manager::URL,
                'placeholder'   => esc_html__( 'https://your-link.com', 'elementor-addon' ),
                'show_external' => true,
                'default'       => [
                    'url'         => '',
                    'is_external' => false,
                    'nofollow'    => false,
                ],
            ]
        );

        $repeater->add_control(
            'icon_style',
            [
                'label'   => esc_html__( 'Icon Type', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'icon' => esc_html__( 'Icon', 'elementor-addon' ),
                    'svg'  => esc_html__( 'SVG', 'elementor-addon' ),
                ],
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label'     => esc_html__( 'Icon', 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'icon_style' => 'icon',
                ],
            ]
        );

        $repeater->add_control(
            'svg',
            [
                'label'     => esc_html__( 'SVG Icon Code', 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::TEXTAREA,
                'condition' => [
                    'icon_style' => 'svg',
                ],
            ]
        );

        $this->add_control(
            'icon_list',
            [
                'label'       => esc_html__( 'List Items', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [ 'text' => esc_html__( 'List Item #1', 'elementor-addon' ) ],
                    [ 'text' => esc_html__( 'List Item #2', 'elementor-addon' ) ],
                    [ 'text' => esc_html__( 'List Item #3', 'elementor-addon' ) ],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->end_controls_section();

    }

    //=========================================================
    // Style Tab
    //=========================================================

    protected function register_style_section() {

    

        // List Layout Controls Section

            // List Layout Tab
            $this->start_controls_section(
                'section_list_style',
                [
                    'label' => esc_html__( 'List Layout', 'elementor-addon' ),
                    'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'layout_type',
                [
                    'label'     => esc_html__( 'Layout', 'elementor-addon' ),
                    'type'      => \Elementor\Controls_Manager::CHOOSE,
                    'options'   => [
                        'column' => [
                            'title' => esc_html__( 'Vertical', 'elementor-addon' ),
                            'icon'  => 'eicon-editor-list-ul',
                        ],
                        'row'    => [
                            'title' => esc_html__( 'Inline', 'elementor-addon' ),
                            'icon'  => 'eicon-ellipsis-h',
                        ],
                    ],
                    'default'   => 'column',
                    'selectors' => [
                        '{{WRAPPER}} .el-icon-list' => 'flex-direction: {{VALUE}};',
                    ],
                ]
            );

            // List Alignment Control
            $this->add_responsive_control(
                'list_alignment',
                [
                    'label'     => esc_html__( 'Alignment', 'elementor-addon' ),
                    'type'      => \Elementor\Controls_Manager::CHOOSE,
                    'options'   => [
                        'flex-start' => [
                            'title' => esc_html__( 'Left', 'elementor-addon' ),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center'     => [
                            'title' => esc_html__( 'Center', 'elementor-addon' ),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'flex-end'   => [
                            'title' => esc_html__( 'Right', 'elementor-addon' ),
                            'icon'  => 'eicon-text-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .el-icon-list' => 'justify-content: {{VALUE}};',
                    ],
                ]
            );

            

            // Space Between List Items Control
            $this->add_responsive_control(
                'space_between_gap',
                [
                    'label'      => esc_html__( 'List Items Gap', 'elementor-addon' ),
                    'type'       => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => [ 'px', 'em', 'rem' ],
                    'range'      => [
                        'px' => [ 'min' => 0, 'max' => 100 ],
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .el-icon-list' => 'gap: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            // Space Between Icon & Text Control
            $this->add_responsive_control(
                'icon_text_gap',
                [
                    'label'      => esc_html__( 'Icon & Text Gap', 'elementor-addon' ),
                    'type'       => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => [ 'px', 'em' ],
                    'range'      => [
                        'px' => [ 'min' => 0, 'max' => 50 ],
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .el-icon-list-item a, {{WRAPPER}} .el-icon-list-content' => 'gap: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            // Icon & Text Vertical Alignment
            $this->add_responsive_control(
                'icon_text_alignment',
                [
                    'label'     => esc_html__( 'Vertical Alignment', 'elementor-addon' ),
                    'type'      => \Elementor\Controls_Manager::CHOOSE,
                    'options'   => [
                        'flex-start' => [
                            'title' => esc_html__( 'Top', 'elementor-addon' ),
                            'icon'  => 'eicon-v-align-top',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Middle', 'elementor-addon' ),
                            'icon'  => 'eicon-v-align-middle',
                        ],
                        'flex-end' => [
                            'title' => esc_html__( 'Bottom', 'elementor-addon' ),
                            'icon'  => 'eicon-v-align-bottom',
                        ],
                    ],
                    'default'   => 'center',
                    'selectors' => [
                        '{{WRAPPER}} .el-icon-list-item a, {{WRAPPER}} .el-icon-list-content' => 'align-items: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_section();

        // End List Layout Controls


        


        // Text Style Controls

            // Typography Control
            $this->start_controls_section(
                'section_text_style',
                [
                    'label' => esc_html__( 'Text Style', 'elementor-addon' ),
                    'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name'     => 'text_typography',
                    'label'    => esc_html__( 'Typography', 'elementor-addon' ),
                    'selector' => '{{WRAPPER}} .el-icon-list-text',
                ]
            );

            // Text Color Tabs (Normal & Hover)
            $this->start_controls_tabs( 'text_style_tabs' );

                // Normal Tab For Text Color
                $this->start_controls_tab(
                    'text_style_normal',
                    [ 'label' => esc_html__( 'Normal', 'elementor-addon' ) ]
                );

                $this->add_control(
                    'text_color',
                    [
                        'label'     => esc_html__( 'Text Color', 'elementor-addon' ),
                        'type'      => \Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .el-icon-list-text' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->end_controls_tab();


                // Hover Tab For Text Color
                $this->start_controls_tab(
                    'text_style_hover',
                    [ 'label' => esc_html__( 'Hover', 'elementor-addon' ) ]
                );

                $this->add_control(
                    'text_hover_color',
                    [
                        'label'     => esc_html__( 'Hover Color', 'elementor-addon' ),
                        'type'      => \Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .el-icon-list-item:hover .el-icon-list-text'   => 'color: {{VALUE}};',
                            '{{WRAPPER}} .el-icon-list-item a:hover .el-icon-list-text' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->end_controls_tab();

            $this->end_controls_tabs();

            $this->end_controls_section();
        
        // End Text Style Controls


        // Divider Controls Section
        $this->start_controls_section(
            'section_divider_style',
            [
                'label' => esc_html__( 'Divider', 'elementor-addon' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'show_divider',
            [
                'label'        => esc_html__( 'Divider', 'elementor-addon' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'elementor-addon' ),
                'label_off'    => esc_html__( 'Hide', 'elementor-addon' ),
                'return_value' => 'yes',
                'default'      => '',
                
            ]
        );

        $this->add_control(
            'divider_style',
            [
                'label'     => esc_html__( 'Style', 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'options'   => [
                    'solid'  => esc_html__( 'Solid', 'elementor-addon' ),
                    'double' => esc_html__( 'Double', 'elementor-addon' ),
                    'dotted' => esc_html__( 'Dotted', 'elementor-addon' ),
                    'dashed' => esc_html__( 'Dashed', 'elementor-addon' ),
                ],
                'default'   => 'solid',
                'condition' => [
                    'show_divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .el-icon-list-item:not(:last-child)' => 'border-bottom-style: {{VALUE}};',
                ],

                
            ]
        );

        $this->add_control(
            'divider_weight',
            [
                'label'      => esc_html__( 'Weight', 'elementor-addon' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 1, 'max' => 20 ],
                ],
                'default'    => [
                    'size' => 1,
                    'unit' => 'px',
                ],
                'condition'  => [
                    'show_divider' => 'yes',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .el-icon-list-item:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'divider_color',
            [
                'label'     => esc_html__( 'Color', 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#e6e6e6',
                'condition' => [
                    'show_divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .el-icon-list-item:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'divider_padding',
            [
                'label'      => esc_html__( 'Padding Bottom', 'elementor-addon' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 100 ],
                ],
                'condition'  => [
                    'show_divider' => 'yes',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .el-icon-list-item:not(:last-child)' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        // Icon Style Controls (Trait)
        $this->icon_style_controls( 'list_', 'Icon Style', '.el-icon-list-item .el-icon' );

    }




    
    //==================================================================================================
    // Render Output Structure: Settings → Link check → <a>/<div> open → Icon → Text → <a>/<div> close
    //==================================================================================================

    protected function render(): void {

        $settings = $this->get_settings_for_display();

        // Safety check: list-এ কোনো data না থাকলে code সেখানেই return করে থেমে যাবে
        if ( empty( $settings['icon_list'] ) ) {
            return;
        }

        ?>

        <!-- মূল লিস্টের মেইন কন্টেইনার (UL) -->
        <ul class="el-icon-list">
            
           
            <?php foreach ( $settings['icon_list'] as $index => $item ) : ?>

                <?php
                    // Text-এর জন্য Elementor inline editing enable করতে unique key তৈরি ও attributes add করা
                    $repeater_key = $this->get_repeater_setting_key( 'text', 'icon_list', $index );
                    $this->add_inline_editing_attributes( $repeater_key, 'basic' );

                    // Link আছে কিনা check করা এবং প্রতিটি item-এর জন্য unique link key তৈরি করা
                    $has_link = ! empty( $item['link']['url'] );
                    $link_key = 'link_' . $index;

                    // যদি লিঙ্ক থাকে, তবে Elementor-এর লিঙ্ক ফিচার চালু করা
                    if ( $has_link ) {
                        $this->add_link_attributes( $link_key, $item['link'] );
                    }
                ?>

                <!-- HTML Markup for Single icon list item- প্রতিটি লিস্ট আইটেমের বক্স (LI) -->
                <li class="el-icon-list-item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ?? '' ); ?>">

                    <?php if ( $has_link ) : ?>
                        <!-- Link থাকলে <a> tag ব্যবহার -->
                        <a <?php $this->print_render_attribute_string( $link_key ); ?>> 

                    <?php else : ?>
                        <!-- Link না থাকলে <div> tag ব্যবহার -->
                        <div class="el-icon-list-content"> 

                    <?php endif; ?>

                        <!-- Icon wrapper -->
                        <span class="el-icon">
                            <?php
                                if ( ( $item['icon_style'] ?? '' ) === 'icon' ) {

                                    // Elementor Icons Manager দিয়ে icon render করা (accessibility support সহ)
                                    \Elementor\Icons_Manager::render_icon( $item['icon'] ?? [], [ 'aria-hidden' => 'true' ] );                                    
                                } else {

                                    // SVG select করলে SVG render
                                    echo mc_kses( $item['svg'] ?? '' );
                                }
                            ?>
                        </span>

                        <!-- List item text -->
                        <span class="el-icon-list-text"
                            <?php $this->print_render_attribute_string( $repeater_key ); ?>
                        >
                            <?php echo esc_html( $item['text'] ?? '' ); ?>
                        </span>

                    <?php if ( $has_link ) : ?>                       
                        </a>  <!-- Link close -->
                    <?php else : ?>
                        </div> <!-- Content wrapper close -->
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php

    }
}

/** @var \Elementor\Widgets_Manager $widgets_manager */
$widgets_manager->register( new Mindu_Icon_List() );