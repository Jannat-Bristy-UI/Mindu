<?php

/**
 * @mixin \Elementor\Widget_Base
 */

/* ==========================================================================
    Reusable Vector Content Trait for Elementor
========================================================================== */

trait Vector_Content_Trait {

    /**
     * Vector Controls
     */
    public function vector_controls( $id, $label = 'Vector' ) {

        $this->add_control(
            $id . '_type',
            [
                'label'   => esc_html__( 'Type', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'svg',
                'toggle'  => false,
                'options' => [
                    'svg' => [
                        'title' => esc_html__( 'SVG', 'elementor-addon' ),
                        'icon'  => 'eicon-code',
                    ],
                    'image' => [
                        'title' => esc_html__( 'Image', 'elementor-addon' ),
                        'icon'  => 'eicon-image',
                    ],
                ],
            ]
        );

        $this->add_control(
            $id . '_svg',
            [
                'label'     => esc_html__( 'SVG Code', 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::TEXTAREA,
                'rows'      => 10,
                'condition' => [
                    $id . '_type' => 'svg',
                ],
            ]
        );

        $this->add_control(
            $id . '_image',
            [
                'label'       => esc_html__( 'Image', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::MEDIA,
                'media_types' => [ 'image' ],
                'condition'   => [
                    $id . '_type' => 'image',
                ],
            ]
        );
    }

    /**
     * Render Vector
     *
     * @param array  $settings Widget settings.
     * @param string $id        Control ID.
     * @param string $class     Wrapper class.
     */
    public function render_vector( $settings, $id, $class = 'el-vector' ) {

        if ( empty( $settings[ $id . '_type' ] ) ) {
            return;
        }

        if (
            'image' === $settings[ $id . '_type' ] &&
            empty( $settings[ $id . '_image' ]['url'] )
        ) {
            return;
        }

        if (
            'svg' === $settings[ $id . '_type' ] &&
            empty( $settings[ $id . '_svg' ] )
        ) {
            return;
        }

        ?>
        <span class="<?php echo esc_attr( $class ); ?>">
            <?php if ( 'image' === $settings[ $id . '_type' ] ) : ?>

                <img src="<?php echo esc_url( $settings[ $id . '_image' ]['url'] ); ?>" alt="">

            <?php else : ?>

                <?php
                echo $settings[ $id . '_svg' ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                ?>

            <?php endif; ?>
        </span>
        <?php
    }

}