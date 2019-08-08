<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Yukiascores
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function page_body_classes($classes){
            if(is_active_sidebar('page-1')){
                $classes[] = 'has-page-sidebar';
            } else{
                $classes[] = 'no-page-sidebar';
            }
            return $classes;
        }
add_filter( 'body_class', 'page_body_classes' );
function humescores_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
                $classes[] = 'archive-view';
	}
        
        // Add a class telling us if the sidebar is in use.
        if(is_active_sidebar('sidebar-1')){
            $classes[] = 'has-sidebar';
        } else{
            $classes[] = 'no-sidebar';
        }
        
        
        
        

	return $classes;
}
add_filter( 'body_class', 'humescores_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function humescores_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	}
}
add_action( 'wp_head', 'humescores_pingback_header' );