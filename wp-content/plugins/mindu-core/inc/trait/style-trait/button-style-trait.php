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

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => $id . '_typography',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );



        // Tabs Part Start      
        $this->start_controls_tabs( $id . '_style_tabs' );

            //============= Normal Tab =============
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



            //============ Hover Tab ============
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

        $this->end_controls_section();
    }
}