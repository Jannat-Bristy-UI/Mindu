<?php

/**
 * Reusable Icon Style Controls for Elementor
 */

trait Icon_Style_Trait {

	public function icon_style_controls(
		$id,
		$label = 'Icon Style',
		$selector = '.el-icon'
	) {

		// ==========================================
		// Icon Style Section
		// ==========================================

		$this->start_controls_section(
			$id . '_icon_style_section',
			[
				'label' => esc_html__( $label, 'elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		// ==========================================
		// Icon Size
		// ==========================================

		$this->add_responsive_control(
			$id . '_icon_size',
			[
				'label'      => esc_html__( 'Size', 'elementor-addon' ),
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
						'step' => 0.1,
					],
					'rem' => [
						'min' => 0.1,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'selectors' => [

					// Font Awesome / Icon Fonts
					'{{WRAPPER}} ' . $selector . ' i' =>
						'font-size: {{SIZE}}{{UNIT}};',

					// SVG Icon
					'{{WRAPPER}} ' . $selector . ' svg' =>
						'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',

					// SVG inner elements
					'{{WRAPPER}} ' . $selector . ' svg *' =>
						'width: auto; height: auto;',
				],
			]
		);


        // ==========================================
        // Icon Box Width
        // ==========================================

        $this->add_responsive_control(
            $id . '_icon_box_width',
            [
                'label'      => esc_html__( 'Width', 'elementor-addon' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector =>
                        'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        // ==========================================
        // Icon Box Height
        // ==========================================

        $this->add_responsive_control(
            $id . '_icon_box_height',
            [
                'label'      => esc_html__( 'Height', 'elementor-addon' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vh' ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector =>
                        'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


		// ==========================================
		// Normal & Hover Tabs
		// ==========================================

		$this->start_controls_tabs(
			$id . '_icon_tabs'
		);


		// ==========================================
		// Normal State
		// ==========================================

		$this->start_controls_tab(
			$id . '_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'elementor-addon' ),
			]
		);


		// ------------------------------------------
		// Icon Color
		// ------------------------------------------

		$this->add_control(
			$id . '_icon_color',
			[
				'label'     => esc_html__( 'Color', 'elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [

					// Icon font
					'{{WRAPPER}} ' . $selector =>
						'color: {{VALUE}};',

					// SVG
					'{{WRAPPER}} ' . $selector . ' svg' =>
						'fill: {{VALUE}}; stroke: {{VALUE}};',

					// SVG paths / elements
					'{{WRAPPER}} ' . $selector . ' svg *' =>
						'fill: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);


		// ------------------------------------------
		// Icon Background
		// ------------------------------------------

		$this->add_control(
			$id . '_icon_bg',
			[
				'label'     => esc_html__( 'Background', 'elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $selector =>
						'background-color: {{VALUE}};',
				],
			]
		);


		// ------------------------------------------
		// Normal Border
		// ------------------------------------------

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => $id . '_icon_border',
				'selector' => '{{WRAPPER}} ' . $selector,
			]
		);


		$this->end_controls_tab();


		// ==========================================
		// Hover State
		// ==========================================

		$this->start_controls_tab(
			$id . '_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'elementor-addon' ),
			]
		);


		// ------------------------------------------
		// Hover Icon Color
		// ------------------------------------------

		$this->add_control(
			$id . '_icon_hover_color',
			[
				'label'     => esc_html__( 'Color', 'elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [

					// Icon font
					'{{WRAPPER}} ' . $selector . ':hover' =>
						'color: {{VALUE}};',

					// SVG
					'{{WRAPPER}} ' . $selector . ':hover svg' =>
						'fill: {{VALUE}}; stroke: {{VALUE}};',

					// SVG inner elements
					'{{WRAPPER}} ' . $selector . ':hover svg *' =>
						'fill: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);


		// ------------------------------------------
		// Hover Background
		// ------------------------------------------

		$this->add_control(
			$id . '_icon_hover_bg',
			[
				'label'     => esc_html__( 'Background', 'elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $selector . ':hover' =>
						'background-color: {{VALUE}};',
				],
			]
		);


		// ------------------------------------------
		// Hover Border
		// ------------------------------------------

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => $id . '_icon_hover_border',
				'selector' => '{{WRAPPER}} ' . $selector . ':hover',
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();


		// ==========================================
		// Border Radius
		// ==========================================

		$this->add_responsive_control(
			$id . '_icon_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $selector =>
						'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		

		// ==========================================
		// End Section
		// ==========================================


        


		$this->end_controls_section();
	}
}