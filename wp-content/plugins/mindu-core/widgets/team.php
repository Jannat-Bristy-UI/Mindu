<?php
class Mindu_Team extends \Elementor\Widget_Base {

	// ====== widgets Information ======
	public function get_name(): string {
		return 'mindu-team';
	}

	public function get_title(): string {
		return esc_html__( 'Team', 'elementor-addon' );
	}

	public function get_icon(): string {
		return 'eicon-ehp-zigzag';
	}

	public function get_categories(): array {
		return [ 'mindu-category' ];
	}

	public function get_keywords(): array {
		return [ 'team' ];
	}



	protected function register_controls(): void {

		//------- Content Tab Start ---------

		//======= Title & Content Control Widgets  =======
			$this->start_controls_section(
				'section_content',
				[
					'label' => esc_html__( 'Name & Designation', 'elementor-addon' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);

			$this->add_control(
				'name',
				[
					'label' => esc_html__( 'Name', 'elementor-addon' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Jhon Deen', 'elementor-addon' ),
					'label_block' => true,
				]
			);

			$this->add_control(
				'designation',
				[
					'label' => esc_html__( 'Designation', 'elementor-addon' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Designer', 'elementor-addon' ),
					'label_block' => true,
				]
			);

			$this->add_control(
				'url',
				[
					'label' => esc_html__( 'URL', 'elementor-addon' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Designer', 'elementor-addon' ),
					'label_block' => true,
				]
			);

			$this->end_controls_section();
		//============ Widget End ==========

		//=========== Start Profile Image Widget ===========
			$this->start_controls_section(
				'section_image',
				[
					'label' => esc_html__( 'Profile Image', 'elementor-addon' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);

			$this->add_control(
				'profile image',
				[
					'label' => esc_html__( 'Choose Image', 'textdomain' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
				]
			);
			
			$this->end_controls_section();
		//=========== End Widget  ===========

		//=========== Icon Control Widget ==========
			$this->start_controls_section(
				'section_icon',
				[
					'label' => esc_html__( 'Social Icon', 'elementor-addon' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);

			// Repeater Control
			$repeater = new \Elementor\Repeater();

			$repeater->add_control(
			'icon_style',
				[
					'label' => esc_html__( 'Icon Style', 'textdomain' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'icon',
					'options' => [
						'icon' => esc_html__( 'Icon', 'textdomain' ),
						'svg' => esc_html__( 'SVG', 'textdomain' ),
					],
				]
			);

			$repeater->add_control(
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
			$repeater->add_control(
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

			$repeater->add_control(
				'social_url',
				[
					'label' => esc_html__( 'URL', 'elementor-addon' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( '#', 'elementor-addon' ),
					'label_block' => true,
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
			
						],
						[
							'list_title' => 'Title #2',
							
						],

					],
				
				]
			);

			$this->end_controls_section();
		//============ Widget End ==========

	//------ Content Tab End ------



	// Style Tab Start
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Text Color', 'elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hello-world' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_section();
		// Style Tab End

	}

	
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		?>

		<!-- ============== Team Section Design (HTML MarkUp) =============== -->
		<div class="tp-team-wrap">
			<div class="tp-team-thumb p-relative mb-25">
				<img class="w-100" src="<?php echo esc_url($settings['profile image']['url']); ?>" alt="#">
				<div class="tp-team-social p-absolute">
					<?php foreach ($settings['list'] as $item) : ?>
						<a href="<?php echo esc_url('social_url'); ?>">
							<?php if($item['icon_style'] == 'icon') :?>
								<?php \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
							<?php else : ?>
								<?php echo $item['svg']; ?>
							<?php endif;?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="tp-team-content text-center">

				<h2 class="tp-team-title fw-600 mb-5">
					<a href="<?php echo esc_url($settings['url']); ?>"><?php echo mc_kses($settings['name']); ?> </a>
				</h2>

				<span class="tp-team-subtitle"><?php echo mc_kses($settings['designation']); ?></span>
			</div>

		</div>

		<?php

	}
}


/** @var \Elementor\Widgets_Manager $widgets_manager */
$widgets_manager->register( new Mindu_Team() );