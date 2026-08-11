<?php

/**
* Sanitize SVG markup for front-end display.
*
* @param  string $svg SVG markup to sanitize.
* @return string 	  Sanitized markup.
*/
function mc_kses( $tag = '' ) {
	$allowed_html = [
         'a' => [
            'class'    => [],
            'href'    => [],
            'title'    => [],
            'target'    => [],
            'rel'    => [],
         ],

         'b' => [],

         'blockquote'  =>  [
            'cite' => [],
         ],

         'cite'                      => [
            'title' => [],
         ],

         'code'                      => [],

         'del'                    => [
            'datetime'   => [],
            'title'      => [],
        ],

         'div'                    => [
            'class'   => [],
            'title'   => [],
            'style'   => [],
         ],
         'dl'                     => [],
         'dt'                     => [],
         'em'                     => [],
         'h1'                     => [],
         'h2'                     => [],
         'h3'                     => [],
         'h4'                     => [],
         'h5'                     => [],
         'h6'                     => [],
         'i'                         => [
            'class' => [],
         ],

         'img'                    => [
            'alt'  => [],
            'class'   => [],
            'height' => [],
            'src'  => [],
            'width'   => [],
         ],
         
         'li'                     => array(
            'class' => array(),
         ),
         'ol'                     => array(
            'class' => array(),
         ),
         'p'                         => array(
            'class' => array(),
         ),
         'q'                         => array(
            'cite'    => array(),
            'title'   => array(),
         ),
         'span'                      => array(
            'class'   => array(),
            'title'   => array(),
            'style'   => array(),
         ),
         'iframe'                 => array(
            'width'         => array(),
            'height'     => array(),
            'scrolling'     => array(),
            'frameborder'   => array(),
            'allow'         => array(),
            'src'        => array(),
         ),
         'strike'                 => array(),
         'br'                     => array(),
         'strong'                 => array(),

         // SVG support
         'svg' => [
            'class'         => [],
            'xmlns'         => [],
            'width'         => [],
            'height'        => [],
            'viewbox'       => [],
            'viewBox'       => [],
            'fill'          => [],
            'stroke'        => [],
            'stroke-width'  => [],
            'aria-hidden'   => [],
            'role'          => [],
         ],

         'g' => [
            'fill'            => [],
            'stroke'          => [],
            'stroke-width'    => [],
            'fill-rule'       => [],
            'clip-rule'       => [],
            'stroke-linecap'  => [],
            'stroke-linejoin' => [],
         ],

         'path' => [
            'd'               => [],
            'fill'            => [],
            'stroke'          => [],
            'stroke-width'    => [],
            'stroke-linecap'  => [],
            'stroke-linejoin' => [],
            'fill-rule'       => [],
            'clip-rule'       => [],
         ],

         'circle' => [
            'cx'     => [],
            'cy'     => [],
            'r'      => [],
            'fill'   => [],
            'stroke' => [],
         ],

         'rect' => [
            'x'      => [],
            'y'      => [],
            'width'  => [],
            'height' => [],
            'rx'     => [],
            'ry'     => [],
            'fill'   => [],
            'stroke' => [],
         ],

         'line' => [
            'x1'     => [],
            'y1'     => [],
            'x2'     => [],
            'y2'     => [],
            'stroke' => [],
         ],

         'polyline' => [
            'points' => [],
            'fill'   => [],
            'stroke' => [],
         ],

         'polygon' => [
            'points' => [],
            'fill'   => [],
            'stroke' => [],
         ],
	];

	return wp_kses( $tag, $allowed_html );
}
