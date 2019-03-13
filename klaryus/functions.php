<?php
    @ini_set( 'upload_max_size' , '64M' );
    @ini_set( 'post_max_size', '64M');
    @ini_set( 'max_execution_time', '300' );

    function to_permalink($str)
    {
        if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
            $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
        $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
        $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\\1', $str);
        $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
        $str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
        $str = strtolower( trim($str, '-') );
        return $str;
    }    

    global $post;

    function remove_menus(){
        global $post;
        remove_menu_page( 'index.php' );                  //Dashboard
        remove_menu_page( 'jetpack' );                    //Jetpack*
        // remove_menu_page( 'edit.php' );                   //Posts
        // remove_menu_page( 'upload.php' );                 //Media
          // remove_menu_page( 'edit.php?post_type=page' );    //Pages
        remove_menu_page( 'edit-comments.php' );          //Comments
        // remove_menu_page( 'themes.php' );                 //Appearance
        // remove_menu_page( 'plugins.php' );                //Plugins
        //   remove_menu_page( 'users.php' );                  //Users
        //   remove_menu_page( 'tools.php' );                  //Tools
        // remove_menu_page( 'options-general.php' );        //Settings
    }
    ////////////////////////////////////////////////////
    function cpt() {
        register_post_type('produtos', array(
            'labels' => array(
                'name' => _x('Produtos', 'post type general name'),
                'singular_name' => _x('Produto', 'post type singular name'),
                'add_new' => _x('Novo', 'Produto'),
                'add_new_item' => __('Novo Produto'),
                'edit_item' => __('Editar Produto'),
                'new_item' => __('Novo Produto'),
                'view_item' => __('Ver Produto'),
                'search_items' => __('Buscar produtos'),
                'not_found' =>  __('Nada encontrado'),
                'not_found_in_trash' => __('Nada encontrado'),
                'parent_item_colon' => ''
            ),
            'exclude_from_search' => true, // the important line here!
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => true,
            'show_in_nav_menus' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_position' => 2,
            'supports' => array('title', 'thumbnail', 'editor')
        ));      
        register_taxonomy( 'produtos_categories', array( 'produtos' ), array(
            'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
            'labels'            => array(
                'name'              => _x( 'Categorias', 'taxonomy general name' ),
                'singular_name'     => _x( 'Produto Categoria', 'taxonomy singular name' ),
                'search_items'      => __( 'Buscar Produto Categorias' ),
                'all_items'         => __( 'Todas as Produto Categorias' ),
                'parent_item'       => __( 'Produto Categoria Pai' ),
                'parent_item_colon' => __( 'Produto Categoria Pai:' ),
                'edit_item'         => __( 'Editar categoria' ),
                'update_item'       => __( 'Atualizar categoria' ),
                'add_new_item'      => __( 'Adicionar nova categoria' ),
                'new_item_name'     => __( 'Novo nome' ),
                'menu_name'         => __( 'Categorias' ),
            ),
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'categories' ),
        ));                                     
    }    
    ////////////////////////////////////////////////////
    function attach_template_to_page( $page_name, $template_file_name ) {

        // Look for the page by the specified title. Set the ID to -1 if it doesn't exist.
        // Otherwise, set it to the page's ID.
        $page = get_page_by_title( $page_name, OBJECT, 'page' );
        $page_id = null == $page ? -1 : $page->ID;

        // Only attach the template if the page exists
        if( -1 != $page_id ) {
            update_post_meta( $page_id, '_wp_page_template', $template_file_name );
        } // end if

        return $page_id;

    } // end attach_template_to_page
    ////////////////////////////////////////////////////
    function query_post_type($query) {
        if(is_category() || is_tag()) {
        $post_type = get_query_var('post_type');
        if($post_type)
        $post_type = $post_type;
        else
        $post_type = array('nav_menu_item','post','articles');
        $query->set('post_type',$post_type);
        return $query;
        }
        }
    ////////////////////////////////////////////////////    
    function customizer( $wp_customize ) {
            $wp_customize->add_panel( 'customization', array(
                'priority'       => 2,
                'title'          => __('Customização')
            ));    
            // Header
            $wp_customize->add_section( 'header' , array(
            'title'       => __( 'Header' ),
            'panel' => 'customization',
            'priority'    => 1
            ));           
            $wp_customize->add_setting( 'logo' );
            $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
            'label'    => __( 'Logo' ),
            'section'  => 'header',
            'settings' => 'logo'
            )));        
            // Social Networks
            $wp_customize->add_section( 'social_networks' , array(
            'title'       => __( 'Social Networks' ),
            'panel' => 'customization',
            'priority'    => 0
            ));    
            $wp_customize->add_setting( 'facebook' );
            $wp_customize->add_control('facebook',  array(
                'label' => 'Facebook',
                'section' => 'social_networks',
                'type' => 'url',
                'settings' => 'facebook'
            ));   
            $wp_customize->add_setting( 'twitter' );
            $wp_customize->add_control('twitter',  array(
                'label' => 'Twitter',
                'section' => 'social_networks',
                'type' => 'url',
                'settings' => 'twitter'
            ));      
            $wp_customize->add_setting( 'instagram' );
            $wp_customize->add_control('instagram',  array(
                'label' => 'Instagram',
                'section' => 'social_networks',
                'type' => 'url',
                'settings' => 'instagram'
            ));  
            $wp_customize->add_setting( 'googleplus' );
            $wp_customize->add_control('googleplus',  array(
                'label' => 'Google Plus',
                'section' => 'social_networks',
                'type' => 'url',
                'settings' => 'googleplus'
            )); 
    }
    ////////////////////////////////////////////////////
    function remove_customizer_settings( $wp_customize ){
        $wp_customize->remove_section('static_front_page');
    }
    ////////////////////////////////////////////////////
    function get_custom_field_data($key, $echo = false) {
    $value = get_post_meta($post->ID, $key, true);
    if($echo == false) {
    return $value;
    } else {
    echo $value;
    }
    }
    ////////////////////////////////////////////////////
    function hide_admin_bar() {
    wp_add_inline_style('admin-bar', '<style> html { margin-top: 0 !important; } </style>');
    return false;
    }
    ////////////////////////////////////////////////////
    function menu() {
        register_nav_menus(
        array(
        // 'default' => __( 'Default' ),
        // 'copyright' => __( 'Copyright' )
        )
        );
        }
    ////////////////////////////////////////////////////
    set_post_thumbnail_size( 600, 600 );
    ////////////////////////////////////////////////////
    function regScripts() {
        wp_deregister_script('jquery');
        wp_enqueue_script('vendors', get_template_directory_uri()."/assets/js/vendors.js",'','', true);
        wp_enqueue_script('commons', get_template_directory_uri()."/assets/js/commons.js",'','', true);
        wp_enqueue_style('style', get_stylesheet_directory_uri().'/style.css', array(), '', 'all');
    }
    ////////////////////////////////////////////////////
    function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
    }
    ////////////////////////////////////////////////////
    function df_terms_clauses($clauses, $taxonomy, $args) {
        if (!empty($args['post_type'])) {
        global $wpdb;
        $post_types = array();
        foreach($args['post_type'] as $cpt) {
        $post_types[] = "'".$cpt."'";
        }
        if(!empty($post_types)) {
        $clauses['fields'] = 'DISTINCT '.str_replace('tt.*', 'tt.term_taxonomy_id, tt.term_id, tt.taxonomy, tt.description, tt.parent', $clauses['fields']).', COUNT(t.term_id) AS count';
        $clauses['join'] .= ' INNER JOIN '.$wpdb->term_relationships.' AS r ON r.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN '.$wpdb->posts.' AS p ON p.ID = r.object_id';
        $clauses['where'] .= ' AND p.post_type IN ('.implode(',', $post_types).')';
        $clauses['orderby'] = 'GROUP BY t.term_id '.$clauses['orderby'];
        }
        }
        return $clauses;
        }
    ////////////////////////////////////////////////////
    function hide_editor() {
        $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
        if( !isset( $post_id ) ) return;
        $template_file = get_post_meta($post_id, '_wp_page_template', true);
        add_post_type_support( 'page', 'excerpt' );
        if($template_file == 'page-templates/home.php'){ 
            remove_post_type_support('page', 'editor');
            remove_post_type_support('page', 'excerpt');
            remove_post_type_support('page', 'thumbnail');
        }
        remove_post_type_support('page', 'editor');
        remove_post_type_support('page', 'author');
        remove_post_type_support('page', 'comments');
        remove_post_type_support('page', 'revisions');
        remove_post_type_support('page', 'custom-fields');    
    }
    ////////////////////////////////////////////////////
    function called( $file_name, $files = array(), $dir = '' ) {

        if( empty( $files ) ) {
            $files = debug_backtrace();
        }

        if( ! $dir ) {
            $dir = get_stylesheet_directory() . '/';
        }

        $dir = str_replace( "/", "\\", $dir );
        $caller_theme_file = array();

        foreach( $files as $file ) {
            if( false !== mb_strpos($file['file'], $dir) ) {
                $caller_theme_file[] = $file['file'];
            }
        }

        if( $file_name ) {
            return in_array( $dir . $file_name, $caller_theme_file );
        }

        return;

    }
    ////////////////////////////////////////////////////
    function sanitize( $input, $setting ) {
        global $wp_customize;
    
        $control = $wp_customize->get_control( $setting->id );
    
        if ( array_key_exists( $input, $control->choices ) ) {
            return $input;
        } else {
            return $setting->default;
        }
    }
    ////////////////////////////////////////////////////
    function pagination(){
        echo '
        <ul class="post-pagination '.(is_single() ? '-single' : '').'">';
            if(is_single()) :
                if(get_previous_post()->ID) :
                    echo '
                    <li class="-actions -prev">
                        <a class="prev" href="'.esc_url( get_permalink( get_previous_post()->ID ) ).'" title="Post Anterior"><i class="fa fa-chevron-left"></i> Post Anterior</a>
                    </li>';
                endif; 
                if(get_next_post()->ID) :
                    echo '
                    <li class="-actions -next">
                        <a class="next" href="'.esc_url( get_permalink( get_next_post()->ID ) ).'" title="Próximo Post">Próximo Post <i class="fa fa-chevron-right"></i></a>
                    </li>';
                endif; 
            else : 
                if(get_previous_posts_link()) :
                    echo '
                    <li class="-actions -prev">
                        <a class="prev" href="'.get_previous_posts_page_link().'" title="Posts Anteriores"><i class="fa fa-chevron-left"></i> Post Anteriores</a>
                    </li>';
                endif; 
                if(get_next_posts_link()) :
                    echo '
                    <li class="-actions -next">
                        <a class="next" href="'.get_next_posts_page_link().'" title="Próximos Posts">Próximos Posts <i class="fa fa-chevron-right"></i></a>
                    </li>';
                endif; 
            endif;
        echo '</ul>';
    }
    ////////////////////////////////////////////////////
    function the_slug_exists($post_name) {
        global $wpdb;
        if($wpdb->get_row("SELECT post_name FROM wp_posts WHERE post_name = '" . $post_name . "'", 'ARRAY_A')) {
            return true;
        } else {
            return false;
        }
    }
    if (isset($_GET['activated']) && is_admin()){
        $home_page_title = 'Home';
        $home_page_content = '';
        $home_page_check = get_page_by_title($home_page_title);
        $home_page = array(
            'post_type' => 'page',
            'post_title' => $home_page_title,
            'post_content' => $home_page_content,
            'post_status' => 'publish',
            'post_author' => 1,
            'ID' => 2,
            'post_slug' => 'home'
        );
        if(!isset($home_page_check->ID) && !the_slug_exists('home')){
            $home_page_id = wp_insert_post($home_page);
        }
    }
    if (isset($_GET['activated']) && is_admin()){
        $front_page = 2; // this is the default page created by WordPress
        update_option( 'page_on_front', $front_page );
        update_option( 'show_on_front', 'page' );
    }
    ////////////////////////////////////////////////////
    // $menuname = 'Menu';
    // $bpmenulocation = 'lblgbpmenu';
    // Does the menu exist already?
    $menu_exists = wp_get_nav_menu_object( $menuname );

    // If it doesn't exist, let's create it.
    if( !$menu_exists){
        $menu_id = wp_create_nav_menu($menuname);

        // Set up default BuddyPress links and add them to the menu.
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Home'),
            'menu-item-classes' => 'home',
            'menu-item-url' => home_url( '/' ), 
            'menu-item-status' => 'publish'));

        // Grab the theme locations and assign our newly-created menu
        if( !has_nav_menu( $bpmenulocation ) ){
            $locations = get_theme_mod('nav_menu_locations');
            $locations[$bpmenulocation] = $menu_id;
            set_theme_mod( 'nav_menu_locations', $locations );
        }
    }
    ////////////////////////////////////////////////////
    if( function_exists('acf_add_options_page') ) {
            acf_add_options_page(array(
                'page_title'    => 'Home',
                'menu_title'    => 'Home',
                'menu_slug'     => '',
                'capability'    => 'edit_posts',
                'parent_slug'   => '',
                'icon_url'      => '', // Add this line and replace the second inverted commas with class of the icon you like
                'position' => -1
            ));
            // acf_add_options_sub_page(array(
            //     'page_title' 	=> 'Home Page Settings',
            //     'menu_title'	=> 'Home',
            //     'capability'	=> 'edit_posts',
            //     'parent_slug'   => 'site'
            // ));
    }
    ////////////////////////////////////////////////////
    function register_required_plugins() {
        $plugins = array(
            array(
                'name' => 'contact-form-7-mailchimp-extension',
                'slug' => 'contact-form-7-mailchimp-extension', 
                        'source' => get_template_directory_uri() . '/plugins/contact-form-7-mailchimp-extension.zip', 
                        'required' => true, 
                        'version' => '', 
                        'force_activation' => true, 
                        'force_deactivation' => false, 
                        'external_url' => '',
                    ),
            array(
                'name' => 'acf-repeater',
                'slug' => 'acf-repeater', 
                        'source' => get_template_directory_uri() . '/plugins/acf-repeater.zip', 
                        'required' => true, 
                        'version' => '', 
                        'force_activation' => true, 
                        'force_deactivation' => false, 
                        'external_url' => '',
                    ),
            array(
                'name' => 'acf-unique-id-field',
                'slug' => 'acf-unique-id-field', 
                        'source' => get_template_directory_uri() . '/plugins/acf-unique-id-field.zip', 
                        'required' => true, 
                        'version' => '', 
                        'force_activation' => true, 
                        'force_deactivation' => false, 
                        'external_url' => '',
                    ),
            array(
                'name' => 'advanced-custom-fields-pro',
                'slug' => 'advanced-custom-fields-pro', 
                        'source' => get_template_directory_uri() . '/plugins/advanced-custom-fields-pro.zip', 
                        'required' => true, 
                        'version' => '', 
                        'force_activation' => true, 
                        'force_deactivation' => false, 
                        'external_url' => '',
                    ),
            array(
                'name' => 'contact-form-7',
                'slug' => 'contact-form-7', 
                        'source' => get_template_directory_uri() . '/plugins/contact-form-7.zip', 
                        'required' => true, 
                        'version' => '', 
                        'force_activation' => true, 
                        'force_deactivation' => false, 
                        'external_url' => '',
                    ),
            array(
                'name' => 'wp-mail-smtp',
                'slug' => 'wp-mail-smtp', 
                        'source' => get_template_directory_uri() . '/plugins/wp-mail-smtp.zip', 
                        'required' => true, 
                        'version' => '', 
                        'force_activation' => true, 
                        'force_deactivation' => false, 
                        'external_url' => '',
                    )
            );
                $config = array(
                    'default_path' => '', // Default absolute path to pre-packaged plugins.
                    'menu' => 'tgmpa-install-plugins', // Menu slug.
                    'has_notices' => true, // Show admin notices or not.
                    'dismissable' => true, // If false, a user cannot dismiss the nag message.
                    'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
                    'is_automatic' => false, // Automatically activate plugins after installation or not.
                    'message' => '', // Message to output right before the plugins table.
                    'strings' => array(
                        'page_title' => __( 'Install Required Plugins', 'tgmpa' ),
                    'menu_title' => __( 'Install Plugins', 'tgmpa' ),
                    'installing' => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
                    'oops' => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
                    'notice_can_install_required' => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
                    'notice_can_install_recommended' => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
                    'notice_cannot_install' => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
                    'notice_can_activate_required' => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
                    'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
                    'notice_cannot_activate' => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
                    'notice_ask_to_update' => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
                    'notice_cannot_update' => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
                    'install_link' => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
                    'activate_link' => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
                    'return' => __( 'Return to Required Plugins Installer', 'tgmpa' ),
                    'plugin_activated' => __( 'Plugin activated successfully.', 'tgmpa' ),
                    'complete' => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
                    'nag_type' => 'updated' // Determines admin notice type – can only be 'updated', 'update-nag' or 'error'.
                    )
            );
            tgmpa( $plugins, $config );
        }
    ////////////////////////////////////////////////////
    function add_anchor( $items, $args )
    {
        $usuario = wp_get_current_user();
        if($args->container_class == 'main-navigation')
        {
            $items .= '
                <li>
                    <button onclick="_mobileNavigation(this)" type="button" class="tcon tcon-menu--xcross tcon-menu--xbutterfly" aria-label="toggle menu">
                        <span class="tcon-menu__lines" aria-hidden="true"></span>
                        <span class="tcon-visuallyhidden">toggle menu</span>
                    </button>
                </li>
            ';
        } 
        return $items;
    }        
    ////////////////////////////////////////////////////
    function mytheme_remove_help_tabs($old_help, $screen_id, $screen){
        $screen->remove_help_tabs();
        return $old_help;
    }
    ////////////////////////////////////////////////////
    if ( ! function_exists( 'the_widgets_init' ) ) {
        function the_widgets_init() {
            if ( ! function_exists( 'register_sidebars' ) )
            return;
            // register_sidebar(
            //     array(
            //         'id'            => 'footer',
            //         'name'          => __( 'Footer' ),
            //         'before_widget' => '<div id="%1$s" class="widget %2$s">',
            //         'after_widget'  => '</div>',
            //         'before_title'  => '<h3 class="widget-title">',
            //         'after_title'   => '&#x2B9E; </h3>',
            //     ));
        } // End the_widgets_init()
    }    
    ////////////////////////////////////////////////////
    if (!is_admin()) {
        function wpb_search_filter($query) {
            if ($query->is_search) {
                $query->set('post_type', 'post');
            }
            return $query;
        }
        add_filter('pre_get_posts','wpb_search_filter');
    }    
    ////////////////////////////////////////////////////
    attach_template_to_page( 'home', 'page-templates/home.php' );
    add_theme_support( 'post-thumbnails' );
    // add_filter( 'contextual_help', 'mytheme_remove_help_tabs', 999, 3 );
    // add_filter('screen_options_show_screen', '__return_false'); 
    add_filter('upload_mimes', 'cc_mime_types');
    // add_filter( 'wpcf7_validate_configuration', '__return_false' );
    add_filter('pre_get_posts', 'query_post_type');
    add_filter( 'show_admin_bar', 'hide_admin_bar' );
    add_filter('terms_clauses', 'df_terms_clauses', 10, 3);
    // add_filter( 'wp_nav_menu_items', 'add_anchor', 10, 2);
    add_action( 'wp_enqueue_scripts', 'regScripts' );
    add_action( 'init', 'menu' );
    //add_action( 'admin_init', 'hide_editor' );
    add_action( 'customize_register', 'remove_customizer_settings', 20 );
    add_action( 'customize_register', 'customizer' );
    add_action( 'admin_menu', 'remove_menus' );
    add_action( 'init', 'the_widgets_init' );
    cpt();
?>