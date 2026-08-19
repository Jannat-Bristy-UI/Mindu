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

	public function get_style_depends(): array {
		return [ 'elementor-icons-fa-solid' ];
	}
 
 
 
	//========= Register Controls (Content & Style) ======== 
	protected function register_controls(): void { 

		$this->register_controls_section(); 
		$this->register_style_section(); 

	} 
 


	// ===============================
	// Content Tab  
	// ===============================

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
					'style_1' => esc_html__( 'Primary Button', 'textdomain' ), 
					'style_2' => esc_html__( 'Login Button', 'textdomain' ), 
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
				'label'        => esc_html__( 'Link', 'elementor-addon' ), 
				'type'         => \Elementor\Controls_Manager::URL, 
				'options'      => [ 'url', 'is_external', 'nofollow' ], 
				'default'      => [ 
					'url'         => '#', 
					'is_external' => false, 
					'nofollow'    => false, 
				], 
				'label_block' => true, 
			] 
		); 

		$this->end_controls_section();


		// =========== Icon Control ==========
		$this->start_controls_section(
			'icon_style_section',
			[
				'label' => esc_html__( 'Icon Style', 'elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

 
		$this->add_control( 
			'icon_type', 
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
			'button_icon', 
			[ 
				'label'   => esc_html__( 'Choose Icon', 'textdomain' ), 
				'type'    => \Elementor\Controls_Manager::ICONS, 
				'default' => [ 
					'value'   => 'fas fa-circle', 
					'library' => 'fa-solid', 
				], 
 
				'condition' => [ 
					'icon_type' => 'icon', 
				], 
			] 
		); 
 
		$this->add_control( 
			'svg', 
			[ 
				'label'     => esc_html__( 'SVG Code', 'elementor-addon' ), 
				'type'      => \Elementor\Controls_Manager::TEXTAREA, 
				'rows'      => 8, 
				'default'   => '', 
				'condition' => [ 
					'icon_type' => 'svg', 
				], 
			] 
		); 


		// Icon Size
		$this->add_responsive_control(
			'icon_size',
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
					'{{WRAPPER}} .tp-btn-icon i' =>
						'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tp-btn-icon svg' =>
						'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Icon Gap
		$this->add_responsive_control(
			'icon_gap',
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
					'{{WRAPPER}} .tp-btn-icon' =>
						'margin-inline-start: {{SIZE}}{{UNIT}}; margin-inline-end: 0;',
				],
			]
		);
 
		$this->end_controls_section(); 
	} 


 
 
	// ===============================
	// Style Tab 
	// ===============================

	protected function register_style_section(): void { 

		// Button style (ID, Title, Selector) 
		$this->button_style_controls('button','Button Style','.el-tp-btn');	 
		 
	} 
 
 
	protected function render(): void {

		$settings = $this->get_settings_for_display();


		// ==========================
		// Button Style
		// ==========================
		switch ( $settings['design_layout'] ) {

			case 'style_2':
				// Login Button
				$button_class = 'tp-btn el-tp-btn';
			break;

			case 'style_3':
				// Border Button
				$button_class = 'tp-btn tp-btn-border tp-btn-xl mr-10 el-tp-btn';
			break;

			case 'style_4':
				// Text Button
				$button_class = 'tp-btn tp-btn-transparent el-tp-btn';
			break;

			case 'style_1':
			default:
				// Primary Button
				$button_class = 'tp-btn tp-btn-xl mr-10 el-tp-btn';
			break;

		}


		// ==========================
		// Button Attributes
		// ==========================
		if ( ! empty( $settings['button_text'] ) ) {
			$this->add_link_attributes( 'button_arg', $settings['button_url'] );
			$this->add_render_attribute( 'button_arg', 'class', $button_class );
		}

		?>

		<!--==========================
			Button Render
		===========================-->
		
		<?php if ( ! empty( $settings['button_text'] ) ) : ?>

			<a <?php echo $this->get_render_attribute_string( 'button_arg' ); ?>>

				<?php echo mc_kses( $settings['button_text'] ); ?>

				<span class="ml-8 tp-btn-icon">

					<!-- Multipule Icon Print -->
					<?php if ( $settings['icon_type'] == 'icon' ) : ?>
						<?php \Elementor\Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
					<?php else : ?>
						<?php echo mc_kses( $settings['svg'] ); ?>
					<?php endif; ?>

				</span>

			</a>

		<?php endif; ?>

		<?php
	} 
}

/** @var \Elementor\Widgets_Manager $widgets_manager */
$widgets_manager->register( new Mindu_Button() );











