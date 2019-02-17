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

register_nav_menus(
    array(
        'main_menu' => __( 'Main menu', 'wp-react' )
    )
);

// Endpoint callbacks
function get_main_menu() {
    $dataReturn = array();

    $pagesInMenu = array();
    $navItems = wp_get_nav_menu_items('Main menu');
    
    foreach ($navItems as $item) {
        // return $_SERVER;
        $data = array();
        $pageId = (int)$item->object_id;

        $wpPost = get_post($pageId);

        $regex = '/(\w+[^\.php])/';
        $pageTemplate = get_page_template_slug($pageId);

        preg_match_all($regex, $pageTemplate, $matches);
        $pageTemplate = str_replace('-','_', implode($matches[0]));

        $item->page_template = $pageTemplate;
        $item->is_special_template = false;
        if ($pageId == get_option('page_on_front')) {
            $item->is_special_template = 'front_page';
        }
        if ($pageId == get_option('page_for_posts')) {
            $item->is_special_template = 'post_index';
        }

        /** Set up URL path so that React can easily set <Route>'s and <Link>'s */
        $wpPostPermalink = get_the_permalink($pageId);
        $protocol = $_SERVER['REQUEST_SCHEME'];
        $sitename = $_SERVER['SERVER_NAME'];
        $urlToIgnore = $protocol . "://" . $sitename;
        $regex = '@'.$urlToIgnore.'(.*)@';
        
        preg_match_all($regex, $wpPostPermalink, $matches);

        /** Get page's formatted content */
        // $pageContent = apply_filters('the_content', get_the_content($pageId));
        // $item->page_content = $pageContent;

        $data['id'] = $pageId;
        $data['title'] = $item->title;
        $data['page_content'] = $item->page_content;
        $data['page_template'] = $item->page_template;
        $data['is_special_template'] = $item->is_special_template;
        $data['post_name'] = $wpPost->post_parent;
        $data['post_parent'] = $wpPost->post_parent;
        $data['url_path'] = $matches[1];

        $dataReturn[] = $data;
    }
    
    return $dataReturn;
}

// Endpoints
add_action('rest_api_init', function() {
    register_rest_route('menus', '/main-menu', array(
        'methods' => 'GET',
        'callback' => 'get_main_menu'
    ));
});