<?php


add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    $parenthandle = 'orchid-store-style'; // Samma handle från parent theme
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
        array(),  
        $theme->parent()->get('Version')
    );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(),    //köar child theme
        array( $parenthandle ),
        $theme->get('Version') 
    );
}  

// Our custom post type function
function create_posttype() {
 
    register_post_type( 'butiker',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Butiker' ),
                'singular_name' => __( 'Butik' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'butiker'),
            'show_in_rest' => true,
 
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );

/*
* Creating a function to create our CPT
*/
 
function custom_post_type() {
 
    // Set UI labels for Custom Post Type
        $labels = array(
            'name'                => _x( 'Butiker', 'Post Type General Name', 'orchid-store-child' ),
            'singular_name'       => _x( 'Butik', 'Post Type Singular Name', 'orchid-store-child' ),
            'menu_name'           => __( 'Butiker', 'orchid-store-child' ),
            'parent_item_colon'   => __( 'Parent Butik', 'orchid-store-child' ),
            'all_items'           => __( 'All Butiker', 'orchid-store-child' ),
            'view_item'           => __( 'View Butik', 'orchid-store-child' ),
            'add_new_item'        => __( 'Add New Butik', 'orchid-store-child' ),
            'add_new'             => __( 'Add New', 'orchid-store-child' ),
            'edit_item'           => __( 'Edit Butik', 'orchid-store-child' ),
            'update_item'         => __( 'Update Butik', 'orchid-store-child' ),
            'search_items'        => __( 'Search Butik', 'orchid-store-child' ),
            'not_found'           => __( 'Not Found', 'orchid-store-child' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'orchid-store-child' ),
        );
         
    // Set other options for Custom Post Type
         
        $args = array(
            'label'               => __( 'butiker', 'orchid-store-child' ),
            'description'         => __( 'Butik news and reviews', 'orchid-store-child' ),
            'location'         => __( 'Adress', 'orchid-store-child' ),
            'labels'              => $labels,
            
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
            
            'taxonomies'          => array( 'genres' ),
            

            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest' => true,
     
        );
         
        // Registering your Custom Post Type
        register_post_type( 'butiker', $args );
     
    }
     
    /* Hook into the 'init' action so that the function
    * Containing our post type registration is not 
    * unnecessarily executed. 
    */
     
    add_action( 'init', 'custom_post_type', 0 );

    //Lögg till themesupport för att kunna overrida filer
    
    function mytheme_add_woocommerce_support() {
        add_theme_support( 'woocommerce' );
    }
    
    add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

    // Remove action för att ta bort rea ikonen över bilden på single produkt, visas fortfarande i webbbutik

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );




