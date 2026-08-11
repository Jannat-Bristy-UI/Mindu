<?php
/**
 * Common Button Template
 *
 * @var array $settings
 * @var \Elementor\Widget_Base $this
*/

if ( empty( trim( $settings['button_text'] ) ) ) {
    return;
}

// Link attributes
$this->add_link_attributes( 'button_arg', $settings['button_url'] );

// Button class by layout
switch ( $settings['design_layout'] ) {

    case 'style_2':
        // Circle Button
        $button_class = 'tp-btn tp-btn-xl el-tp-btn';
        break;

    case 'style_3':
        // Border Button
        $button_class = 'tp-btn tp-btn-border tp-btn-xl el-tp-btn';
        break;

    case 'style_4':
        // Text Button
        $button_class = 'tp-btn tp-btn-transparent el-tp-btn';
        break;

    case 'style_1':
    default:
        // Square Button
        $button_class = 'tp-btn tp-btn-square el-tp-btn';
        break;
}

$this->add_render_attribute( 'button_arg', 'class', $button_class );
?>

<div class="tp-md-btn">

    <a <?php echo $this->get_render_attribute_string( 'button_arg' ); ?>>

        <?php if ( 'before' === $settings['button_icon_position'] ) : ?>

            <span class="tp-btn-icon-before">

                <?php
                if ( 'icon' === $settings['icon_style'] && ! empty( $settings['icon']['value'] ) ) {

                    \Elementor\Icons_Manager::render_icon(
                        $settings['icon'],
                        [ 'aria-hidden' => 'true' ]
                    );

                } elseif ( 'svg' === $settings['icon_style'] && ! empty( $settings['svg'] ) ) {

                    echo mc_kses( $settings['svg'] );
                }
                ?>

            </span>

        <?php endif; ?>

        <span class="tp-btn-text">

            <?php echo esc_html( $settings['button_text'] ); ?>

        </span>

        <?php if ( 'after' === $settings['button_icon_position'] ) : ?>

            <span class="tp-btn-icon-after">

                <?php
                if ( 'icon' === $settings['icon_style'] && ! empty( $settings['icon']['value'] ) ) {

                    \Elementor\Icons_Manager::render_icon(
                        $settings['icon'],
                        [ 'aria-hidden' => 'true' ]
                    );

                } elseif ( 'svg' === $settings['icon_style'] && ! empty( $settings['svg'] ) ) {

                    echo mc_kses( $settings['svg'] );
                }
                ?>

            </span>

        <?php endif; ?>

    </a>

</div>