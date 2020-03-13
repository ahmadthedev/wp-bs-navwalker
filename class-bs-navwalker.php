<?php

/**
 * WP Bootstrap NavWalker
 * A custom WordPress NavWalker class to extend the default WordPress functionality using Bootstrap3.
 *
 * @package WP Bootstrap NavWalker
 * @version 1.0.0
 *
 * @extends Walker_Nav_Menu
 */

class WP_BS_NavWalker extends Walker_Nav_Menu
{
    /**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     *
     * @since 3.0.0
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
      $indent = str_repeat( "\t", $depth );
      $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     *
     * @since 3.0.0
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
      $indent = str_repeat("\t", $depth);
      $output .= "$indent</ul>\n";
      $classes = empty( $item->classes ) ? array() : (array) $item->classes;
      if ($depth > 0) {
        $output .= '</li>';
      }
    }

    /**
     * Start the element output.
     *
     * @see Walker::start_el()
     *
     * @since 3.0.0
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
      $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

      $classes = empty( $item->classes ) ? array() : (array) $item->classes;
      $classes[] = 'menu-item-' . $item->ID;

      /**
       * Filter the CSS class(es) applied to a menu item's list item element.
       *
       * @see wp_nav_menu()
       *
       * @since 3.0.0
       * @since 4.1.0 The `$depth` parameter was added.
       */
      $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );

      $class_names .= ' nav-item';

      if (in_array('menu-item-has-children', $classes)) {
        $class_names .= ' dropdown';
      }

      $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

      /**
       * Filter the ID applied to a menu item's list item element.
       *
       * @see wp_nav_menu()
       *
       * @since 3.0.1
       * @since 4.1.0 The `$depth` parameter was added.
       */
      $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
      $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

      if ($depth === 0) {
        $output .= $indent . '<li' . $id . $class_names .'>';
      }

      $atts = array();
      $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
      $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
      $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
      $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

      if ($depth > 0) {
        $manual_class = array_values($classes)[0] .' '. 'dropdown-item';
        $atts ['class']= $manual_class;
      }

      /**
       * Filter the HTML attributes applied to a menu item's anchor element.
       *
       * @see wp_nav_menu()
       *
       * @since 3.6.0
       * @since 4.1.0 The `$depth` parameter was added.
       */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
          if ( ! empty( $value ) ) {
            $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
            $attributes .= ' ' . $attr . '="' . $value . '"';
          }
        }

        $item_output = $args->before;

        // Icon
        $icon = '';
        if ( in_array('menu-item-has-children', $item->classes) && $depth == 0 ) {
          $icon = '<i class="fa fa-angle-down dropdown-toggle" data-toggle="dropdown"></i>';
        } else if ( in_array('menu-item-has-children', $item->classes) && $depth >= 1 ) {
          $icon = '<i class="fa fa-angle-right dropdown-toggle" data-toggle="dropdown"></i>';
        }

        if ($depth > 0) {
          $item_output .= '<li>';
        }
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= $icon . '</a>';
        $item_output .= $args->after;

        /**
         * Filter a menu item's starting output.
         *
         * @see wp_nav_menu()
         *
         * @since 3.0.0
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     *
     * @since 3.0.0
     */
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
      if ($depth === 0) {
        $output .= "</li>\n";
      }
    }
}
