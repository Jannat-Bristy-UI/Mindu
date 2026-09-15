<?php
/**
 * TP Animation — custom Elementor entrance animation system.
 *
 * Adds a "Pure Animation" section to the Advanced tab of every Elementor
 * element (widgets, sections, columns, containers) and applies the chosen
 * animation to the element's own wrapper via Elementor's render-attribute
 * API. The frontend animation itself is pure CSS + a small vanilla-JS
 * IntersectionObserver driver — no third-party animation libraries.
 *
 * @package Mindu_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class TP_Animation {

	const VERSION = '1.0.0';

	/**
	 * @var TP_Animation|null
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
	 * Animation registry: internal value => Elementor UI label.
	 * The value doubles as the CSS class applied to the wrapper.
	 */
	public static function animations() {
		return array(
			'tp-fade'       => esc_html__( 'Fade', 'mindu-core' ),
			'tp-fade-up'    => esc_html__( 'Fade Up', 'mindu-core' ),
			'tp-fade-down'  => esc_html__( 'Fade Down', 'mindu-core' ),
			'tp-fade-left'  => esc_html__( 'Fade Left', 'mindu-core' ),
			'tp-fade-right' => esc_html__( 'Fade Right', 'mindu-core' ),
			'tp-zoom-in'    => esc_html__( 'Zoom In', 'mindu-core' ),
			'tp-zoom-out'   => esc_html__( 'Zoom Out', 'mindu-core' ),
			'tp-slide-up'   => esc_html__( 'Slide Up', 'mindu-core' ),
			'tp-slide-left' => esc_html__( 'Slide Left', 'mindu-core' ),
			'tp-slide-right' => esc_html__( 'Slide Right', 'mindu-core' ),
			'tp-blur'       => esc_html__( 'Blur', 'mindu-core' ),
			'tp-reveal-up'  => esc_html__( 'Reveal Up', 'mindu-core' ),
		);
	}

	/**
	 * Duration choices — CSS time values, used verbatim in data attributes
	 * and CSS custom properties.
	 */
	public static function duration_options() {
		$values = array( '.3s', '.4s', '.5s', '.6s', '.7s', '.8s', '.9s', '1s', '1.2s', '1.5s', '2s' );
		return array_combine( $values, $values );
	}

	/**
	 * Delay choices — CSS time values, used verbatim. '0s' is the explicit
	 * "no delay" choice; the control itself defaults to '.3s'.
	 */
	public static function delay_options() {
		$values  = array( '.1s', '.2s', '.3s', '.4s', '.5s', '.6s', '.7s', '.8s', '.9s', '1s', '1.5s', '2s' );
		$options = array( '0s' => esc_html__( 'None (0s)', 'mindu-core' ) );
		foreach ( $values as $value ) {
			$options[ $value ] = $value;
		}
		return $options;
	}

	/**
	 * Normalize a stored delay/duration setting to a CSS time value.
	 *
	 * Accepts the current select values ('.8s') as-is and converts legacy
	 * millisecond numbers saved by the previous NUMBER controls (800 → '.8s').
	 * Returns '' when the value is unusable.
	 *
	 * @param mixed $value Raw setting value.
	 * @return string CSS time value or ''.
	 */
	private static function to_css_time( $value ) {
		if ( '' === $value || null === $value ) {
			return '';
		}

		$value = trim( (string) $value );

		// Current format: .8s / 1s / 1.5s etc.
		if ( preg_match( '/^(\d+)?(\.\d+)?s$/', $value ) && 's' !== $value ) {
			return $value;
		}

		// Legacy format: plain milliseconds from the old NUMBER controls.
		if ( is_numeric( $value ) ) {
			$seconds = min( 5000, max( 0, (float) $value ) ) / 1000;
			$out     = rtrim( rtrim( number_format( $seconds, 3, '.', '' ), '0' ), '.' );
			if ( '' === $out || '0' === $out ) {
				return '0s';
			}
			// 0.8 → .8s to match the select values.
			return preg_replace( '/^0\./', '.', $out ) . 's';
		}

		return '';
	}

	/**
	 * Animations whose movement is controlled by the Distance control.
	 */
	public static function directional_animations() {
		return array(
			'tp-fade-up',
			'tp-fade-down',
			'tp-fade-left',
			'tp-fade-right',
			'tp-slide-up',
			'tp-slide-left',
			'tp-slide-right',
			'tp-reveal-up',
		);
	}

	/**
	 * Wire Elementor + asset hooks. Runs only when Elementor is active.
	 */
	public function register_hooks() {
		/*
		 * One stable per-element-type anchor each. The section lands in the
		 * Advanced tab because it declares TAB_ADVANCED — the hook point only
		 * decides when during the element's control registration we run.
		 * "common" covers every widget; "common-optimized" is its counterpart
		 * when Elementor's Optimized Markup experiment is on (never fires
		 * otherwise, which is harmless).
		 */
		$anchors = array(
			'common/_section_style',
			'common-optimized/_section_style',
			'section/section_advanced',
			'column/section_advanced',
			'container/section_layout',
		);

		foreach ( $anchors as $anchor ) {
			add_action( 'elementor/element/' . $anchor . '/after_section_end', array( $this, 'register_controls' ) );
		}

		add_action( 'elementor/frontend/before_render', array( $this, 'apply_render_attributes' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	/* -------------------------------------------------------------------------
	 * Controls
	 * ---------------------------------------------------------------------- */

	/**
	 * Register the "Pure Animation" section on an element.
	 *
	 * @param \Elementor\Controls_Stack $element Element being edited.
	 */
	public function register_controls( $element ) {
		// Guard against duplicate registration (an element type can pass
		// through more than one anchor hook across Elementor versions).
		if ( $element->get_controls( 'tp_animation' ) ) {
			return;
		}

		$element->start_controls_section(
			'tp_animation_section',
			array(
				'label' => esc_html__( 'Pure Animation', 'mindu-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

		$element->add_control(
			'tp_animation',
			array(
				'label'              => esc_html__( 'Animation', 'mindu-core' ),
				'type'               => \Elementor\Controls_Manager::SELECT,
				'default'            => '',
				'options'            => array( '' => esc_html__( 'None', 'mindu-core' ) ) + self::animations(),
				'frontend_available' => true,
			)
		);

		$element->add_control(
			'tp_animation_delay',
			array(
				'label'       => esc_html__( 'Delay', 'mindu-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => '.3s',
				'options'     => self::delay_options(),
				'description' => esc_html__( 'Wait this long after the element enters the viewport.', 'mindu-core' ),
				'condition'   => array( 'tp_animation!' => '' ),
			)
		);

		$element->add_control(
			'tp_animation_duration',
			array(
				'label'     => esc_html__( 'Duration', 'mindu-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array( '' => esc_html__( 'Default (.8s)', 'mindu-core' ) ) + self::duration_options(),
				'condition' => array( 'tp_animation!' => '' ),
			)
		);

		$element->add_control(
			'tp_animation_distance',
			array(
				'label'       => esc_html__( 'Distance (px)', 'mindu-core' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'default'     => '',
				'placeholder' => '20',
				'min'         => 0,
				'max'         => 200,
				'step'        => 1,
				'description' => esc_html__( 'How far the element travels. Defaults: 20px (fade/reveal), 30px (slide).', 'mindu-core' ),
				'condition'   => array( 'tp_animation' => self::directional_animations() ),
			)
		);

		$element->add_control(
			'tp_animation_mobile',
			array(
				'label'        => esc_html__( 'Mobile Animation', 'mindu-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'mindu-core' ),
				'label_off'    => esc_html__( 'Off', 'mindu-core' ),
				'default'      => '',
				'return_value' => 'yes',
				'description'  => esc_html__( 'Off by default: on mobile this element appears instantly, without animation. Switch on to animate it on mobile too.', 'mindu-core' ),
				'condition'    => array( 'tp_animation!' => '' ),
			)
		);

		$element->end_controls_section();
	}

	/* -------------------------------------------------------------------------
	 * Frontend render
	 * ---------------------------------------------------------------------- */

	/**
	 * Add the animation class + data attributes to the element's own wrapper
	 * (the .elementor-element div) via Elementor's render-attribute API.
	 *
	 * @param \Elementor\Element_Base $element Element about to render.
	 */
	public function apply_render_attributes( $element ) {
		$animation = $element->get_settings_for_display( 'tp_animation' );

		// Animation = None → element renders completely untouched.
		if ( empty( $animation ) || ! array_key_exists( $animation, self::animations() ) ) {
			return;
		}

		$classes = array( 'tp-animation', sanitize_html_class( $animation ) );

		// Mobile Animation disabled → CSS shows the element normally below
		// the mobile breakpoint (see tp-animation.css).
		if ( 'yes' !== $element->get_settings_for_display( 'tp_animation_mobile' ) ) {
			$classes[] = 'tp-anim-mobile-off';
		}

		$attributes = array(
			'class'             => $classes,
			'data-tp-animation' => $animation,
		);

		$delay = self::to_css_time( $element->get_settings_for_display( 'tp_animation_delay' ) );
		if ( '' !== $delay ) {
			$attributes['data-tp-delay'] = $delay;
		}

		$duration = self::to_css_time( $element->get_settings_for_display( 'tp_animation_duration' ) );
		if ( '' !== $duration ) {
			$attributes['data-tp-duration'] = $duration;
		}

		$distance = $element->get_settings_for_display( 'tp_animation_distance' );
		if ( '' !== $distance && null !== $distance && in_array( $animation, self::directional_animations(), true ) ) {
			$attributes['data-tp-distance'] = (string) min( 200, max( 0, absint( $distance ) ) );
		}

		$element->add_render_attribute( '_wrapper', $attributes );
	}

	/* -------------------------------------------------------------------------
	 * Assets
	 * ---------------------------------------------------------------------- */

	/**
	 * Enqueue the animation CSS/JS on the Elementor-powered frontend.
	 *
	 * The script loads in the <head> on purpose: it synchronously flags
	 * <html> with .tp-anim-ready before the body renders, so the CSS hidden
	 * states only ever apply when the JS driver is actually running. With JS
	 * disabled (or IntersectionObserver missing) nothing is hidden, and
	 * loading before render means no flash of visible-then-hidden content.
	 */
	public function enqueue_assets() {
		$base_url  = plugin_dir_url( dirname( __DIR__, 2 ) . '/mindu-core.php' ) . 'assets/';
		$base_path = dirname( __DIR__, 2 ) . '/assets/';

		wp_enqueue_style(
			'tp-animation',
			$base_url . 'css/tp-animation.css',
			array(),
			file_exists( $base_path . 'css/tp-animation.css' ) ? filemtime( $base_path . 'css/tp-animation.css' ) : self::VERSION
		);

		wp_enqueue_script(
			'tp-animation',
			$base_url . 'js/tp-animation.js',
			array(),
			file_exists( $base_path . 'js/tp-animation.js' ) ? filemtime( $base_path . 'js/tp-animation.js' ) : self::VERSION,
			false // head, see docblock.
		);
	}
}

TP_Animation::instance();
