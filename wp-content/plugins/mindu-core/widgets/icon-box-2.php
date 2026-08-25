<?php
class Mindu_Icon_Box extends \Elementor\Widget_Base {

	use TP_Common_Style, TP_Link_Style_Trait,TP_Icon_Style_Trait;

	public function get_name(): string {
		return 'mindu-icon-box';
	}

	public function get_title(): string {
		return esc_html__( 'Icon Box', 'elementor-addon' );
	}

	public function get_icon(): string {
		return 'eicon-parallax';
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

	protected function register_controls_section(): void {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Design Layout', 'elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'design_layout',
			[
				'label' => esc_html__( 'Design Layout', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'style_1',
				'options' => [
					'style_1' => esc_html__( 'Layout 01', 'textdomain' ),
					'style_2' => esc_html__( 'Layout 02', 'textdomain' ),
					'style_3' => esc_html__( 'Layout 03', 'textdomain' ),
					'style_4' => esc_html__( 'Layout 04', 'textdomain' ),
				],
			]
		);

		$this->end_controls_section();


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
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Hello world', 'elementor-addon' ),
				'label_block' => true,
				'label_block' => true,
			]
		);

		$this->add_control(
			'content',
			[
				'label' => esc_html__( 'Content', 'elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Content here', 'elementor-addon' ),
			]
		);

