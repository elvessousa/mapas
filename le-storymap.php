<?php
/*
Plugin Name: Le Storymap
Plugin URI: http://elvessousa.com.br
Description: Plugin for registering map stories.
Version: 0.1
Author: Elves Sousa
Author Email: elvessousa@icloud.com
License:

Copyright 2014 Elves Sousa (elvessousa@icloud.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

// ----------------------------------------------------
// Constants
// ----------------------------------------------------
define('ESS_STORYMAP_URL', WP_PLUGIN_URL."/".dirname( plugin_basename( __FILE__ ) ) );
define('ESS_STORYMAP_PATH', WP_PLUGIN_DIR."/".dirname( plugin_basename( __FILE__ ) ) );

// ----------------------------------------------------
// Enqueues [frontend]
// ----------------------------------------------------
add_action('init', 'ess_storymap_frontend_enqueues', 5);
function ess_storymap_frontend_enqueues() {
    wp_register_style('ess-storymap', ESS_STORYMAP_URL . '/css/storymap.css', true);
    wp_register_style('ess-storymap-dark', ESS_STORYMAP_URL . '/css/storymap.dark.css', true);
    // wp_register_style('ess-storymap-custom', ESS_STORYMAP_URL . '/inc/storymap-style.php', true);
    wp_register_script('ess-storymap', ESS_STORYMAP_URL . '/js/storymap-min.js', array('jquery'), true);
    wp_register_script('ess-storymap-data', ESS_STORYMAP_URL . '/js/ess-storymap-data.js', array('jquery'), true);
    wp_register_script('ess-storyjs', ESS_STORYMAP_URL . '/js/storyjs-embed.js', array('jquery'), true);
}

// ----------------------------------------------------
// Storymaps: [ess-storymap src="src"]
// ----------------------------------------------------
add_shortcode('ess-storymap', 'ess_storymap');
function ess_storymap($atts, $content = null) {
    extract( shortcode_atts( array(
        'id'         => '',
        'name'       => '',
        'bgcolor'    => '',
        'call'       => false,
        'calltext'   => '',
        'type'       => '',
        'width'      => '',
        'font'       => '',
        'height'     => '600px',
        'lang'       => 'pt',
        'subdomains' => '',
        'theme'      => '',
        'autozoom'   => true,
        'lines'      => true,
        'imagemode'  => true
    ), $atts) );

    // Default values
    if (empty($id))     { $id    = "embed"; }
    if (empty($type))   { $type  = 'osm:standard'; }
    if (empty($width))  { $width = '100%'; } // Default width
    if ($height == '')  { $height = '800'; } // Default height

    // CSS for the map
    wp_enqueue_style('ess-storymap');

    global $maps_query, $post;
    $args = array(
        'post_type'      => 'storymaps',
        'stories'        => $name,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'posts_per_page' => -1
    );
    $maps_query = new WP_Query($args);

    // Armazena o conteudo do slide.
    $slides = array();

    // Slide content
    $prefix_storymaps = '_ess-storymap_';
    while ( $maps_query->have_posts() ) {
        $maps_query->the_post();
        $id    = get_the_ID();
        $slide = ess_get_storymap_fields($id);
        $img   = get_post_meta($id, $prefix_storymaps . 'backimage', true);

        // Include lines
        $line = false;
        if($slide['line'] == 'on') { $line = true; }

        // Slide data
        $content = array(
            'date' => '',
            'text' => array(
                'headline' 	=> get_the_title(),
                'text' 		=> $slide['description'],
            ),
            'media' => array(
                'url' 		=> $slide['media'],
                'credit' 	=> $slide['credit'],
                'caption' 	=> '',
            ),
            'location' => array(
                'line' => $line,
                // 'icon' => 'http://maps.gstatic.com/intl/en_us/mapfiles/ms/micons/blue-pushpin.png',
                'image'=> $slide['image'],
                'lat'  => $slide['address']['latitude'],
                'lon'  => $slide['address']['longitude'],
                'zoom' => $slide['zoom'],
            ),
            'background' => array('url' => $slide['backimage']),
        );

        $slides[] = $content;
    }

    // Add overview type on first slide of the loop
    if (!empty($slides[0]) && is_array($slides[0])) {
        $slides[0]['type'] = 'overview';
    }

    // Story map
    $map = array(
        'storymap' => array(
            'width'          => $width,
            'height'         => $height,
            'map_as_image'   => $imagemode,
            'slides'         => $slides,
            'map_type'       => $type,
            'map_subdomains' => $subdomains,
            'font_css'       => $font,
        ),
    );

    // Timeline data
    $storymap_data = array(
        'width'     => '100%',
        'height'    => $height,
        'bgcolor'   => $bgcolor,
        'call'      => $call,
        'calltext'  => $calltext,
        'mapjson'   => json_encode($map),
        'id'        => $name . '-storymap',
        'lang'      => $lang,
        'line'      => $lang,
        'maptype'   => $type,
        'imagemode' => $imagemode,
        'autozoom'  => $autozoom,
        'font'      => $font,
        'css'       => '',
        'js'        => ''
    );

    // Enqueue the scripts
    if ($theme == 'dark') {
        wp_enqueue_style('ess-storymap-dark');
    } else {
        wp_enqueue_style('ess-storymap');
    }
    wp_enqueue_script('ess-storymap');
    wp_localize_script('ess-storymap-data', 'ess_storymap', $storymap_data);
    wp_enqueue_script('ess-storymap-data');

    // Output
    $output = '<div id="' . $name . '-storymap" style="height: '.$height.';"></div>';
    return $output;
}

// ----------------------------------------------------
// TinyMCE plugins
// ----------------------------------------------------
function ess_storymap_mce_plugins( $plugin_array ) {
    $plugin_array['storymap'] = plugins_url('js/editor/ess-storymap-button.js', __FILE__);
    return $plugin_array;
}
// ----------------------------------------------------
// Toolbar
// ----------------------------------------------------
function ess_storymap_mce_register_buttons($buttons) {

    // Timelines button
    if (get_option('ess-customposts_storymaps_activate')) {
        array_unshift( $buttons, 'storymap');
    }
    return $buttons;
}

function ess_mce() {
    add_filter( 'mce_external_plugins', 'ess_storymap_mce_plugins' );
    add_filter( 'mce_buttons_3', 'ess_storymap_mce_register_buttons' );
}
add_action('admin_init', 'ess_mce');

// ----------------------------------------------------
// Includes
// ----------------------------------------------------
require_once('inc/metaboxes.php');
require_once('storymap-type.php'); ?>
