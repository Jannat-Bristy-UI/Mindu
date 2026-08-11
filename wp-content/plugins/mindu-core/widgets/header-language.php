<?php

class Mindu_Header_Language extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'header-language';
	}

	public function get_title(): string {
		return esc_html__( 'Header Language', 'elementor-addon' );
	}

	public function get_icon(): string {
		return 'eicon-parallax';
	}

	public function get_categories(): array {
		return [ 'mindu-category' ];
	}

	public function get_keywords(): array {
		return [ 'language' ];
	}



	protected function register_controls(): void {

		$this->register_controls_section();
		$this->register_style_section();

	}


	//================== content tab =====================
	protected function register_controls_section(){

		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Logo', 'elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

	}

	//===================== style tab =============================
	protected function register_style_section() {

		$this->start_controls_section(
			'menu_item_style',
			[
				'label' => esc_html__( 'Menu Item', 'elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'menu_item_typography',
				'selector' => '{{WRAPPER}} .tp-main-menu ul li > a',
			]
		);

		// Tabs
		$this->start_controls_tabs( 'menu_item_tabs' );

			// Normal
			$this->start_controls_tab(
				'menu_item_normal',
				[
					'label' => esc_html__( 'Normal', 'elementor-addon' ),
				]
			);

			$this->add_control(
				'menu_item_color',
				[
					'label' => esc_html__( 'Color', 'elementor-addon' ),
					'type'  => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-main-menu ul li > a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

			// Hover
			$this->start_controls_tab(
				'menu_item_hover',
				[
					'label' => esc_html__( 'Hover', 'elementor-addon' ),
				]
			);

			$this->add_control(
				'menu_item_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'elementor-addon' ),
					'type'  => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-main-menu ul li:hover > a' => 'color: {{VALUE}};',
						'{{WRAPPER}} .tp-main-menu ul li > a:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

			// Active
			$this->start_controls_tab(
				'menu_item_active',
				[
					'label' => esc_html__( 'Active', 'elementor-addon' ),
				]
			);

		// End tab


		$this->add_control(
			'menu_item_active_color',
			[
				'label' => esc_html__( 'Active Color', 'elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-main-menu ul li.current-menu-item > a'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .tp-main-menu ul li.current_page_item > a'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .tp-main-menu ul li.current-menu-ancestor > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Padding
		$this->add_responsive_control(
			'menu_item_padding',
			[
				'label' => esc_html__( 'Padding', 'elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-main-menu ul li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Item Gap
		$this->add_responsive_control(
			'menu_gap',
			[
				'label' => 'Item Gap',
				'type'  => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],

				'default' => [
					'unit' => 'px',
					'size' => 35,
				],

				'selectors' => [
					'{{WRAPPER}} .tp-main-menu nav ul li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();
	}



	// Render the HTML markup for the header language widget.
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		?>

		<!-- Language Menu switch option function -->
		<?php if ( has_nav_menu( 'lang-menu' ) && function_exists('language_menu') ) : ?>
			<div class="tp-lang-nav">
				<!-- Call a PHP function to display the header language menu dynamically -->
				<?php language_menu(); ?>
			</div>

		<?php else : ?>

			<div class="tp-header-menu-item tp-header-currency ml-25">                   
				<span class="tp-header-currency-toggle" id="tp-header-currency-toggle"><img src="<?php echo get_template_directory_uri(); ?> /assets/img/flag/01.png" alt=""> English</span>
				<ul>
					
					<li>
						<a href="#"><img src="<?php echo get_template_directory_uri(); ?> /assets/img/flag/01.png" alt=""> Canada  </a>
					</li>
					<li>
						<a href="#"><img src="<?php echo get_template_directory_uri(); ?> /assets/img/flag/02.png" alt=""> Malaysia  </a>
					</li>
					<li>
						<a href="#"><img src="<?php echo get_template_directory_uri(); ?> /assets/img/flag/03.png" alt=""> Germany </a>
					</li>
					<li>
						<a href="#"><img src="<?php echo get_template_directory_uri(); ?> /assets/img/flag/04.png" alt=""> Belize  </a>
					</li>
					<li>
						<a href="#"><img src="<?php echo get_template_directory_uri(); ?> /assets/img/flag/05.png" alt=""> United States</a>
					</li>

				</ul>
			</div> 

		<?php endif; ?>   



		<?php

	}
}

/** @var \Elementor\Widgets_Manager $widgets_manager */
$widgets_manager->register( new Mindu_Header_Language() );