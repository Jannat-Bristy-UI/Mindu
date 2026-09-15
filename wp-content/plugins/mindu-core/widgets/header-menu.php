
<?php

class Mindu_Header_Menu extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'mindu-header_menu';
	}

	public function get_title(): string {
		return esc_html__( 'Header Menu', 'elementor-addon' );
	}

	public function get_icon(): string {
		return 'eicon-parallax';
	}

	public function get_categories(): array {
		return [ 'mindu-category' ];
	}

	public function get_keywords(): array {
		return [ 'menu' ];
	}

	protected function register_controls(): void {

		$this->register_controls_section();
		$this->register_style_section();

	}



	// Get_Nav_menus (Get all available navigation menus)
	private function get_nav_menus() {

		$menus = wp_get_nav_menus();
		$options = [];

		if ( ! empty( $menus ) ) {
			foreach ( $menus as $menu ) {
				$options[ $menu->term_id ] = $menu->name;
			}
		}

		return $options;
	}



	//================== content tab =====================

	protected function register_controls_section(){

		$this->start_controls_section(
			'section_menu',
			[
				'label' => esc_html__( 'Main Menu', 'elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Select Menu
		$this->add_control(
			'menu',
			[
				'label'   => esc_html__( 'Select Menu', 'elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => $this->get_nav_menus(),
				'default' => '',
			]
		);

		// Layout Control
		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'vertical' => [
						'title' => esc_html__( 'Vertical / List', 'elementor-addon' ),
						'icon'  => 'eicon-editor-list-ul',
					],
					'horizontal' => [
						'title' => esc_html__( 'Horizontal / Inline', 'elementor-addon' ),
						'icon'  => 'eicon-ellipsis-h',
					],
				],
				'default' => 'horizontal',
				'toggle'  => false,
				'selectors' => [

					// Horizontal / Inline
					'{{WRAPPER}} .el-menu-layout-horizontal ul.tp-menu-el' => 'display: flex !important; flex-direction: row !important; flex-wrap: wrap !important;',

					'{{WRAPPER}} .el-menu-layout-horizontal ul.tp-menu-el > li' => 'display: block !important;',

					// Vertical / List
					'{{WRAPPER}} .el-menu-layout-vertical ul.tp-menu-el' => 'display: flex !important; flex-direction: column !important; align-items: flex-start !important;',

					'{{WRAPPER}} .el-menu-layout-vertical ul.tp-menu-el > li' => 'display: block !important; width: 100% !important;',
				],
			]
		);

		// Alignment
		$this->add_control(
			'text_align',
			[
				'label'   => esc_html__( 'Alignment', 'textdomain' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'textdomain' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'textdomain' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'textdomain' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => 'right',
				'toggle'  => true,
				'selectors' => [
					'{{WRAPPER}} .el-menu' => 'text-align: {{VALUE}};',
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
				'label' => esc_html__( 'Item Gap', 'elementor-addon' ),
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

					// Reset UL
					'{{WRAPPER}} .tp-main-menu nav ul.tp-menu-el' => 'margin: 0 !important; padding: 0 !important;',

					// Reset LI
					'{{WRAPPER}} .tp-main-menu nav ul.tp-menu-el > li' => 'margin: 0 !important; padding: 0 !important;',

					// Reset submenu spacing
					'{{WRAPPER}} .tp-main-menu nav ul.tp-menu-el > li > ul' => 'margin: 0 !important;',

					// Horizontal gap
					'{{WRAPPER}} .el-menu-layout-horizontal .tp-main-menu nav ul.tp-menu-el > li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}} !important;',

					// Vertical gap
					'{{WRAPPER}} .el-menu-layout-vertical .tp-main-menu nav ul.tp-menu-el > li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);


		$this->end_controls_section();

	}



	//===================== Render =============================

	protected function render(): void {

		$settings = $this->get_settings_for_display();

		if ( empty( $settings['menu'] ) ) {
			return;
		}

		$layout = ! empty( $settings['layout'] ) ? $settings['layout'] : 'horizontal';

		?>

		<div class="tp-header-left el-menu el-menu-layout-<?php echo esc_attr( $layout ); ?>">
			<div class="tp-main-menu tp-main-menu-2 tp-menu-dropdown">
				<nav class="tp-mobile-menu-active">
					<?php
						wp_nav_menu( [
							'menu'        => (int) $settings['menu'],
							'menu_class'  => 'tp-menu-el',
							'container'   => '',
							'fallback_cb' => 'Mindu_Walker_Nav_Menu::fallback',
							'walker'      => new Mindu_Walker_Nav_Menu,
						] );
					?>
				</nav>
			</div>
		</div>

		<?php
	}

}


/** @var \Elementor\Widgets_Manager $widgets_manager */
$widgets_manager->register( new Mindu_Header_Menu() );

