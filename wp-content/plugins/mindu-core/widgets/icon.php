<?php

class Mindu_Icon extends \Elementor\Widget_Base {

	use Button_Style_Trait;

	//======== Widgets Information ======

	public function get_name(): string {
		return 'mindu-icon';
	}

	public function get_title(): string {
		return esc_html__( 'Theme Icon', 'elementor-addon' );
	}

	public function get_icon(): string {
		return 'eicon-button';
	}

	public function get_categories(): array {
		return [ 'mindu-category' ];
	}

	public function get_keywords(): array {
		return [ 'icon', 'icon box', 'icon text' ];
	}


	//========= Register Controls (Content & Style) ========

	protected function register_controls(): void {

		$this->register_controls_section();
		$this->register_style_section();

	}


	//=========================================================
	// Content Tab
	//=========================================================

	protected function register_controls_section() {

		//=====================================================
		// Icon Layout
		//=====================================================

		$this->start_controls_section(
			'section_icon_layout',
			[
				'label' => esc_html__( 'Icon Layout', 'elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'icon_layout',
			[
				'label'   => esc_html__( 'Layout', 'elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'      => esc_html__( 'Icon', 'elementor-addon' ),
					'icon_text' => esc_html__( 'Icon With Text', 'elementor-addon' ),
				],
			]
		);

		$this->add_control(
			'layout_separator',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->end_controls_section();


		//=====================================================
		// Icon
		//=====================================================

		$this->start_controls_section(
			'section_icon',
			[
				'label' => esc_html__( 'Icon', 'elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		// Icon Type
		$this->add_control(
			'icon_style',
			[
				'label'   => esc_html__( 'Icon Type', 'elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'  => esc_html__( 'Icon', 'elementor-addon' ),
					'svg'   => esc_html__( 'SVG', 'elementor-addon' ),
					'image' => esc_html__( 'Image', 'elementor-addon' ),
				],
			]
		);


		$this->add_control(
			'icon_type_separator',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		// Font Awesome / Elementor Icon
		$this->add_control(
			'icon',
			[
				'label'       => esc_html__( 'Choose Icon', 'elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-circle',
					'library' => 'fa-solid',
				],
				'label_block' => true,
				'condition'   => [
					'icon_style' => 'icon',
				],
			]
		);


		// SVG
		$this->add_control(
			'svg',
			[
				'label'       => esc_html__( 'SVG Icon Code', 'elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( '<svg>...</svg>', 'elementor-addon' ),
				'label_block' => true,
				'condition'   => [
					'icon_style' => 'svg',
				],
			]
		);


		// Image
		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Choose Image', 'elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'icon_style' => 'image',
				],
			]
		);


		$this->add_control(
			'icon_content_separator',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		//=====================================================
		// Title
		//=====================================================

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Let Us Help', 'elementor-addon' ),
				'placeholder' => esc_html__( 'Enter title', 'elementor-addon' ),
				'label_block' => true,
				'condition'   => [
					'icon_layout' => 'icon_text',
				],
			]
		);


		//=====================================================
		// Sub Title
		//=====================================================

		$this->add_control(
			'sub_title',
			[
				'label'       => esc_html__( 'Sub Title', 'elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Finding Your Right courses', 'elementor-addon' ),
				'placeholder' => esc_html__( 'Enter sub title', 'elementor-addon' ),
				'label_block' => true,
				'condition'   => [
					'icon_layout' => 'icon_text',
				],
			]
		);


		$this->end_controls_section();

	}


	//=========================================================
	// Style Tab
	//=========================================================

	protected function register_style_section(): void {

		// তোমার existing style controls এখানে add করতে পারবে।

	}


	//=========================================================
	// Render
	//=========================================================

	protected function render(): void {

		$settings = $this->get_settings_for_display();

		$icon_layout = $settings['icon_layout'] ?? 'icon';
		$icon_style  = $settings['icon_style'] ?? 'icon';


		//=====================================================
		// Icon Markup
		//=====================================================

		ob_start();

		if ( 'icon' === $icon_style ) {

			if ( ! empty( $settings['icon']['value'] ) ) {

				\Elementor\Icons_Manager::render_icon(
					$settings['icon'],
					[
						'aria-hidden' => 'true',
					]
				);

			}

		} elseif ( 'svg' === $icon_style ) {

			if ( ! empty( $settings['svg'] ) ) {

				echo wp_kses(
					$settings['svg'],
					[
						'svg' => [
							'xmlns'       => true,
							'width'       => true,
							'height'      => true,
							'viewBox'     => true,
							'fill'        => true,
							'stroke'      => true,
							'stroke-width'=> true,
							'class'       => true,
							'aria-hidden' => true,
						],
						'g' => [
							'fill'         => true,
							'stroke'       => true,
							'stroke-width' => true,
							'transform'    => true,
							'fill-rule'    => true,
							'clip-rule'    => true,
						],
						'path' => [
							'd'           => true,
							'fill'        => true,
							'stroke'      => true,
							'stroke-width'=> true,
							'fill-rule'   => true,
							'clip-rule'   => true,
						],
						'circle' => [
							'cx'    => true,
							'cy'    => true,
							'r'     => true,
							'fill'  => true,
							'stroke'=> true,
						],
						'rect' => [
							'x'      => true,
							'y'      => true,
							'width'  => true,
							'height' => true,
							'rx'     => true,
							'fill'   => true,
							'stroke' => true,
						],
						'line' => [
							'x1'    => true,
							'x2'    => true,
							'y1'    => true,
							'y2'    => true,
							'stroke'=> true,
						],
						'polygon' => [
							'points' => true,
							'fill'   => true,
							'stroke' => true,
						],
					]
				);

			}

		} elseif ( 'image' === $icon_style ) {

			if ( ! empty( $settings['image']['url'] ) ) {

				$image_url = $settings['image']['url'];

				echo '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr__( 'Icon', 'elementor-addon' ) . '">';

			}

		}

		$icon_markup = ob_get_clean();


		//=====================================================
		// Layout 01 - Icon Only
		//=====================================================

		if ( 'icon' === $icon_layout ) :

			?>

			<span class="mindu-icon">
				<?php echo $icon_markup; ?>
			</span>

			<?php

		endif;


		//=====================================================
		// Layout 02 - Icon With Text
		//=====================================================

		if ( 'icon_text' === $icon_layout ) :

			?>

			<div class="tp-course-banner-content d-flex align-items-center">

				<div class="tp-course-banner-shape">
					<?php echo $icon_markup; ?>
				</div>

				<div class="tp-course-banner-text">

					<?php if ( ! empty( $settings['title'] ) ) : ?>

						<span>
							<?php echo esc_html( $settings['title'] ); ?>
						</span>

					<?php endif; ?>


					<?php if ( ! empty( $settings['sub_title'] ) ) : ?>

						<h2 class="tp-course-banner-title">
							<?php echo esc_html( $settings['sub_title'] ); ?>
						</h2>

					<?php endif; ?>

				</div>

			</div>

			<?php

		endif;

	}

}


//=========================================================
// Register Widget
//=========================================================

/** @var \Elementor\Widgets_Manager $widgets_manager */
$widgets_manager->register( new Mindu_Icon() );