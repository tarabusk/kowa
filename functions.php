<?php
/*
 * Barcelona. Child Theme Function File
 * You can modify any function here. Simply copy any function from parent and paste here. It will override the parent's version.
 */

add_action( 'after_setup_theme', 'barcelona_child_theme_scripts', 99 );

function barcelona_child_theme_scripts() {

	add_action( 'wp_enqueue_scripts', 'barcelona_enqueue_scripts_child', 99 );

}
 
/*
 * Enqueue Child Scripts & Styles
 */
function barcelona_enqueue_scripts_child() {

        // css
    
	if ( ! is_admin() ) {

            wp_register_style( 'barcelona-main-child', trailingslashit( get_stylesheet_directory_uri() ).'style.css', array('bootstrap', 'barcelona-font', 'vs-preloader', 'owl-carousel', 'owl-theme', 'jquery-boxer', 'barcelona-stylesheet'), BARCELONA_THEME_VERSION, 'all' );
            wp_enqueue_style( 'barcelona-main-child' );
            
            wp_register_style( 'media-responsive', trailingslashit( get_stylesheet_directory_uri() ).'assets/css/media-responsive.css', array('barcelona-main-child'), BARCELONA_THEME_VERSION, 'all' );
            wp_enqueue_style( 'media-responsive' );

	}
        
        // javascript
        
        wp_enqueue_script( 'kowala-main', get_stylesheet_directory_uri() . '/assets/js/kowala-main.js', array('barcelona-main'), '1', true );
        
        if( is_page_template( 'page-home.php' ) ) {
            wp_enqueue_script( 'kowala-home', get_stylesheet_directory_uri() . '/assets/js/kowala-home.js', array('barcelona-main'), '1', true );
        }
        //if( 'pays' == get_post_type() ) {}

        
}

/*function kowala_theme_support() {
    
    remove_image_size('barcelona-sm'); 
    add_image_size( 'barcelona-sm', 768, 506, true );
    
}*/
add_action( 'after_setup_theme', 'barcelona_enqueue_scripts_child' );

add_action('template_redirect', 'paysAjaxPostsInit');

function paysAjaxPostsInit(){
    global $wp_query;
    // What page are we on? And what is the pages limit?
    wp_enqueue_script( 'kowala-pays', get_stylesheet_directory_uri() . '/assets/js/kowala-pays.js', array('barcelona-main'), '1', true );
    
    
    $max = $wp_query->max_num_pages;
    $paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;

    wp_localize_script(
            'kowala-pays',
            'pbd_alp',
            array(
                    'startPage' => $paged,
                    'maxPages' => $max,
                    'nextLink' => next_posts($max, false)
            )
    );
    
    

}
  

    


/*
 * Register new GET variables
 */

function add_query_vars_filter( $vars ){
  $vars[] = "filtre";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );


/**
 * Custom post types
 */


add_action( 'init', 'create_post_types' );

function create_post_types() {

	$labels = array(
		'name' => __( 'Pays' ),
		'singular_name' => __( 'Pays' ),
		'add_new' => __( 'Add New' ),
		'add_new_item' => __( 'Add New Pays' ),
		'edit' => __( 'Edit' ),
		'edit_item' => __( 'Edit Pays' ),
		'new_item' => __( 'New Pays' ),
		'view' => __( 'View Pays' ),
		'view_item' => __( 'View Pays' ),
		'search_items' => __( 'Search Pays' ),
		'not_found' => __( 'No Pays found' ),
		'not_found_in_trash' => __( 'No Pays found in Trash' ),
		'parent' => __( 'Parent Pays' ),
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'thumbnail'),
                'rewrite' => array('slug' => 'destination')
	);

	register_post_type( 'pays' , $args );


}



/**
 * Metabox
 *
 */



/**
 * Adds a meta box to the post editing screen
 */
function metabox_custom_meta() {
    add_meta_box( 'pays_meta', __( 'Détail pays', 'metabox-textdomain' ), 'pays_meta_callback', 'pays' );
   
}
add_action( 'add_meta_boxes', 'metabox_custom_meta' );

/**
 * Outputs the content of the meta box
 */
