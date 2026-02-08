<?php

namespace TheBlottedWP\Core;

use Walker_Nav_Menu;

class FooterMenu_Walker extends Walker_Nav_Menu
{

    public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
        if ( ! $item ) {
            return;
        }

        $classes = array( 'link' );

        if ( $item->current || $item->current_item_ancestor ) {
            $classes[] = 'is-active';
        }

        $class_names = implode( ' ', array_map( '\sanitize_html_class', $classes ) );

        $output .= '<li class="' . \esc_attr( trim( $class_names ) ) . '">';

        $url   = ! empty( $item->url ) ? $item->url : '#';
        $title = '<p>' . \esc_html( $item->title ) . '</p>';

        $attributes  = ' href="' . \esc_url( $url ) . '"';
        $attributes .= ! empty( $item->target ) ? ' target="' . \esc_attr( $item->target ) . '"' : '';
        $attributes .= ! empty( $item->attr_title ) ? ' title="' . \esc_attr( $item->attr_title ) . '"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . \esc_attr( $item->xfn ) . '"' : '';

        $output .= '<a' . $attributes . '>' . $title;
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
