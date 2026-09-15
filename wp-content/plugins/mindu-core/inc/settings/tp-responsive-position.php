<?php
/**
 * TP Responsive Position — fully responsive Position section for Elementor.
 *
 * Adds a "Pure Position (Responsive)" section to the Advanced tab of every
 * Elementor element (widgets, sections, columns, containers). It mirrors the
 * native Layout > Position controls (_position, _offset_*) but makes the
 * Position SELECT itself responsive per breakpoint. Output is pure CSS via
 * Elementor's selectors API — no frontend assets are needed.
 *
 * @package Mindu_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class TP_Responsive_Position {

	const VERSION = '1.0.0';

	/**
	 * @var TP_Responsive_Position|null
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
	}

	/* -------------------------------------------------------------------------
	 * Controls
	 * ---------------------------------------------------------------------- */

	/**
	 * Register the "Pure Position (Responsive)" section on an element.
	 *
	 * @param \Elementor\Controls_Stack $element Element being edited.
	 */
	public function register_controls( $element ) {
		// Guard against duplicate registration (an element type can pass
		// through more than one anchor hook across Elementor versions).
		if ( $element->get_controls( 'tp_responsive_position' ) ) {
			return;
		}

		$start = is_rtl() ? esc_html__( 'Right', 'mindu-core' ) : esc_html__( 'Left', 'mindu-core' );
		$end   = is_rtl() ? esc_html__( 'Left', 'mindu-core' ) : esc_html__( 'Right', 'mindu-core' );

		$element->start_controls_section(
			'tp_section_responsive_position',
			array(
				'label' => esc_html__( 'Pure Position (Responsive)', 'mindu-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

		// ── Position ─────────────────────────────────────────────────────
		$element->add_responsive_control(
			'tp_responsive_position',
			array(
				'label'     => esc_html__( 'Pure Position', 'mindu-core' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					''         => esc_html__( 'Default', 'mindu-core' ),
					'unset'    => esc_html__( 'Reset', 'mindu-core' ),
					'relative' => esc_html__( 'Relative', 'mindu-core' ),
					'absolute' => esc_html__( 'Absolute', 'mindu-core' ),
					'fixed'    => esc_html__( 'Fixed', 'mindu-core' ),
					'sticky'   => esc_html__( 'Sticky', 'mindu-core' ),
					'static'   => esc_html__( 'Static', 'mindu-core' ),
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}' => 'position: {{VALUE}};',
				),
			)
		);

		// ── Horizontal Orientation ───────────────────────────────────────
		$element->add_responsive_control(
			'tp_offset_orientation_h',
			array(
				'label'       => esc_html__( 'Horizontal Orientation', 'mindu-core' ),
				'type'        => \Elementor\Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => 'start',
				'options'     => array(
					'start' => array(
						'title' => $start,
						'icon'  => 'eicon-h-align-left',
					),
					'end'   => array(
						'title' => $end,
						'icon'  => 'eicon-h-align-right',
					),
				),
				'classes'     => 'elementor-control-start-end',
				'render_type' => 'ui',
				'condition'   => array(
					'tp_responsive_position!' => array( '', 'unset', 'static' ),
				),
			)
		);

		$element->add_responsive_control(
			'tp_offset_x',
			array(
				'label'      => esc_html__( 'Offset', 'mindu-core' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'vh', 'custom' ),
				'range'      => array(
					'px' => array( 'min' => -1000, 'max' => 1000 ),
					'%'  => array( 'min' => -200, 'max' => 200 ),
					'vw' => array( 'min' => -200, 'max' => 200 ),
					'vh' => array( 'min' => -200, 'max' => 200 ),
				),
				'default'    => array( 'size' => 0 ),
				'selectors'  => array(
					'body:not(.rtl) {{WRAPPER}}' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
					'body.rtl {{WRAPPER}}'       => 'right: {{SIZE}}{{UNIT}}; left: unset;',
				),
				'condition'  => array(
					'tp_offset_orientation_h!' => 'end',
					'tp_responsive_position!'  => array( '', 'unset', 'static' ),
				),
			)
		);

		$element->add_responsive_control(
			'tp_offset_x_end',
			array(
				'label'      => esc_html__( 'Offset', 'mindu-core' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'vh', 'custom' ),
				'range'      => array(
					'px' => array( 'min' => -1000, 'max' => 1000 ),
					'%'  => array( 'min' => -200, 'max' => 200 ),
					'vw' => array( 'min' => -200, 'max' => 200 ),
					'vh' => array( 'min' => -200, 'max' => 200 ),
				),
				'default'    => array( 'size' => 0 ),
				'selectors'  => array(
					'body:not(.rtl) {{WRAPPER}}' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
					'body.rtl {{WRAPPER}}'       => 'left: {{SIZE}}{{UNIT}}; right: unset;',
				),
				'condition'  => array(
					'tp_offset_orientation_h' => 'end',
					'tp_responsive_position!' => array( '', 'unset', 'static' ),
				),
			)
		);

		// ── Vertical Orientation ─────────────────────────────────────────
		$element->add_responsive_control(
			'tp_offset_orientation_v',
			array(
				'label'       => esc_html__( 'Vertical Orientation', 'mindu-core' ),
				'type'        => \Elementor\Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => 'start',
				'options'     => array(
					'start' => array(
						'title' => esc_html__( 'Top', 'mindu-core' ),
						'icon'  => 'eicon-v-align-top',
					),
					'end'   => array(
						'title' => esc_html__( 'Bottom', 'mindu-core' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'render_type' => 'ui',
				'condition'   => array(
					'tp_responsive_position!' => array( '', 'unset', 'static' ),
				),
			)
		);

		$element->add_responsive_control(
			'tp_offset_y',
			array(
				'label'      => esc_html__( 'Offset', 'mindu-core' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vh', 'vw', 'custom' ),
				'range'      => array(
					'px' => array( 'min' => -1000, 'max' => 1000 ),
					'%'  => array( 'min' => -200, 'max' => 200 ),
					'vh' => array( 'min' => -200, 'max' => 200 ),
					'vw' => array( 'min' => -200, 'max' => 200 ),
				),
				'default'    => array( 'size' => 0 ),
				'selectors'  => array(
					'{{WRAPPER}}' => 'top: {{SIZE}}{{UNIT}}; bottom: unset;',
				),
				'condition'  => array(
					'tp_offset_orientation_v!' => 'end',
					'tp_responsive_position!'  => array( '', 'unset', 'static' ),
				),
			)
		);

		$element->add_responsive_control(
			'tp_offset_y_end',
			array(
				'label'      => esc_html__( 'Offset', 'mindu-core' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vh', 'vw', 'custom' ),
				'range'      => array(
					'px' => array( 'min' => -1000, 'max' => 1000 ),
					'%'  => array( 'min' => -200, 'max' => 200 ),
					'vh' => array( 'min' => -200, 'max' => 200 ),
					'vw' => array( 'min' => -200, 'max' => 200 ),
				),
				'default'    => array( 'size' => 0 ),
				'selectors'  => array(
					'{{WRAPPER}}' => 'bottom: {{SIZE}}{{UNIT}}; top: unset;',
				),
				'condition'  => array(
					'tp_offset_orientation_v' => 'end',
					'tp_responsive_position!' => array( '', 'unset', 'static' ),
				),
			)
		);

		$element->end_controls_section();
	}
}

TP_Responsive_Position::instance();
