<?php

class Mindu_Icon extends \Elementor\Widget_Base {

   	use Icon_Style_Trait;

	//======== Widgets Information ======

	public function get_name(): string {
		return 'mindu-icon';
	}

	public function get_title(): string {
		return esc_html__( 'Theme Icon', 'elementor-addon' );
	}

	public function get_icon(): string {
		return 'eicon-star';
	}

	public function get_categories(): array {
		return [ 'mindu-category' ];
	}

	public function get_keywords(): array {
		return [ 'icon', 'svg', 'image' ];
	}


	//========= Register Controls (Content & Style) ========

	protected function register_controls(): void {

		$this->register_controls_section();
		$this->register_style_section();

	}


	//=========================================================
	// Content Tab
	//=========================================================

	protected function register_controls_section(){

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
					'default' => 'svg',
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
					'default' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"><g clip-path="url(#clip0_10019_85763)"><path d="M16 6V0.665625L13.9719 2.69375C12.5094 1.04375 10.3812 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16C10.2094 16 12.2094 15.1063 13.6562 13.6562L12.2406 12.2437C11.1563 13.3281 9.65625 14 8 14C4.6875 14 2 11.3156 2 8C2 4.68438 4.6875 2 8 2C9.82812 2 11.45 2.82813 12.5469 4.11875L10.6656 6H16Z" fill="black"/></g><defs><clipPath id="clip0_10019_85763"><rect width="16" height="16" fill="white"/></clipPath></defs></svg>',
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

			$this->add_control(
				'icon_url',
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

			$this->end_controls_section();
		//============ Widget End ==========

	}


	protected function register_style_section(){
		
		
		$this->icon_style_controls( 'icon', 'Icon Style', '.el-icon' );
			
		
	}


	//=========================================================
	// Render
	//=========================================================

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		?>
		
		<span class="tp-section-subtitle el-icon"><?php 
			if($settings['icon_style'] == 'icon') {
				\Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
			} elseif($settings['icon_style'] == 'image') {
				?><img src="<?php echo esc_url($settings['image']['url']); ?>" alt=""><?php
			} else {
				echo $settings['svg'] ?? '';
			}
		?></span>
		
		<?php
	}

}














//=========================================================
// Register Widget
//=========================================================

/** @var \Elementor\Widgets_Manager $widgets_manager */
$widgets_manager->register( new Mindu_Icon() );