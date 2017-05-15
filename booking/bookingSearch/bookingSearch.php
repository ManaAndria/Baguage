<?php

/*
Plugin Name: Booking-search
Plugin URI: 
Description: Booking-search
Version: 1.0
Author: Netunivers
Author URI: 
License: GPL2
Domain Path: /languages/
*/

include_once plugin_dir_path( __FILE__ ).'/bookingSearch_widget.php';
include_once plugin_dir_path( __FILE__ ).'/bookingSearch_add_script.php';

//shortcode for dynamic sidebar
add_action('init','bookingSearch_shortcodes_sidebar_init');

function bookingSearch_shortcodes_sidebar_init()
{
    add_shortcode('bookingSearch_sidebar', 'bookingSearch_shortcode_sidebar');
}    

function bookingSearch_shortcode_sidebar($atts = [])
{
    $html ='<div>';
    ob_start();
        dynamic_sidebar( 'bookingSearch-widget-area' );
    $html .= ob_get_clean();
    $html .='</div>';
    // $html .='Manoa';

    return $html;
}

/** BOOKING-SEARCH **/

// Adds a widget area.
if (function_exists('register_sidebar')) {
    register_sidebar(array(
    'name' => 'BookingSearch widget area',
    'id' => 'bookingSearch-widget-area',
    'description' => 'booking-search',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widget-title">',
    'after_title' => '</h4>'
    ));
}

// Place the widget area after the header
add_action ('__after_header', 'add_my_widget_area', 10);
function add_my_widget_area() {
  if (function_exists('dynamic_sidebar')) {
    dynamic_sidebar('BookingSearch widget area');
  }
}

/** BOOKING-SEARCH END **/

class BookingSearch
{

	//contructor
    public function __construct()
    {
        //bookingsync
        // ajout option pour stocker le token
        if (!get_option('dsb_access_token')) {
            add_option('dsb_access_token');
        }
        // ajout option pour stocker le token
        if (!get_option('dsb_refresh_token')) {
            add_option('dsb_refresh_token');
        }

        //init widgets
        add_action('widgets_init', function(){register_widget('BookingSearch_Widget');});

        //adding style to head 
        add_action('wp_head',array($this,'add_mine'));

        //adding script in the footer
        add_action('wp_footer','add_script',80);

        //adding meta_box to post
        include_once plugin_dir_path( __FILE__ ).'/bookingSearch_post_meta_box.php';
        new BookingSearch_post_meta_box();

        //create shortcode
        include_once plugin_dir_path( __FILE__ ).'/bookingSearch_shortcode.php';
        new BookingSearch_shortcode();

        //back office content
        include_once plugin_dir_path( __FILE__ ).'/bookingSearch_admin_menu.php';
        new BookingSearch_admin_menu();

        //init translation
        add_action( 'init', array(&$this,'init_plugin_textdomain'), 10 );

        

    }
    
    

    //add my personnal style link
    public function add_mine()
    {
        ?>
            <link charset="UTF-8" href="<?=plugins_url( 'css/style.css', __FILE__ );?>" rel="stylesheet" type="text/css">
            <link charset="UTF-8" href="<?=plugins_url( 'css/bookingSearch.css', __FILE__ );?>" rel="stylesheet" type="text/css">
            <link charset="UTF-8" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/black-tie/theme.css" rel="stylesheet" type="text/css">
        <?php
    }

    /**
     * Set language plugin
     *
     *
     */
    function init_plugin_textdomain() {
        load_plugin_textdomain('Booking-search', false, 'bookingSearch/languages' );
    }
}

new BookingSearch();