		$this->end_controls_section();

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
					'image' => esc_html__( 'Image', 'textdomain' ),
					'svg' => esc_html__( 'SVG', 'textdomain' ),
				],
			]
		);


		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-smile',
					'library' => 'fa-solid',
				],
				'condition' => [
					'icon_style' => 'icon',
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

		$this->add_control(
			'svg',
			[
				'label' => esc_html__( 'SVG Icon Code', 'elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'condition' => [
					'icon_style' => 'svg',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button', 'elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'design_layout' => ['style_1','style_2'],
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Button Text', 'elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Button Text', 'elementor-addon' ),
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
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);

		$this->end_controls_section();

	}

	// style tab 
	protected function register_style_section(){
		
		$this->tp_text_style_controls('subtitle','Sub Title','.el-sub-title');
		$this->tp_text_style_controls('title','Title','.el-title');
		$this->tp_text_style_controls('content','Content','.el-content');

		$this->tp_link_controls_style('btn','Button','.el-btn');
		$this->tp_icon_style_controls('icon','Icon','.el-icon');

	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();

		?>

		<?php if($settings['design_layout'] == 'style_2') : 
			if(!empty($settings['button_text'])){
				$this->add_link_attributes( 'button_arg', $settings['button_url'] );
				$this->add_render_attribute('button_arg', 'class', 'tp-service-btn fw-700 tp-ff-heading el-btn');
			}
		?>
		<div class="tp-service-item tp-service-2-item mb-30">
			<span class="tp-service-icon mb-70 el-icon">
				<?php if($settings['icon_style'] == 'icon') : ?>
				<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
				<?php elseif($settings['icon_style'] == 'image') : ?>
				<img src="<?php echo esc_url($settings['image']['url']); ?>" alt="">	
				<?php else : ?>
				<?php echo $settings['svg']; ?>	
				<?php endif; ?>	
			</span>
			<?php if(!empty($settings['title'])) : ?>
			<h2 class="tp-service-title fw-700 mb-15 el-title"><?php echo mc_kses($settings['title']); ?></h2>
			<?php endif; ?>
			<?php if(!empty($settings['content'])) : ?>
			<p class="tp-service-dec fw-500 mb-35 el-content"><?php echo mc_kses($settings['content']); ?></p>
			<?php endif; ?>
			
			<?php if(!empty($settings['button_text'])) : ?>
			<a <?php echo $this->get_render_attribute_string( 'button_arg' ); ?>>
			<?php echo mc_kses($settings['button_text']); ?>
			<svg class="ml-5" width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M6.21983 0.20932C6.36048 0.0752924 6.55121 0 6.75009 0C6.94897 0 7.1397 0.0752924 7.28035 0.20932L11.7804 4.49886C11.921 4.63293 12 4.81474 12 5.00432C12 5.19389 11.921 5.3757 11.7804 5.50977L7.28035 9.79931C7.13889 9.92954 6.94944 10.0016 6.75279 9.99997C6.55614 9.99834 6.36803 9.92316 6.22897 9.7906C6.08991 9.65805 6.01103 9.47874 6.00933 9.29129C6.00762 9.10384 6.08321 8.92325 6.21983 8.78841L9.43963 5.71924H0.75001C0.551095 5.71924 0.360327 5.64392 0.219673 5.50984C0.0790187 5.37577 0 5.19393 0 5.00432C0 4.81471 0.0790187 4.63286 0.219673 4.49879C0.360327 4.36471 0.551095 4.28939 0.75001 4.28939H9.43963L6.21983 1.22022C6.07923 1.08615 6.00024 0.904344 6.00024 0.714771C6.00024 0.525199 6.07923 0.343388 6.21983 0.20932Z" fill="currentColor" />
			</svg>
			</a>
			<?php endif; ?>
		</div>

		<?php elseif($settings['design_layout'] == 'style_3') : ?>
		<div class="tp-feature-item text-center mb-30 mt-40">
			<span class="tp-feature-icon p-relative mb-20 el-icon">
				<?php if($settings['icon_style'] == 'icon') : ?>
				<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
				<?php elseif($settings['icon_style'] == 'image') : ?>
				<img src="<?php echo esc_url($settings['image']['url']); ?>" alt="">	
				<?php else : ?>
				<?php echo $settings['svg']; ?>	
				<?php endif; ?>	
			</span>
			<?php if(!empty($settings['title'])) : ?>
			<h2 class="tp-feature-title fw-700 mb-10 el-title"><?php echo mc_kses($settings['title']); ?></h2>
			<?php endif; ?>
			<?php if(!empty($settings['content'])) : ?>
			<p class="tp-feature-dec fw-500 el-content"><?php echo mc_kses($settings['content']); ?></p>
			<?php endif; ?>
		</div>

		<?php elseif($settings['design_layout'] == 'style_4') : ?>
		<div class="tp-service-3-item tp-about-mission-item d-flex align-items-center">
			<span class="tp-about-mission-icon mr-20 d-inline-flex justify-content-center align-items-center el-icon">
				<?php if($settings['icon_style'] == 'icon') : ?>
				<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
				<?php elseif($settings['icon_style'] == 'image') : ?>
				<img src="<?php echo esc_url($settings['image']['url']); ?>" alt="">	
				<?php else : ?>
				<?php echo $settings['svg']; ?>	
				<?php endif; ?>	
			</span>
			<div>
			<?php if(!empty($settings['title'])) : ?>	
			<h3 class="tp-about-mission-title fw-700 mb-5"><?php echo mc_kses($settings['title']); ?></h3>
			<?php endif; ?>
			<?php if(!empty($settings['content'])) : ?>
			<p class="fw-500 mb-0"><?php echo mc_kses($settings['content']); ?></p>
			<?php endif; ?>
			</div>
		</div>
		<?php else : 
			if(!empty($settings['button_text'])){
				$this->add_link_attributes( 'button_arg', $settings['button_url'] );
				$this->add_render_attribute('button_arg', 'class', 'tp-service-btn fw-700 tp-ff-heading el-btn');
			}
		?>	
		<div class="tp-service-item mb-30">
			<span class="tp-service-icon mb-25 el-icon">
				<?php if($settings['icon_style'] == 'icon') : ?>
				<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
				<?php elseif($settings['icon_style'] == 'image') : ?>
				<img src="<?php echo esc_url($settings['image']['url']); ?>" alt="">	
				<?php else : ?>
				<?php echo $settings['svg']; ?>	
				<?php endif; ?>	
			</span>
			<?php if(!empty($settings['title'])) : ?>		
			<h2 class="tp-service-title fw-700 mb-15 el-title"><?php echo mc_kses($settings['title']); ?></h2>
			<?php endif; ?>
			<?php if(!empty($settings['content'])) : ?>
			<p class="tp-service-dec fw-500 el-content"><?php echo mc_kses($settings['content']); ?></p>
			<?php endif; ?>

			<?php if(!empty($settings['button_text'])) : ?>
			<a <?php echo $this->get_render_attribute_string( 'button_arg' ); ?>>
			<?php echo mc_kses($settings['button_text']); ?>
			<svg class="ml-5" width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M6.21983 0.20932C6.36048 0.0752924 6.55121 0 6.75009 0C6.94897 0 7.1397 0.0752924 7.28035 0.20932L11.7804 4.49886C11.921 4.63293 12 4.81474 12 5.00432C12 5.19389 11.921 5.3757 11.7804 5.50977L7.28035 9.79931C7.13889 9.92954 6.94944 10.0016 6.75279 9.99997C6.55614 9.99834 6.36803 9.92316 6.22897 9.7906C6.08991 9.65805 6.01103 9.47874 6.00933 9.29129C6.00762 9.10384 6.08321 8.92325 6.21983 8.78841L9.43963 5.71924H0.75001C0.551095 5.71924 0.360327 5.64392 0.219673 5.50984C0.0790187 5.37577 0 5.19393 0 5.00432C0 4.81471 0.0790187 4.63286 0.219673 4.49879C0.360327 4.36471 0.551095 4.28939 0.75001 4.28939H9.43963L6.21983 1.22022C6.07923 1.08615 6.00024 0.904344 6.00024 0.714771C6.00024 0.525199 6.07923 0.343388 6.21983 0.20932Z" fill="currentColor" />
			</svg>
			</a>
			<?php endif; ?>
		</div>
		<?php endif; ?>

            
		<?php
	}
}

$widgets_manager->register( new Mindu_Icon_Box() );