<?php

/**
 * @mixin \Elementor\Widget_Base
*/

/* ==========================================================================
    Reusable Icon Style Trait for Elementor Style Tab Controls
========================================================================== */
trait Icon_Style_Trait {

    public function icon_style_controls( $id, $label = 'Icon', $selector = '' ) {

        $this->start_controls_section(
            $id . '_icon_style_section',
            [
                'label' => esc_html__( $label, 'elementor-addon' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

       // Icon Size
        $this->add_responsive_control(
            $id . '_icon_size',
            [
                'label' => esc_html__( 'Size', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 150,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} ' . $selector . ' svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Normal State and Hover State Style Tabs Title for Icon
            $this->start_controls_tabs( $id . '_icon_tabs' );

                // Normal Style Tab
                    $this->start_controls_tab(
                        $id . '_icon_normal',
                        [
                            'label' => esc_html__( 'Normal', 'elementor-addon' ),
                        ]
                    );

                    // Icon Color
                    $this->add_control(
                        $id . '_icon_color',
                        [
                            'label' => esc_html__( 'Color', 'elementor-addon' ),
                            'type'  => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} ' . $selector             => 'color: {{VALUE}};',
                                '{{WRAPPER}} ' . $selector . ' svg'    => 'fill: {{VALUE}}; stroke: {{VALUE}};',
                                '{{WRAPPER}} ' . $selector . ' svg *'  => 'fill: {{VALUE}}; stroke: {{VALUE}};',
                            ],
                        ]
                    );

                    // Icon Background Color
                    $this->add_control(
                        $id . '_icon_bg',
                        [
                            'label' => esc_html__( 'Background', 'elementor-addon' ),
                            'type'  => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} ' . $selector => 'background-color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->end_controls_tab();
                // End

                // Hover Style Tab
                    $this->start_controls_tab(
                        $id . '_icon_hover',
                        [
                            'label' => esc_html__( 'Hover', 'elementor-addon' ),
                        ]
                    );

                    // Icon Hover Color
                    $this->add_control(
                        $id . '_icon_hover_color',
                        [
                            'label' => esc_html__( 'Color', 'elementor-addon' ),
                            'type'  => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                               '{{WRAPPER}} ' . $selector . ':hover'        => 'color: {{VALUE}};',
                                '{{WRAPPER}} ' . $selector . ':hover svg'    => 'fill: {{VALUE}}; stroke: {{VALUE}};',
                                '{{WRAPPER}} ' . $selector . ':hover svg *'  => 'fill: {{VALUE}}; stroke: {{VALUE}};',
                            ],
                        ]
                    );

                    // Icon Hover Background Color
                    $this->add_control(
                        $id . '_icon_hover_bg',
                        [
                            'label' => esc_html__( 'Background', 'elementor-addon' ),
                            'type'  => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} ' . $selector . ':hover' => 'background-color: {{VALUE}};',
                            ],
                        ]
                    );

                    // Icon Hover Border Color
                    $this->add_control(
                        $id . '_icon_hover_border',
                        [
                            'label' => esc_html__( 'Border Color', 'elementor-addon' ),
                            'type'  => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} ' . $selector . ':hover' => 'border-color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->end_controls_tab();

                // End

            $this->end_controls_tabs();

        // End


        // Background Border 
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => $id . '_icon_border',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        // Background Border Radius
        $this->add_responsive_control(
            $id . '_icon_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        // Padding
        $this->add_responsive_control(
            $id . '_icon_padding',
            [
                'label' => esc_html__( 'Padding', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        
        $this->end_controls_section();
    }
}