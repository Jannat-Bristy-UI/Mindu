<?php


class Mindu_Button extends \Elementor\Widget_Base {

	use Button_Style_Trait;

	//======== widgets Information ======
	public function get_name(): string {
		return 'mindu-button';
	}

	public function get_title(): string {
		return esc_html__( 'Theme Button', 'elementor-addon' );
	}

	public function get_icon(): string {
		return 'eicon-button';
	}

	public function get_categories(): array {
		return [ 'mindu-category' ];
	}

	public function get_keywords(): array {
		return [ 'button' ];
	}



	//========= Register Controls (Content & Style) ========
	protected function register_controls(): void {

		$this->register_controls_section();
		$this->register_style_section();
	}


	// Content Tab
	protected function register_controls_section() {

		//=========== Button ==========
		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button', 'elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'design_layout',
			[
				'label' => esc_html__( 'Button Style', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'style_1',
				'options' => [
					'style_1' => esc_html__( 'Square Button', 'textdomain' ),
					'style_2' => esc_html__( 'Circle Button', 'textdomain' ),
					'style_3' => esc_html__( 'Border Button', 'textdomain' ),
					'style_4' => esc_html__( 'Text Button', 'textdomain' ),
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Button Text', 'elementor-addon' ),
				'placeholder' => esc_html__( 'Enter button text', 'elementor-addon' ),
			]
		);

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

		$this->add_control(
			'icon_style',
			[
				'label'   => esc_html__( 'Icon Type', 'elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'icon',
				'options' => [
					'icon' => [
						'title' => esc_html__( 'Icon', 'elementor-addon' ),
						'icon'  => 'eicon-star',
					],

					'svg' => [
						'title' => esc_html__( 'SVG', 'elementor-addon' ),
						'icon'  => 'eicon-code',
					],
				],
				'toggle' => false,
			]
		);

		$this->add_control(
			'icon',
			[
				'label'     => esc_html__( 'Choose Icon', 'elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition' => [
					'icon_style' => 'icon',
				],
			]
		);

		$this->add_control(
			'svg',
			[
				'label'     => esc_html__( 'SVG Code', 'elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXTAREA,
				'rows'      => 8,
				'default'   => '#',
				'condition' => [
					'icon_style' => 'svg',
				],
			]
		);


		$this->add_control(
			'button_icon_position',
			[
				'label'   => esc_html__( 'Icon Position', 'elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'after',
				'options' => [
					'before' => [
						'title' => esc_html__( 'Before', 'elementor-addon' ),
						'icon'  => 'eicon-h-align-left',
					],
					'after' => [
						'title' => esc_html__( 'After', 'elementor-addon' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'toggle' => false,
			]
		);


		// Icon Size
		$this->add_responsive_control(
			'button_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 8,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tp-btn i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tp-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_icon_spacing',
			[
				'label' => esc_html__( 'Icon Spacing', 'elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 4,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tp-btn-icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tp-btn-icon-after'  => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);



		$this->end_controls_section();
	}


	// Style Tab
	protected function register_style_section(): void {

		// Button style (ID, Title, Selector)
		$this->button_style_controls('button','Button Style','.el-tp-btn');	

	}


	protected function render(): void {

		$settings = $this->get_settings_for_display();

		require __DIR__ . '/template-parts/common-button.php';
	}
}












