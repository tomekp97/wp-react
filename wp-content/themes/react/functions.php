<?php
function custom_post_types()
{
    register_post_type('movie',
        array(
            'labels' => array(
                'name'               => 'Movies',
                'singular_name'      => 'Movie',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Movie',
                'edit_item'          => 'Edit Movie',
                'new_item'           => 'New Movie',
                'all_items'          => 'All Movies',
                'view_item'          => 'View Movie',
                'search_items'       => 'Search Movies',
                'not_found'          => 'No Movies Found',
                'not_found_in_trash' => 'No Movies found in Trash',
                'parent_item_colon'  => '',
                'menu_name'          => 'Movies',
            ),
            'menu_icon'          => 'dashicons-location-alt',
            'public'             => true,  
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_rest'       => true,
            'has_archive'        => false,
            'rewrite'            => array(
                'slug'       => 'movie',
                'with_front' => false
            ),
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'page-attributes',
                'revisions'
            ),
            'capability_type' => 'post',
            'hierarchical'    => true,
        )
    );
}
add_action('init', 'custom_post_types');