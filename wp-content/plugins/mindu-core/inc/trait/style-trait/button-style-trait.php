<?php

/**
 * @mixin \Elementor\Widget_Base
 */

trait Button_Style_Trait {

    public function button_style_controls( $id, $label = 'Button', $selector = '' ) {

        // Style Section
        $this->start_controls_section(
            $id . '_section_style',
            [
                'label' => esc_html__( $label, 'elementor-addon' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Alignment
        $this->add_control(
            $id . '_align',
            [
                'label' => esc_html__( 'Alignment', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'elementor-addon' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'elementor-addon' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'elementor-addon' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'flex-start',
                'toggle'  => true,
                'selectors' => [
                    '{{WRAPPER}} .tp-mindu-btn' => 'display:flex;justify-content:{{VALUE}};',
                ],
            ]
        );

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => $id . '_typography',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        // Tabs
        $this->start_controls_tabs( $id . '_style_tabs' );

        // Normal Tab
        $this->start_controls_tab(
            $id . '_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'elementor-addon' ),
            ]
        );

        // Text Color
        $this->add_control(
            $id . '_color',
            [
                'label' => esc_html__( 'Text Color', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'color: {{VALUE}};',
                ],
            ]
        );

        // Icon Color
        $this->add_control(
            $id . '_icon_color',
            [
                'label'   => esc_html__( 'Icon Color', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                // 'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .tp-btn-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .tp-btn-icon svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .tp-btn-icon svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );

        // Background Color
        $this->add_control(
            $id . '_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            $id . '_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'elementor-addon' ),
            ]
        );

        // Text Hover Color
        $this->add_control(
            $id . '_hover_color',
            [
                'label' => esc_html__( 'Text Color', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ':hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Icon Hover Color
        $this->add_control(
            $id . '_hover_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ':hover .tp-btn-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ':hover .tp-btn-icon svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ':hover .tp-btn-icon svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );

        // Background Hover Color
        $this->add_control(
            $id . '_hover_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ':hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Border Hover Color
        $this->add_control(
            $id . '_hover_border_color',
            [
                'label' => esc_html__( 'Border Color', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ':hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        // Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => $id . '_border',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        // Border Radius
        $this->add_control(
            $id . '_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector =>
                        'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Padding
        $this->add_control(
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

        // Margin
        $this->add_control(
            $id . '_margin',
            [
                'label' => esc_html__( 'Margin', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem' ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector =>
                        'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Icon Size
        $this->add_responsive_control(
            $id . '_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],

                'default' => [
                    'size' => 16,
                    'unit' => 'px',
                ],

                
                'range' => [
                    'px' => [
                        'min' => 8,
                        'max' => 100,
                    ],
                ],


                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .tp-btn-icon i' =>
                        'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} ' . $selector . ' .tp-btn-icon svg' =>
                        'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Icon Gap
        $this->add_responsive_control(
            $id . '_icon_gap',
            [
                'label' => esc_html__( 'Icon Gap', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .tp-btn-icon' =>
                        'margin-inline-start: {{SIZE}}{{UNIT}}; margin-inline-end: 0;',
                ],
            ]
        );

        $this->end_controls_section();
    }
}