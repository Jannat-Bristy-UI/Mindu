<?php



trait Common_Icon_Style {

	public function common_icon_style( $id, $label = 'Icon Style', $selector = '' ) {

		$this->start_controls_section(
			$id . '_icon_style_section',
			[
				'label' => esc_html__( $label, 'elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( $id . '_icon_tabs' );

		
		$this->start_controls_tab(
			$id . '_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'elementor-addon' ),
			]
		);

		// Color
		$this->add_control(
    		$id . '_fill_color',
			[
				'label' => esc_html__( 'Fill / Icon Color', 'elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					// Font Awesome
					'{{WRAPPER}} ' . $selector . ' i' => 'color: {{VALUE}};',
					'{{WRAPPER}} ' . $selector => 'color: {{VALUE}};',

					// SVG Fill
					'{{WRAPPER}} ' . $selector . ' svg *' => 'fill: {{VALUE}};',
				],
			]
		);

		// Stroke Color
		$this->add_control(
			$id . '_stroke_color',
			[
				'label' => esc_html__( 'Stroke Color', 'elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					// SVG Stroke
					'{{WRAPPER}} ' . $selector . ' svg *' => 'stroke: {{VALUE}};',
				],
			]
		);


		// Background
		$this->add_control(
			$id . '_icon_bg',
			[
				'label' => esc_html__( 'Background', 'elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $selector => 'background-color: {{VALUE}};',
				],
			]
		);

		// Border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => $id . '_border',
				'selector' => '{{WRAPPER}} ' . $selector,
			]
		);

		// Border Radius
		$this->add_responsive_control(
			$id . '_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} ' . $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Box Shadow
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => $id . '_shadow',
				'selector' => '{{WRAPPER}} ' . $selector,
			]
		);

		$this->end_controls_tab();

		
		$this->start_controls_tab(
			$id . '_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'elementor-addon' ),
			]
		);

		// Hover Color
		$this->add_control(
			$id . '_hover_color',
			[
				'label' => esc_html__( 'Color', 'elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $selector . ':hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} ' . $selector . ':hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		// Hover Background
		$this->add_control(
			$id . '_hover_bg',
			[
				'label' => esc_html__( 'Background', 'elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $selector . ':hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Hover Border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => $id . '_hover_border',
				'selector' => '{{WRAPPER}} ' . $selector . ':hover',
			]
		);

		// Hover Shadow
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => $id . '_hover_shadow',
				'selector' => '{{WRAPPER}} ' . $selector . ':hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		

		// Size
		$this->add_responsive_control(
			$id . '_size',
			[
				'label' => esc_html__( 'Size', 'elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 8,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $selector => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} ' . $selector . ' svg' => 'width: {{SIZE}}{{UNIT}};height:{{SIZE}}{{UNIT}};',
				],
			]
		);

		// Padding
		$this->add_responsive_control(
			$id . '_padding',
			[
				'label' => esc_html__( 'Padding', 'elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} ' . $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Rotate
		$this->add_responsive_control(
			$id . '_rotate',
			[
				'label' => esc_html__( 'Rotate', 'elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'range' => [
					'deg' => [
						'min' => 0,
						'max' => 360,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $selector => 'transform: rotate({{SIZE}}deg);',
				],
			]
		);

		// Hover Rotate
		$this->add_responsive_control(
			$id . '_hover_rotate',
			[
				'label' => esc_html__( 'Hover Rotate', 'elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'range' => [
					'deg' => [
						'min' => 0,
						'max' => 360,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $selector . ':hover' => 'transform: rotate({{SIZE}}deg);',
				],
			]
		);

		$this->end_controls_section();
	}
}