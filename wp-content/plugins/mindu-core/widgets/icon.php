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
        return 'eicon-favorite';
    }

    public function get_categories(): array {
        return [ 'mindu-category' ];
    }

    public function get_keywords(): array {
        return [ 'icon', 'svg', 'image', 'link' ];
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
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'icon_style',
            [
                'label'   => esc_html__( 'Icon Style', 'elementor-addon' ),
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
            'icon',
            [
                'label'     => esc_html__( 'Icon', 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-smile',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'icon_style' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'svg',
            [
                'label'     => esc_html__( 'SVG Icon Code', 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::TEXTAREA,
                'condition' => [
                    'icon_style' => 'svg',
                ],
            ]
        );

        $this->add_control(
            'image',
            [
                'label'     => esc_html__( 'Choose Image', 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::MEDIA,
                'default'   => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'icon_style' => 'image',
                ],
            ]
        );

        //=========== Link Control ==========
        $this->add_control(
            'link',
            [
                'label'       => esc_html__( 'Link', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'elementor-addon' ),
                'options'     => [ 'url', 'is_external', 'nofollow' ],
                'default'     => [
                    'url'         => '',
                    'is_external' => false,
                    'nofollow'    => false,
                ],
                'separator'   => 'before',
            ]
        );

        $this->end_controls_section();
        //============ Widget End ==========

    }


    protected function register_style_section(){
        
        $this->icon_style_controls('icon', 'Icon', '.el-icon');
            
    }


    //=========================================================
    // Render
    //=========================================================

    protected function render(): void {

        $settings = $this->get_settings_for_display();

        // Check if link is available
        $has_link = ! empty( $settings['link']['url'] );

        if ( $has_link ) {
            $this->add_link_attributes( 'icon_link', $settings['link'] );
        }

        ?>

        <span class="el-icon">
            <?php if ( $has_link ) : ?>
                <a <?php $this->print_render_attribute_string( 'icon_link' ); ?>>
            <?php endif; ?>

                <?php if ( $settings['icon_style'] === 'icon' ) : ?>

                    <?php
                    \Elementor\Icons_Manager::render_icon(
                        $settings['icon'],
                        [ 'aria-hidden' => 'true' ]
                    );
                    ?>

                <?php elseif ( $settings['icon_style'] === 'image' ) : ?>

                    <img
                        src="<?php echo esc_url( $settings['image']['url'] ); ?>"
                        alt="<?php echo esc_attr( \Elementor\Control_Media::get_image_alt( $settings['image'] ) ); ?>"
                    >

                <?php else : ?>

                    <?php echo mc_kses( $settings['svg'] ?? '' ); ?>

                <?php endif; ?>

            <?php if ( $has_link ) : ?>
                </a>
            <?php endif; ?>
        </span>

        <?php
    }

}

//=========================================================
// Register Widget
//=========================================================

/** @var \Elementor\Widgets_Manager $widgets_manager */
$widgets_manager->register( new Mindu_Icon() );