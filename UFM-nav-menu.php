<?php
/*
Plugin Name: UFM Nav Menu
Description: This plugin builds a Bootstrap nav from the page structure within WP. 
It is included in all templates be default now, but also exists as this standalone plugin
Version: 1.0.0
Author: John Thompson
Author URI: http://www.ufmedia.net
*/

function main_nav_init() {
$currentID = get_the_ID();

$args = array(

			'post_type' => 'page',
			'numberposts' => 100,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'post_parent' => 0,
			'meta_query' => array(
				array(
					'key' => 'hide_from_nav',
					'value' => '"1"',
					'compare' => 'NOT LIKE'
					
				) 
			)
			
			);
	
	
$pages = get_posts($args);
$navHTML .= '<ul class="nav">';
foreach ($pages as $page) {

$args = array(

			'post_type' => 'page',
			'numberposts' => 100,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'post_parent' => $page->ID,
			'meta_query' => array(
				array(
					'key' => 'hide_from_nav',
					'value' => '1',
					'compare' => '!='
					
				) 
			)
			);

$children = get_posts($args);

if( count( $children ) != 0 ) { 
    
	$navHTML .= '<li class="dropdown"><a href="#" data-toggle="dropdown">' . get_the_title($page->ID) . '<span class="drop-caret"></span></a>';
	$navHTML .= '<ul class="dropdown-menu">';
	foreach ($children as $child) {
		
	$navHTML .= '<li';
	if ($child->ID == $currentID) {
		$navHTML .= ' class="active"';
	}
	$navHTML .= '><a href="' . get_permalink($child->ID) . '"><span>' . get_the_title($child->ID) . '</span></a></li>';
		
	}
	$navHTML .= '</ul></li>';
 
} else {

	
	
	$navHTML .= '<li';
	if ($page->ID == $currentID) {
		$navHTML .= ' class="active"';
	}
	$navHTML .= '><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';

	}
}

$navHTML .= '</ul>';

return $navHTML;	

}

function footer_nav_init() {
$currentID = get_the_ID();

$args = array(

			'post_type' => 'page',
			'numberposts' => 100,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'post_parent' => 0,
			'meta_query' => array(
				array(
					'key' => 'hide_from_nav',
					'value' => '"1"',
					'compare' => 'NOT LIKE'
					
				) 
			)
			
			);
	
$pages = get_posts($args);
$navHTML .= '<ul>';
foreach ($pages as $page) {

	$navHTML .= '<li';
	if ($page->ID == $currentID) {
		$navHTML .= ' class="active"';
	}
	$navHTML .= '><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';

	} 


$navHTML .= '</ul>';

return $navHTML;	

}