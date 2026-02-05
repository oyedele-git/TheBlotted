<?php

namespace TheBlottedWP\Core;

use Walker_Nav_Menu;

class MainMenu_Walker extends Walker_Nav_Menu
{

    public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
        if ( ! $item ) {
            return;
        }

        $classes = array( 'list' );

        if ( $item->current || $item->current_item_ancestor ) {
            $classes[] = 'is-active';
        }

        $class_names = implode( ' ', array_map( '\sanitize_html_class', $classes ) );

        $output .= '<li class="' . \esc_attr( trim( $class_names ) ) . '">';

        $atts = '';

        $url = ! empty( $item->url ) ? $item->url : '#';
        $atts .= ' href="' . \esc_url( $url ) . '"';

        if ( ! empty( $item->target ) ) {
            $atts .= ' target="' . \esc_attr( $item->target ) . '"';
        }

        if ( ! empty( $item->attr_title ) ) {
            $atts .= ' title="' . \esc_attr( $item->attr_title ) . '"';
        }

        if ( ! empty( $item->xfn ) ) {
            $atts .= ' rel="' . \esc_attr( $item->xfn ) . '"';
        }

        $output .= '<a' . $atts . '>'; 
        $output .= '<p>' . \esc_html( $item->title ) . '</p>';
    }

    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= '</a></li>';
    }



    /**
     * @return self
     */

     public static function get_instance() {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
     }
}
