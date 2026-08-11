<?php
class Mindu_Button extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'mindu-button';
	}

	public function get_title(): string {
		return esc_html__( 'Theme Button', 'elementor-addon' );
	}

	public function get_icon(): string {
		return 'eicon-parallax';
	}

	public function get_categories(): array {
		return [ 'mindu-category' ];
	}

	public function get_keywords(): array {
		return [ 'button' ];
	}

	protected function register_controls(): void {

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
				],
			]
		);

		$this->end_controls_section();

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

		<?php if($settings['design_layout'] == 'style_2') : 
			if(!empty($settings['button_text'])){
				$this->add_link_attributes( 'button_arg', $settings['button_url'] );
				$this->add_render_attribute('button_arg', 'class', 'tp-btn tp-btn-border tp-btn-xl');
			}	
		?>

		<div class="tp-md-btn">
			<a <?php echo $this->get_render_attribute_string( 'button_arg' ); ?>>
				<?php echo mc_kses($settings['button_text']); ?>
				<span class="ml-8">
					<svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M8.71527 1L13 5.28471L8.71527 9.56941" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
						<path d="M1 5.28473H12.88" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</span>
			</a>
		</div>

		<?php else : 
			if(!empty($settings['button_text'])){
				$this->add_link_attributes( 'button_arg', $settings['button_url'] );
				$this->add_render_attribute('button_arg', 'class', 'tp-btn tp-btn-xl');
			}
		?>
		
		<div class="tp-md-btn">
			<a <?php echo $this->get_render_attribute_string( 'button_arg' ); ?>>
				<?php echo mc_kses($settings['button_text']); ?>
			<span class="ml-8">
				<svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M8.71527 1L13 5.28471L8.71527 9.56941" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
					<path d="M1 5.28473H12.88" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
			</span>
			</a>
		</div>

		<?php endif; ?>
            
		<?php
	}
}

$widgets_manager->register( new Mindu_Button() );












	protected function render(): void {

		$settings = $this->get_settings_for_display();

		if ( empty( trim( $settings['button_text'] ) ) ) {
			return;
		}

		// Button class
		$button_class = 'el-tp-btn tp-btn tp-btn-xl';

		if ( ! empty( $settings['button_style'] ) && 'border_button' === $settings['button_style'] ) {
			$button_class .= ' tp-btn-border';
		}

		// Button attributes
		$this->add_link_attributes( 'button', $settings['button_url'] );
		$this->add_render_attribute( 'button', 'class', $button_class );

		// Icon output
		$icon_html = '';

		if ( 'icon' === $settings['icon_style'] && ! empty( $settings['icon']['value'] ) ) {

			ob_start();

			\Elementor\Icons_Manager::render_icon(
				$settings['icon'],
				[ 'aria-hidden' => 'true' ]
			);

			$icon_html = ob_get_clean();

		} elseif ( 'svg' === $settings['icon_style'] && ! empty( $settings['svg'] ) ) {

			$icon_html = mc_kses( $settings['svg'] );
		}
		?>

		<div class="tp-mindu-btn">
			<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>

				<?php if ( 'before' === $settings['button_icon_position'] && ! empty( $icon_html ) ) : ?>
					<span class="tp-btn-icon-before"><?php echo $icon_html; ?></span>
				<?php endif; ?>

				<span class="tp-btn-text"><?php echo esc_html( $settings['button_text'] ); ?></span>

				<?php if ( 'after' === $settings['button_icon_position'] && ! empty( $icon_html ) ) : ?>
					<span class="tp-btn-icon-after"><?php echo $icon_html; ?></span>
				<?php endif; ?>
			</a>
		</div>

		<?php
	}