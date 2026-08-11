<?php

class Mindu_Header_Search extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'mindu-header_search';
	}

	public function get_title(): string {
		return esc_html__( 'Header Search', 'elementor-addon' );
	}

	public function get_icon(): string {
		return 'eicon-parallax';
	}

	public function get_categories(): array {
		return [ 'mindu-category' ];
	}

	public function get_keywords(): array {
		return [ 'search' ];
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



	// Render the HTML markup for the header menu widget.
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		?>


		<div class="tp-header-2-option">
			<button class="tp-header-search tp-search-click d-none d-sm-block">
				<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M11.6389 11.6389L14.7499 14.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					<path d="M13.1941 6.97222C13.1941 3.53578 10.4084 0.75 6.97206 0.75C3.53571 0.75 0.75 3.53578 0.75 6.97222C0.75 10.4087 3.53571 13.1944 6.97206 13.1944C10.4084 13.1944 13.1941 10.4087 13.1941 6.97222Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
			</button>
		</div>

		<!--search-form-start -->
		<div class="tp-offcanvas-overlay"></div>
		<div class="tp-search-form-toggle">
			<div class="container">
				<div class="row mb-70">
					<div class="col-lg-12">
					<div class="tp-search-top d-flex justify-content-between align-items-center">
						<div class="cm-search-logo">
							<a href="<?php echo home_url(); ?>"><img data-width="108" src="<?php echo esc_url($settings['image']['url']); ?>" alt="Mindu Logo"></a>
						</div>
						<button class="tp-search-close">
							<i class="fa-light fa-xmark"></i>
						</button>
					</div>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-12">
					<div class="tp-search-form">
						<form action="#">
							<div class="tp-search-form-input">
								<input type="text" placeholder="What are you looking foor?" required>
								<span class="tp-search-focus-border"></span>
								<button class="tp-search-form-icon" type="submit">
								<i class="fa-sharp fa-regular fa-magnifying-glass"></i>
								</button>
							</div>
						</form>
					</div>
					</div>
				</div>
			</div>
		</div>
   		<!-- search-form-end -->



		<?php

	}
}

/** @var \Elementor\Widgets_Manager $widgets_manager */
$widgets_manager->register( new Mindu_Header_Search() );