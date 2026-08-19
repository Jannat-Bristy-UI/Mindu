<?php
class Mindu_Icon_Box extends \Elementor\Widget_Base {

	use Common_Trait_Style;
	use Common_Icon_Style;
	use Button_Style_Trait;
	use Icon_Style_Trait;

	// ====== widgets Information ======
	public function get_name(): string {
		return 'mindu-icon-box';
	}

	public function get_title(): string {
		return esc_html__( 'Icon Box', 'elementor-addon' );
	}

	public function get_icon(): string {
		return 'eicon-ehp-zigzag';
	}

	public function get_categories(): array {
		return [ 'mindu-category' ];
	}

	public function get_keywords(): array {
		return [ 'icon box' ];
	}

	
	protected function register_controls(): void {

		$this->register_controls_section();
		$this->register_style_section();

	}


	//------ Content Tab End ------
	protected function register_controls_section(){

		//------- Content Tab Start ---------

		//=========== Icon Control Widget ==========
			$this->start_controls_section(
				'section_icon',
				[
					'label' => esc_html__( 'Icon', 'elementor-addon' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);

			$this->add_control(
			'icon_style',
				[
					'label' => esc_html__( 'Icon Style', 'textdomain' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'icon',
					'options' => [
						'icon' => esc_html__( 'Icon', 'textdomain' ),
						'svg' => esc_html__( 'SVG', 'textdomain' ),
						'image' => esc_html__( 'Image', 'textdomain' ),
					],
				]
			);

			$this->add_control(
				'icon',
				[
					'label' => esc_html__( 'Choose Icon', 'textdomain' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-circle',
						'library' => 'fa-solid',
					],
					'condition' => [
						'icon_style' => 'icon',
					],
				]
			);

			// Selection Control for Icons
			$this->add_control(
				'svg',
				[
					'label' => esc_html__( 'SVG Icon Code', 'elementor-addon' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'default' => esc_html__( '#', 'elementor-addon' ),

					'condition' => [
						'icon_style' => 'svg',
					],
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

					'condition' => [
						'icon_style' => 'image',
					],
				]
			);

			$this->end_controls_section();
		//============ Widget End ==========
		

		//======= Title & Content Control Widgets  =======
			$this->start_controls_section(
				'section_content',
				[
					'label' => esc_html__( 'Title & Content', 'elementor-addon' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);

			$this->add_control(
				'title',
				[
					'label' => esc_html__( 'Title', 'elementor-addon' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'Hello world', 'elementor-addon' ),
				]
			);

			$this->add_control(
				'content',
				[
					'label' => esc_html__( 'Content', 'elementor-addon' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'Content Here', 'elementor-addon' ),
				]
			);

			
			// Alignment
			$this->add_responsive_control(
				'text_align',
				[
					'label' => esc_html__( 'Alignment', 'elementor-addon' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'elementor-addon' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'elementor-addon' ),
							'icon'  => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'elementor-addon' ),
							'icon'  => 'eicon-text-align-right',
						],
					],
					'default' => 'center',
					'toggle'  => true,
					'selectors' => [
						'{{WRAPPER}} .tp-service-item' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->end_controls_section();
		//============ Widget End ==========


		//=========== Start Button Control Widgets ===========
			$this->start_controls_section(
				'section_button',
				[
					'label' => esc_html__( 'Button', 'elementor-addon' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);

			$this->add_control(
				'button_text',
				[
					'label' => esc_html__( 'Button Text', 'elementor-addon' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Read More', 'elementor-addon' ),
					'label_block' => true,
				]
			);

			$this->add_control(
				'button_url',
				[
					'label' => esc_html__( 'Link', 'textdomain' ),
					'type' => \Elementor\Controls_Manager::URL,
					'options' => [ 'url', 'is_external', 'nofollow' ],
					'default' => [
						'url' => '#',
						'is_external' => true,
						'nofollow' => true,
					],
					'label_block' => true,
				]
			);

			// Button Icon Control
			$this->add_control(
			'icon_type',
				[
					'label' => esc_html__( 'Icon Type', 'textdomain' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'svg',
					'options' => [
						'icon' => esc_html__( 'Icon', 'textdomain' ),
						'svg' => esc_html__( 'SVG', 'textdomain' ),
						'image' => esc_html__( 'Image', 'textdomain' ),
					],
				]
			);

			$this->add_control(
				'button_icon',
				[
					'label' => esc_html__( 'Choose Icon', 'textdomain' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-circle',
						'library' => 'fa-solid',
					],
					'condition' => [
						'icon_type' => 'icon',
					],
				]
			);

			// Selection Icon Control
			$this->add_control(
				'svg_code',
				[
					'label' => esc_html__( 'SVG Icon Code', 'elementor-addon' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					 'default' => '<svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.71527 1L13 5.28471L8.71527 9.56941" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M1 5.28473H12.88" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>',

					'condition' => [
						'icon_type' => 'svg',
					],
				]	
			);

			$this->add_control(
				'button_image',
				[
					'label' => esc_html__( 'Choose Image', 'textdomain' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],

					'condition' => [
						'icon_type' => 'image',
					],
				]
			);

			$this->end_controls_section();
		//======= End Widget  =======
	}
	

	// Style Tab
	protected function register_style_section(){
		$this->common_trait_style('title', 'Title', '.el-title');
		$this->common_trait_style('content', 'Content', '.el-content');
		$this->icon_style_controls( 'icon', 'Icon Style', '.el-icon' );
		$this->button_style_controls('button','Button Style','.el-tp-btn');	
		
	}


	

	

	
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		// This is for multiple attribute for button
		if(!empty($settings['button_text'])){
			$this->add_link_attributes( 'button_arg', $settings['button_url'] );
			$this->add_render_attribute('button_arg', 'class', 'el-tp-btn tp-service-btn fw-700 tp-ff-heading');
		}

		?>

		<!-- ============== service Section Design (HTML MarkUp) =============== -->
		<div class="tp-service-item mb-30 wow fadeInUp" data-wow-duration=".9s" data-wow-delay=".3s">
			<span class="tp-service-icon mb-25 el-icon">

				<!-- Multiple Icone print condition -->
				<?php if($settings['icon_style'] == 'icon') :?>
					<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
				<?php elseif($settings['icon_style'] == 'image') :?>
					<img src="<?php echo esc_url($settings['image']['url']); ?>" alt="">
				<?php else : ?>
					<?php echo mc_kses( $settings['svg'] ?? '' ); ?>
				<?php endif;?>

			</span>
			
			<!-- Title Dynamic Widget -->
			<?php if(!empty($settings['title'])) : ?>
				<h2 class="tp-service-title fw-700 mb-15 el-title">
					<?php echo mc_kses($settings['title']); ?>  
				</h2>
			<?php endif; ?>
			
			<!-- Content Dynamic Widget -->
			<?php if(!empty($settings['content'])) : ?>
				<p class="tp-service-dec fw-500 el-content">
					<?php echo mc_kses($settings['content']); ?>
				</p>
			<?php endif; ?>
			

			<!-- Button Dynamic Widget -->
			<!-- Button Dynamic Widget -->
			<?php if(!empty($settings['button_text'])) : ?> 
				<a <?php echo $this->get_render_attribute_string( 'button_arg' ); ?>>
					<?php echo esc_html( $settings['button_text'] ); ?>

					<!-- Multiple Icone print condition for Button Icone -->
					<span class="tp-btn-icon ml-8 el-icon">
						<?php if($settings['icon_type'] == 'icon') :?>
							<?php \Elementor\Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>                                   
						<?php elseif($settings['icon_type'] == 'image') :?>
							<img src="<?php echo esc_url($settings['button_image']['url']); ?>" alt="">
						<?php else : ?>
							<?php echo $settings['svg_code']; ?>
						<?php endif;?>
					</span>

				</a>
			<?php endif; ?>
        </div>

		<?php

	}
}