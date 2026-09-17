<?php
class Mindu_Heading extends \Elementor\Widget_Base {

    use Common_Trait_Style;

    public function get_name(): string {
        return 'mindu-heading';
    }

    public function get_title(): string {
        return esc_html__( 'Theme Heading', 'elementor-addon' );
    }

    public function get_icon(): string {
        return 'eicon-heading';
    }

    public function get_categories(): array {
        return [ 'mindu-category' ];
    }

    public function get_keywords(): array {
        return [ 'heading' ];
    }

    protected function register_controls(): void {
        $this->register_controls_section();
        $this->register_style_section();
    }

    // Content Tab
    protected function register_controls_section(){

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Headding', 'elementor-addon' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

		// Subtitle Icon Type
		$this->add_control(
			'sub_title_icon_type',
			[
				'label'     => esc_html__( 'Subtitle Icon Type', 'elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'default'   => 'icon',
				'options'   => [
					'icon'     => [
						'title' => esc_html__( 'Icon', 'elementor-addon' ),
						'icon'  => 'eicon-star',
					],
					'svg_code' => [
						'title' => esc_html__( 'SVG Code', 'elementor-addon' ),
						'icon'  => 'eicon-code',
					],
				],
				'condition' => [
					'sub_title!' => '',
				],
			]
		);

		// Icon Library
		$this->add_control(
			'sub_title_icon',
			[
				'label'       => esc_html__( 'Icon', 'elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'label_block' => true,
				'condition'   => [
					'sub_title!'          => '',
					'sub_title_icon_type' => 'icon',
				],
			]
		);

		// Raw SVG Code
		$this->add_control(
			'sub_title_svg_code',
			[
				'label'       => esc_html__( 'SVG Code', 'elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Paste your SVG code here', 'elementor-addon' ),
				'condition'   => [
					'sub_title!'          => '',
					'sub_title_icon_type' => 'svg_code',
				],
			]
		);

		$this->add_control(
            'sub_title',
            [
                'label'       => esc_html__( 'Sub Title', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Hello world', 'elementor-addon' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'title',
            [
                'label'   => esc_html__( 'Title', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Hello world', 'elementor-addon' ),
            ]
        );

        $this->add_control(
            'content',
            [
                'label'   => esc_html__( 'Content', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Hero content here',
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label'     => esc_html__( 'Alignment', 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'elementor-addon' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'elementor-addon' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'elementor-addon' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'toggle'    => true,
                'selectors' => [
                    '{{WRAPPER}} .tp-section-title-wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    // Style Tab
    protected function register_style_section(){

        $this->start_controls_section(
            'section_icon_style',
            [
                'label' => esc_html__( 'Icon Style', 'elementor-addon' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Icon Position (Before / After)
        $this->add_control(
            'icon_position',
            [
                'label'   => esc_html__( 'Position', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'before' => [
                        'title' => esc_html__( 'Before Text', 'elementor-addon' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'after'  => [
                        'title' => esc_html__( 'After Text', 'elementor-addon' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'before',
            ]
        );

        // Vertical Alignment
        $this->add_control(
            'icon_align',
            [
                'label'     => esc_html__( 'Vertical Alignment', 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start' => [
                        'title' => esc_html__( 'Top', 'elementor-addon' ),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'center'     => [
                        'title' => esc_html__( 'Middle', 'elementor-addon' ),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'flex-end'   => [
                        'title' => esc_html__( 'Bottom', 'elementor-addon' ),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .el-sub-title' => 'align-items: {{VALUE}} !important;',
                ],
            ]
        );

        // Icon Color
        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__( 'Color', 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-icon i'            => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .el-icon svg path'     => 'fill: {{VALUE}} !important; stroke: {{VALUE}} !important;',
                    '{{WRAPPER}} .el-icon svg circle'   => 'fill: {{VALUE}} !important; stroke: {{VALUE}} !important;',
                    '{{WRAPPER}} .el-icon svg rect'     => 'fill: {{VALUE}} !important; stroke: {{VALUE}} !important;',
                    '{{WRAPPER}} .el-icon svg line'     => 'stroke: {{VALUE}} !important;',
                ],
            ]
        );

        // Icon Size
        $this->add_responsive_control(
            'icon_size',
            [
                'label'      => esc_html__( 'Size', 'elementor-addon' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [
                    'px' => [ 'min' => 6, 'max' => 200 ],
                ],
                'default'    => [ 'unit' => 'px', 'size' => 20 ],
                'selectors'  => [
                    '{{WRAPPER}} .el-icon'     => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .el-icon i'   => 'font-size: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .el-icon svg' => 'width: 100% !important; height: 100% !important;',
                    '{{WRAPPER}} .el-icon img' => 'width: 100% !important; height: 100% !important; object-fit: contain !important;',
                ],
            ]
        );

        // Icon Spacing
        $this->add_responsive_control(
            'icon_spacing',
            [
                'label'      => esc_html__( 'Spacing', 'elementor-addon' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 100 ],
                ],
                'default'    => [ 'unit' => 'px', 'size' => 8 ],
                'selectors'  => [
                    '{{WRAPPER}} .el-sub-title' => 'gap: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->common_trait_style('sub_title', 'Sub-Title', '.el-sub-title-text');
        $this->common_trait_style('title', 'Title', '.el-title');
        $this->common_trait_style('content', 'Content', '.el-content');
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();

        // Icon Render
        $icon_html = '';
        if ( 'icon' === $settings['sub_title_icon_type'] && ! empty( $settings['sub_title_icon']['value'] ) ) {
            ob_start();
            \Elementor\Icons_Manager::render_icon( $settings['sub_title_icon'], [ 'aria-hidden' => 'true' ] );
            $rendered_icon = ob_get_clean();
            $icon_html = '<span class="el-icon" style="display: inline-flex; align-items: center; justify-content: center; line-height: 1;">' . $rendered_icon . '</span>';
        } elseif ( 'svg_code' === $settings['sub_title_icon_type'] && ! empty( $settings['sub_title_svg_code'] ) ) {
            $icon_html = '<span class="el-icon" style="display: inline-flex; align-items: center; justify-content: center; line-height: 1;">' . $settings['sub_title_svg_code'] . '</span>';
        }
        ?>

        <div class="tp-section-title-wrap el-align">

            <!-- Sub-Title -->
            <?php if ( ! empty( $settings['sub_title'] ) ) : ?>
                <span class="tp-section-subtitle mb-10 wow fadeInUp el-sub-title" data-wow-duration=".9s" data-wow-delay=".3s" style="display: inline-flex;">
                    
                    <?php if ( 'before' === $settings['icon_position'] ) echo $icon_html; ?>

                    <span class="el-sub-title-text">
                        <?php echo mc_kses( $settings['sub_title'] ); ?>
                    </span>

                    <?php if ( 'after' === $settings['icon_position'] ) echo $icon_html; ?>

                </span>
            <?php endif; ?>

            <!-- Title -->
            <?php if ( ! empty( $settings['title'] ) ) : ?>
                <h2 class="tp-section-title wow fadeInUp el-title" data-wow-duration=".9s" data-wow-delay=".4s">
                    <?php echo mc_kses( $settings['title'] ); ?>                    
                </h2>
            <?php endif; ?>

            <!-- Content -->
            <?php if ( ! empty( $settings['content'] ) ) : ?>
                <p class="tp-section-dec fw-500 wow fadeInUp el-content" data-wow-duration=".9s" data-wow-delay=".4s">
                    <?php echo mc_kses( $settings['content'] ); ?>                    
                </p>
            <?php endif; ?>
        </div>
        <?php
    }
}

/** @var \Elementor\Widgets_Manager $widgets_manager */
$widgets_manager->register( new Mindu_Heading() );