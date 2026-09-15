<?php
/**
 * TP Image Width — "100% Image Width" switch for the default Elementor Image widget.
 *
 * Injects a responsive SWITCHER right under the native Width slider inside the
 * Image widget's Style > Image section. When it is on, the image is forced to
 * width: 100% for that breakpoint; when it is off nothing is printed at all, so
 * Elementor's own width handling stays untouched. Output is pure CSS through
 * Elementor's selectors API — no frontend assets are needed.
 *
 * Breakpoints follow Elementor's standard responsive cascade: a device with the
 * switch off inherits from the next larger device (same as every native
 * responsive control). Turn it on per device to differ from the desktop value.
 *
 * @package Mindu_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class TP_Image_Width {

	const VERSION = '1.0.0';

	/**
	 * @var TP_Image_Width|null
	 */
	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * All wiring waits for Elementor, so nothing here can fatal when it is
	 * deactivated. Elementor loads before this plugin (alphabetical plugin
	 * order) and fires elementor/loaded during its own file load, so by the
	 * time we run the action is usually already in the past — hence the
	 * did_action() check instead of only listening for the hook.
	 */
	private function __construct() {
		if ( did_action( 'elementor/loaded' ) ) {
			$this->register_hooks();
		} else {
			add_action( 'elementor/loaded', array( $this, 'register_hooks' ) );
		}
	}

	/**
	 * Wire Elementor hooks. Runs only when Elementor is active.
	 */
	public function register_hooks() {
		/*
		 * The Image widget's own style section, while it is still open — that
		 * lets us inject next to the native "Width" control instead of dumping
		 * the switch at the bottom of the panel.
		 */
		add_action( 'elementor/element/image/section_style_image/before_section_end', array( $this, 'register_controls' ), 10, 2 );
	}

	/* -------------------------------------------------------------------------
	 * Controls
	 * ---------------------------------------------------------------------- */

	/**
	 * Add the "100% Image Width" switch to the Image widget.
	 *
	 * @param \Elementor\Controls_Stack $element Element being edited.
	 * @param array                     $args    Section args (unused).
	 */
	public function register_controls( $element, $args = array() ) {
		// Guard against double registration (e.g. another add-on re-running the
		// section) and against the native anchor going missing on some future
		// Elementor version.
		if ( $element->get_controls( 'tp_image_full_width' ) || ! $element->get_controls( 'width' ) ) {
			return;
		}

		/*
		 * Sit right after the native Width slider: better UX, and it also means
		 * our rule is printed after Elementor's, so an explicit 100% wins over a
		 * leftover value in the Width slider on the same breakpoint.
		 */
		$element->start_injection(
			array(
				'at' => 'after',
				'of' => 'width',
			)
		);

		$element->add_responsive_control(
			'tp_image_full_width',
			array(
				'label'                => esc_html__( '100% Image Width', 'mindu-core' ),
				'type'                 => \Elementor\Controls_Manager::SWITCHER,
				'label_on'             => esc_html__( 'On', 'mindu-core' ),
				'label_off'            => esc_html__( 'Off', 'mindu-core' ),
				'return_value'         => 'yes',
				'default'              => '',
				'description'          => esc_html__( 'Stretch the image to the full width of its column. Off keeps Elementor\'s default width.', 'mindu-core' ),
				/*
				 * Off stays an empty value, which Elementor drops before it ever
				 * reaches the stylesheet — so nothing is printed and the default
				 * behaviour (and any custom CSS) is left alone.
				 */
				'selectors_dictionary' => array(
					'yes' => '100%',
				),
				'selectors'            => array(
					'{{WRAPPER}} img' => 'width: {{VALUE}}; max-width: {{VALUE}};',
				),
			)
		);

		$element->end_injection();
	}
}

TP_Image_Width::instance();