function pays_meta_callback( $post ) {
    	wp_nonce_field( basename( __FILE__ ), 'pays_nonce' );
	$pays_stored_meta = get_post_meta( $post->ID );
	?>

        
	<p>
		<label for="pays-titre-alt" class="metabox-row-title"><?php _e( 'Titre alternatif', 'metabox-textdomain' )?></label>
		<input type="text" name="pays-titre-alt" id="pays-titre-alt" value="<?php if ( isset ( $pays_stored_meta['pays-titre-alt'] ) ) echo $pays_stored_meta['pays-titre-alt'][0]; ?>" />
	</p>
        
	<p>
		<label for="pays-tag-slug" class="metabox-row-title"><?php _e( 'Tag Slug', 'metabox-textdomain' )?></label>
		<input type="text" name="pays-tag-slug" id="pays-tag-slug" value="<?php if ( isset ( $pays_stored_meta['pays-tag-slug'] ) ) echo $pays_stored_meta['pays-tag-slug'][0]; ?>" />
	</p>
        
	<p>
		<label for="pays-texte-bouton" class="metabox-row-title"><?php _e( 'Texte Bouton', 'metabox-textdomain' )?></label>
		<input type="text" name="pays-texte-bouton" id="pays-texte-bouton" value="<?php if ( isset ( $pays_stored_meta['pays-texte-bouton'] ) ) echo $pays_stored_meta['pays-texte-bouton'][0]; ?>" />
	</p>
        
	<p>
		<label for="pays-lien-bouton" class="metabox-row-title"><?php _e( 'Lien Bouton', 'metabox-textdomain' )?></label>
		<input type="text" name="pays-lien-bouton" id="pays-lien-bouton" value="<?php if ( isset ( $pays_stored_meta['pays-lien-bouton'] ) ) echo $pays_stored_meta['pays-lien-bouton'][0]; ?>" />
	</p>
        
        
        

	<?php
}



/**
 * Saves the custom meta input
 */

