<?php
class Mindu_Image_Flip extends \Elementor\Widget_Base {

	use Common_Trait_Style;

	public function get_name(): string {
		return 'mindu-image-flip';
	}

	public function get_title(): string {
		return esc_html__( 'Theme Image Flip', 'elementor-addon' );
	}

	public function get_icon(): string {
		return 'eicon-parallax';
	}

	public function get_categories(): array {
		return [ 'mindu-category' ];
	}

	public function get_keywords(): array {
		return [ 'image flip', 'theme image flip' ];
	}

	protected function register_controls(): void {

		$this->register_controls_section();
		$this->register_style_section();

	}

	// content tab 
	protected function register_controls_section(){
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image Flip', 'elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);



		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'elementor-addon' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

	}

	// style tab 
	protected function register_style_section(){
		
		// $this->common_trait_style('subtitle','Sub Title','.el-sub-title');

	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();

		?>

      	<!-- tp-video-area-start -->
		<div class="tp-community-item ">
			<img src="<?php echo esc_url($settings['image']['url']); ?>" alt="">
		</div>
            
		<?php
	}
}

/** @var \Elementor\Widgets_Manager $widgets_manager */
$widgets_manager->register( new Mindu_Image_Flip() );