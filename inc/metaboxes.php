<?php

add_filter( 'cmb2_meta_boxes', 'ess_storymap_metaboxes' );
function ess_storymap_metaboxes( $meta_boxes = array() ) {

	$prefix_storymaps = '_ess-storymap_';
	$meta_boxes['storymaps'] = array(
		'id'           => 'storymaps_metabox',
		'title'        => __('Storymap', 'ess-customposts'),
		'object_types' => array( 'storymaps' ),
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true,
		'fields'       => array(
			array(
				'name' => __('Story map', 'ess-customposts').'<i class="icon-location pull-left"></i>',
				'desc' => __('Post a new story map on the site', 'ess-customposts'),
				'id'   => $prefix_storymaps . 'title',
				'type' => 'title',
			),
			array(
				'name' => __('Place', 'ess-customposts'),
				'id'   => $prefix_storymaps . 'address',
				'type' => 'pw_map',
				'sanitization_cb' => 'pw_map_sanitise'
			),
			array(
				'name' => __('Description', 'ess-customposts'),
				'description' => __('Write a short description for this entry', 'ess-customposts'),
				'id'   => $prefix_storymaps . 'description',
				'type' => 'wysiwyg',
				'options' => array(
					'media_buttons' => false,
					'teeny' 		=> true,
					'textarea_rows' => 5,
				),
			),
			array(
				'name' => __('Media', 'ess-customposts'),
				'id'   => $prefix_storymaps . 'media',
				'type' => 'oembed',
			),
			array(
				'name' => __('Media Caption', 'ess-customposts'),
				'id'   => $prefix_storymaps . 'caption',
				'type' => 'text',
			),
			array(
				'name' => __('Media Credit', 'ess-customposts'),
				'id'   => $prefix_storymaps . 'credit',
				'type' => 'text',
			),
			array(
				'name' => __('Background color', 'ess-customposts'),
				'id'   => $prefix_storymaps . 'backcolor',
				'type' => 'colorpicker',
			),
			array(
				'name' => __('Pin image', 'ess-customposts'),
				'id'   => $prefix_storymaps . 'image',
				'type' => 'file',
			),
			array(
				'name' => __('Background image', 'ess-customposts'),
				'id'   => $prefix_storymaps . 'backimage',
				'type' => 'file',
			),
			array(
				'name' => __('Zoom', 'ess-customposts'),
				'id'   => $prefix_storymaps . 'zoom',
				'type' => 'text_small',
				'std'  => 16,
			),
			array(
				'name' => __('Line', 'ess-customposts'),
				'id'   => $prefix_storymaps . 'line',
				'type' => 'checkbox',
				'std'  => 'on',
			),
		),
	);
	// endif;
	return $meta_boxes;
}

// ----------------------------------------------------
// Initialize the metabox class.
// ----------------------------------------------------
require_once('metaboxes/init.php');
require_once('metaboxes/fields/map/cmb-field-map.php');
