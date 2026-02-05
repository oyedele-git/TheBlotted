<?php
/**
 * Template Name: Home Page template
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * 
 * @package theblotted
 * 
 */
if (!defined( 'ABSPATH' )) exit;

get_header();

get_template_part('template-parts/content', 'home');

get_footer();
