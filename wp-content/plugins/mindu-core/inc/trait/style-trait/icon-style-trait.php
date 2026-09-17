<?php

/**
 * Trait Icon_Style_Trait
 *
 * Provides reusable Elementor style controls for custom icon implementations.
*/

trait Icon_Style_Trait {

    protected function icon_style_controls( $prefix = '', $label = 'Icon Style', $selector = '.el-icon' ) {

        $this->start_controls_section(
            $prefix . 'section_icon_style',
            [
                'label' => esc_html__( $label, 'consora-core' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        //=========== Icon Size ===========
        $this->add_control(
            $prefix . 'icon_size',
            [
                'label'      => esc_html__( 'Icon Size', 'consora-core' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                    'em' => [
                        'min' => 0.1,
                        'max' => 10,
                    ],
                    'rem' => [
                        'min' => 0.1,
                        'max' => 10,
                    ],
                ],
                'selectors'  => [
					'{{WRAPPER}} ' . $selector . ' svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; display: block; vertical-align: middle;',
					'{{WRAPPER}} ' . $selector . ' i'   => 'font-size: {{SIZE}}{{UNIT}}; display: block; vertical-align: middle;',
				],
            ]
        );


        //=========== Width ===========
        $this->add_control(
            $prefix . 'icon_width',
            [
                'label'      => esc_html__( 'Width', 'consora-core' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selector => 'width: {{SIZE}}{{UNIT}}; display: inline-flex; align-items: center; justify-content: center;',
                ],
            ]
        );


        //=========== Height ===========
        $this->add_control(
            $prefix . 'icon_height',
            [
                'label'      => esc_html__( 'Height', 'consora-core' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selector => 'height: {{SIZE}}{{UNIT}}; display: inline-flex; align-items: center; justify-content: center;',
                ],
            ]
        );


        //=========== Margin ===========
        $this->add_control(
            $prefix . 'icon_margin',
            [
                'label'      => esc_html__( 'Margin', 'consora-core' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        //=========== Border Radius ===========
        $this->add_control(
            $prefix . 'icon_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'consora-core' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        //============== Normal / Hover Tabs ===========
        $this->start_controls_tabs( $prefix . 'icon_style_tabs' );

			// Normal Tab Start (Icon Color, Fill Color, Stroke Color, Background Color, Border)
				$this->start_controls_tab(
					$prefix . 'icon_style_normal',
					[
						'label' => esc_html__( 'Normal', 'consora-core' ),
					]
				);

				// Icon Color
				$this->add_control(
					$prefix . 'icon_color',
					[
						'label'     => esc_html__( 'Color', 'consora-core' ),
						'type'      => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} ' . $selector => 'color: {{VALUE}};',
						],
					]
				);

				// SVG Fill Color
				$this->add_control(
					$prefix . 'icon_fill_color',
					[
						'label'     => esc_html__( 'Fill Color', 'consora-core' ),
						'type'      => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} ' . $selector . ' svg path'     => 'fill: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ' svg circle'   => 'fill: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ' svg rect'     => 'fill: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ' svg ellipse'  => 'fill: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ' svg polygon'  => 'fill: {{VALUE}};',
						],
					]
				);

				// SVG Stroke Color
				$this->add_control(
					$prefix . 'icon_stroke_color',
					[
						'label'     => esc_html__( 'Stroke Color', 'consora-core' ),
						'type'      => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} ' . $selector . ' svg path'     => 'stroke: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ' svg circle'   => 'stroke: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ' svg rect'     => 'stroke: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ' svg line'     => 'stroke: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ' svg polyline' => 'stroke: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ' svg polygon'  => 'stroke: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ' svg ellipse'  => 'stroke: {{VALUE}};',
						],
					]
				);

				// Background Color
				$this->add_control(
					$prefix . 'icon_bg_color',
					[
						'label'     => esc_html__( 'Background Color', 'consora-core' ),
						'type'      => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} ' . $selector => 'background-color: {{VALUE}};',
						],
					]
				);

				// Border
				$this->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name'     => $prefix . 'icon_border',
						'selector' => '{{WRAPPER}} ' . $selector,
					]
				);

				$this->end_controls_tab();
			// Normal Tab End



			// Hover Tab Start (Icon Color, Fill Color, Stroke Color, Background Color, Border)
				$this->start_controls_tab(
					$prefix . 'icon_style_hover',
					[
						'label' => esc_html__( 'Hover', 'consora-core' ),
					]
				);

				// Hover Icon Color
				$this->add_control(
					$prefix . 'icon_hover_color',
					[
						'label'     => esc_html__( 'Color', 'consora-core' ),
						'type'      => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} ' . $selector . ':hover' => 'color: {{VALUE}};',
						],
					]
				);

				// Hover Fill Color
				$this->add_control(
					$prefix . 'icon_hover_fill_color',
					[
						'label'     => esc_html__( 'Fill Color', 'consora-core' ),
						'type'      => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} ' . $selector . ':hover svg path'    => 'fill: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ':hover svg circle'  => 'fill: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ':hover svg rect'    => 'fill: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ':hover svg ellipse' => 'fill: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ':hover svg polygon' => 'fill: {{VALUE}};',
						],
					]
				);

				// Hover Stroke Color
				$this->add_control(
					$prefix . 'icon_hover_stroke_color',
					[
						'label'     => esc_html__( 'Stroke Color', 'consora-core' ),
						'type'      => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} ' . $selector . ':hover svg path'     => 'stroke: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ':hover svg circle'   => 'stroke: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ':hover svg rect'     => 'stroke: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ':hover svg line'     => 'stroke: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ':hover svg polyline' => 'stroke: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ':hover svg polygon'  => 'stroke: {{VALUE}};',
							'{{WRAPPER}} ' . $selector . ':hover svg ellipse'  => 'stroke: {{VALUE}};',
						],
					]
				);

				// Hover Background Color
				$this->add_control(
					$prefix . 'icon_hover_bg_color',
					[
						'label'     => esc_html__( 'Background Color', 'consora-core' ),
						'type'      => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} ' . $selector . ':hover' => 'background-color: {{VALUE}};',
						],
					]
				);

				// Hover Border
				$this->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name'     => $prefix . 'icon_hover_border',
						'selector' => '{{WRAPPER}} ' . $selector . ':hover',
					]
				);

				$this->end_controls_tab();
			// Hover Tab End

        $this->end_controls_tabs();


        $this->end_controls_section();
    }
}