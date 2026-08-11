<?php

/**
 * @mixin \Elementor\Widget_Base
 */

/* ==========================================================================
    Reusable Vector Style Trait for Elementor
========================================================================== */

trait Vector_Style_Trait {

    public function vector_style_controls( $id, $label = 'Vector', $selector = '' ) {

        $this->start_controls_section(
            $id . '_vector_style_section',
            [
                'label' => esc_html__( $label, 'elementor-addon' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Width
        $this->add_responsive_control(
            $id . '_width',
            [
                'label'      => esc_html__( 'Width', 'elementor-addon' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selector . ',
                    {{WRAPPER}} ' . $selector . ' img,
                    {{WRAPPER}} ' . $selector . ' svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Height
        $this->add_responsive_control(
            $id . '_height',
            [
                'label'      => esc_html__( 'Height', 'elementor-addon' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vh' ],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selector . ',
                    {{WRAPPER}} ' . $selector . ' img,
                    {{WRAPPER}} ' . $selector . ' svg' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Position
        $this->add_responsive_control(
            $id . '_position',
            [
                'label'   => esc_html__( 'Position', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'absolute',
                'options' => [
                    'static'   => esc_html__( 'Static', 'elementor-addon' ),
                    'relative' => esc_html__( 'Relative', 'elementor-addon' ),
                    'absolute' => esc_html__( 'Absolute', 'elementor-addon' ),
                    'fixed'    => esc_html__( 'Fixed', 'elementor-addon' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'position: {{VALUE}};',
                ],
            ]
        );

        // Horizontal Position
        $this->add_responsive_control(
            $id . '_horizontal',
            [
                'label'   => esc_html__( 'Horizontal Orientation', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'left',
                'toggle'  => false,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'elementor-addon' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'elementor-addon' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            $id . '_left_offset',
            [
                'label'      => esc_html__( 'Left Offset', 'elementor-addon' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'condition'  => [
                    $id . '_horizontal' => 'left',
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selector => 'left: {{SIZE}}{{UNIT}}; right:auto;',
                ],
            ]
        );

        $this->add_responsive_control(
            $id . '_right_offset',
            [
                'label'      => esc_html__( 'Right Offset', 'elementor-addon' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'condition'  => [
                    $id . '_horizontal' => 'right',
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selector => 'right: {{SIZE}}{{UNIT}}; left:auto;',
                ],
            ]
        );

        // Vertical Position
        $this->add_responsive_control(
            $id . '_vertical',
            [
                'label'   => esc_html__( 'Vertical Orientation', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'top',
                'toggle'  => false,
                'options' => [
                    'top' => [
                        'title' => esc_html__( 'Top', 'elementor-addon' ),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'bottom' => [
                        'title' => esc_html__( 'Bottom', 'elementor-addon' ),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            $id . '_top_offset',
            [
                'label'      => esc_html__( 'Top Offset', 'elementor-addon' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vh' ],
                'condition'  => [
                    $id . '_vertical' => 'top',
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selector => 'top: {{SIZE}}{{UNIT}}; bottom:auto;',
                ],
            ]
        );

        $this->add_responsive_control(
            $id . '_bottom_offset',
            [
                'label'      => esc_html__( 'Bottom Offset', 'elementor-addon' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vh' ],
                'condition'  => [
                    $id . '_vertical' => 'bottom',
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selector => 'bottom: {{SIZE}}{{UNIT}}; top:auto;',
                ],
            ]
        );

        // Z-Index
        $this->add_responsive_control(
            $id . '_z_index',
            [
                'label' => esc_html__( 'Z-Index', 'elementor-addon' ),
                'type'  => \Elementor\Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'z-index: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
}