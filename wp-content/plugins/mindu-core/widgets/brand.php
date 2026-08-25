<?php
class Mindu_Brand extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'mindu-brand';
	}

	public function get_title(): string {
		return esc_html__( 'Brand Slider', 'elementor-addon' );
	}

	public function get_icon(): string {
		return 'eicon-slides';
	}

	public function get_categories(): array {
		return [ 'mindu-category' ];
	}

	public function get_keywords(): array {
		return [ 'brand' ];
	}



	// ====== Register Controls ======
    protected function register_controls(): void {

        // Content Tab
        $this->register_controls_section();

        // Style Tab
        $this->register_style_section();
    }



	protected function register_controls_section() {

		// Content Tab Start

		//======= Brand Slider Widget  =======
			$this->start_controls_section(
				'section_list',
				[
					'label' => esc_html__( 'Brand List', 'elementor-addon' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);

			$this->add_control( 
				'design_layout', 
				[ 
					'label' => esc_html__( 'Brand Layout', 'textdomain' ), 
					'type' => \Elementor\Controls_Manager::SELECT, 
					'default' => 'style_1', 
					'options' => [ 
						'style_1' => esc_html__( 'Layout 01', 'textdomain' ), 
						'style_2' => esc_html__( 'Layout 02', 'textdomain' ), 
					], 
				] 
			); 

			// Repeater Control
			$repeater = new \Elementor\Repeater();
			$repeater->add_control(
				'image',
				[
					'label' => esc_html__( 'Choose Image', 'textdomain' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
				]
			);

			
			
			// Items data Store here
			$this->add_control(
				'list',
				[
					'label' => esc_html__( 'Brand List', 'textdomain' ),
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'list_title' => 'Title #1',
							'image' =>[
								'url' => \Elementor\Utils::get_placeholder_image_src(),
							],
						],
						[
							'list_title' => 'Title #2',
							'image' =>[
								'url' => \Elementor\Utils::get_placeholder_image_src(),
							],
						],

					],
				
				]
			);



			$this->end_controls_section();
		//======= End Widget  =======

		// Content Tab End

	}

	protected function register_style_section() {


		// Style Tab Start
		// ================= Image Style =================
		$this->start_controls_section(
			'brand_image_style_section',
			[
				'label' => esc_html__( 'Image Style', 'elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Image Height
		$this->add_responsive_control(
			'brand_image_height',
			[
				'label'      => esc_html__( 'Height', 'elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 500,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
					],
					'vh' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tp-brand-item img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		// Style Tab End

	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();

		?>

		<?php if($settings['design_layout'] == 'style_2') : ?>


			<!-- tp-brands-area-start -->
			<div class="tp-brand-area fix p-relative m-z-1">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<div class="swiper tp-brand-slider tp-brand-2-slider">
								<div class="swiper-wrapper slide-transtion">
									
									<?php foreach ($settings['list'] as $item) : ?>
										<div class="swiper-slide">
											<div class="tp-brand-item">
												<img src="<?php echo esc_url($item['image']['url']); ?>" alt="#">
											</div>
										</div>
									<?php endforeach; ?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- tp-brands-area-end -->

		<?php else: ?>

			<div class="tp-brand-area fix">
				<div class="swiper tp-brand-slider">
					<div class="swiper-wrapper slide-transtion">

						<?php foreach ($settings['list'] as $item) : ?>
							<div class="swiper-slide">
								<div class="tp-brand-item">
									<img src="<?php echo esc_url($item['image']['url']); ?>" alt="#">
								</div>
							</div>
						<?php endforeach; ?>

					</div>
				</div>
			</div>

		
		<?php endif;  ?>

		<?php

	}

}


/** @var \Elementor\Widgets_Manager $widgets_manager */
$widgets_manager->register( new Mindu_Brand());