function metabox_meta_save( $post_id ) {

	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
        
        global $typenow;
	if( $typenow == 'pays' ) {
            $is_valid_nonce = ( isset( $_POST[ 'pays_nonce' ] ) && wp_verify_nonce( $_POST[ 'pays_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
        }
        
	

	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}

        if( $typenow == 'pays' ) {
            
            // Checks for input and sanitizes/saves if needed
            if( isset( $_POST[ 'pays-titre-alt' ] ) ) {
                    update_post_meta( $post_id, 'pays-titre-alt', sanitize_text_field( $_POST[ 'pays-titre-alt' ] ) );
            }
            if( isset( $_POST[ 'pays-tag-slug' ] ) ) {
                    update_post_meta( $post_id, 'pays-tag-slug', sanitize_text_field( $_POST[ 'pays-tag-slug' ] ) );
            }
            if( isset( $_POST[ 'pays-texte-bouton' ] ) ) {
                    update_post_meta( $post_id, 'pays-texte-bouton', sanitize_text_field( $_POST[ 'pays-texte-bouton' ] ) );
            }
            if( isset( $_POST[ 'pays-lien-bouton' ] ) ) {
                    update_post_meta( $post_id, 'pays-lien-bouton', sanitize_text_field( $_POST[ 'pays-lien-bouton' ] ) );
            }
            
        }
        

}
add_action( 'save_post', 'metabox_meta_save' );


/**
 * Adds the meta box stylesheet when appropriate
 */
function metabox_admin_styles(){
    global $typenow;
    if( $typenow == 'pays' ) {
        //wp_enqueue_style( 'metabox_meta_box_styles', get_bloginfo(  'template_url') . '/inc/metabox/metabox-style.css' );
    }
}
add_action( 'admin_print_styles', 'metabox_admin_styles' );

/**
 * Loads the image management javascript
 */
/*
function metabox_image_enqueue() {
	global $typenow;
	if( $typenow == 'pays' OR $typenow == 'post' ) {
		wp_enqueue_media();

		// Registers and enqueues the required javascript.
		wp_register_script( 'meta-box-image', get_bloginfo(  'template_url') . '/inc/metabox/metabox-image.js', array( 'jquery' ) );
		wp_localize_script( 'meta-box-image', 'meta_image',
			array(
				'title' => __( 'Choose or Upload an image file', 'metabox-textdomain' ),
				'button' => __( 'Use this file', 'metabox-textdomain' ),
			)
		);
		wp_enqueue_script( 'meta-box-image' );
	}
}
add_action( 'admin_enqueue_scripts', 'metabox_image_enqueue' );
*/



/*
 * Shortcodes
 */

function agg_message_function($atts, $content = null) {
    $atts = shortcode_atts(array(
        'image' => 'idee',
        'link' => '',
        'title' => '',
        'text' => 'Message...',
        'new_window' => 'false'
    ), $atts);
    
    $imageUrl = get_stylesheet_directory_uri().'/img/'.'msg-icon-idee.png';
    if($atts['image'] == 'megaphone'){ $imageUrl = get_stylesheet_directory_uri().'/img/'.'msg-icon-megaphone.png'; }
    elseif($atts['image'] == 'croix'){ $imageUrl = get_stylesheet_directory_uri().'/img/'.'msg-icon-croix.png'; }
    elseif($atts['image'] == 'forum'){ $imageUrl = get_stylesheet_directory_uri().'/img/'.'msg-icon-forum.png'; }
  
    $ancre = "";
    if($atts['image'] == 'forum') { $ancre = 'id="comments"'; }
    
    $return_string = '<div '.$ancre.' class="messageShortcode clearfix style-'.$atts['image'].'">';
    
    $target="";
    if($atts['new_window'] == 'true'){ $target = 'target="_blank"'; }
    
    if(!empty($atts['link'])){
        $return_string .= '<a href="'.$atts['link'].'" '. $target .'>';
    }
    $return_string .= '<img src="'.$imageUrl.'" alt="" />';
    $return_string .= '<h6 class="msgTitle">'.$atts['title'].'</h6>';
    $return_string .= '<p class="msgContent">'.$atts['text'].'</p>';
    if(!empty($atts['link'])){ $return_string .= '</a>'; }
    $return_string .= '</div>';
    return $return_string;
}

function agg_message_forum_function($atts, $content = null) {
    $atts = shortcode_atts(array(
        'icon' => 'comments',
        'link' => get_page_link(12857),
        'title' => '',
        'text' => 'Message...'
    ), $atts);
    
    
    $return_string = '<div class="messageForumShortcode clearfix">';
    
    $return_string .= '<a href="'.$atts['link'].'">';
    
    $return_string .= '<i class="fa fa-'.$atts['icon'].'"></i> ';
    $return_string .= '<h6 class="msgTitle">'.$atts['title'].'</h6>';
    $return_string .= '<p class="msgContent">'.$atts['text'].'</p>';
    $return_string .= '</a>'; 
    $return_string .= '</div>';
    return $return_string;
}

function agg_btn_function($atts, $content = null) {
    $atts = shortcode_atts(array(
        'link' => '',
        'new_window' => 'false'
    ), $atts);
    
    $target="";
    if($atts['new_window'] == 'true'){ $target = 'target="_blank"'; }
    $return_string = '<p class="btnWrapper">';
    
    $return_string .= '<a class="btn btn-arrow" href="'.$atts['link'].'" '.$target.'>';
    
    
    $return_string .= '<span>'.$content.'</span> ';
    $return_string .= '<i class="fa fa-chevron-right"></i>';
    $return_string .= '</a>'; 
    $return_string .= '</p>';
    return $return_string;
}

function register_shortcodes(){
   add_shortcode('agg_message', 'agg_message_function');
   add_shortcode('agg_message_forum', 'agg_message_forum_function');
   add_shortcode('agg_btn', 'agg_btn_function');
}

add_action( 'init', 'register_shortcodes');



/**
 *  Verifie s'il ya des articles a la suite
 */
function has_next_posts() {
    ob_start();
    next_posts_link();
    $result = strlen(ob_get_contents());
    ob_end_clean(); 
    return $result;
}

/*
 * diseable responsive image srcset attribute
 */

//add_filter( 'max_srcset_image_width', create_function( '', 'return 1;' ) );



/**
 * Add All Custom Post Types to search
*/
/*
function rc_add_cpts_to_search($query) {

	// Check to verify it's search page
	if( is_search() ) {
		// Get post types
		$post_types = get_post_types(array('public' => true, 'exclude_from_search' => false), 'objects');
		$searchable_types = array();
		// Add available post types
		if( $post_types ) {
			foreach( $post_types as $type) {
				$searchable_types[] = $type->name;
			}
		}
		$query->set( 'post_type', $searchable_types );
	}
	return $query;
}
add_action( 'pre_get_posts', 'rc_add_cpts_to_search' );
*/



/*
 * forum
 */
add_filter( 'bbp_get_dynamic_roles', 'ntwb_bbpress_custom_role_names' );
function ntwb_bbpress_custom_role_names() {
    return array(
            // Keymaster
            bbp_get_keymaster_role() => array(
                    'name'         => 'Grand blogtrotteur',
                    'capabilities' => bbp_get_caps_for_role( bbp_get_keymaster_role() )
            ),
            // Moderator
            bbp_get_moderator_role() => array(
                    'name'         => 'Blogtrotteur',
                    'capabilities' => bbp_get_caps_for_role( bbp_get_moderator_role() )
            ),
            // Participant
            bbp_get_participant_role() => array(
                    'name'         => 'Voyageur',
                    'capabilities' => bbp_get_caps_for_role( bbp_get_participant_role() )
            ),
            // Spectator
            bbp_get_spectator_role() => array(
                    'name'         => 'Aspirant voyageur',
                    'capabilities' => bbp_get_caps_for_role( bbp_get_spectator_role() )
            ),
            // Blocked
            bbp_get_blocked_role() => array(
                    'name'         => 'Exilé',
                    'capabilities' => bbp_get_caps_for_role( bbp_get_blocked_role() )
            )
    );
}



/*
 * contentwidth
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980;
}
 
/*
 * removejetpackrelatedpostsbydefault
 */
function jetpackme_remove_rp() {
    if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
        $jprp = Jetpack_RelatedPosts::init();
        $callback = array( $jprp, 'filter_add_target_to_dom' );
        remove_filter( 'the_content', $callback, 40 );
    }
}
add_filter( 'wp', 'jetpackme_remove_rp', 20 );


/*
 * login custom stylesheet call
 */
function my_custom_login() {
echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-styles.css" />';
}
add_action('login_head', 'my_custom_login');
 
/*
 * login custom link
 */
function my_login_logo_url() {
return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
return 'Kowala - Tour du monde des PVT';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

?>