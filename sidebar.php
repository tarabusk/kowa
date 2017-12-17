<?php

if ( barcelona_get_option( 'sidebar_position' ) == 'none' ) {
	return;
}

$barcelona_sidebar = barcelona_get_option( 'default_sidebar' );

if( function_exists( 'buddypress' ) && is_buddypress() ) {
	$barcelona_sidebar = 'barcelona-buddypress-sidebar';
} else if ( function_exists( 'bbpress' ) && is_bbpress() ) {
	$barcelona_sidebar = 'barcelona-bbpress-sidebar';
} else if ( class_exists( 'Woocommerce' ) && is_woocommerce() ) {
	$barcelona_sidebar = 'barcelona-woocommerce-sidebar';
}

?>
<aside id="sidebar" class="<?php echo esc_attr( barcelona_sidebar_class() ); ?>">

	<div class="sidebar-inner">
            
            <div class="social-bar sidebar-widget">
                <div class="widget-title">
                    <h3 class="title"><?php echo do_shortcode('[easy-total-shares align="left" networks="facebook,twitter,google,pinterest,linkedin,digg,del"]'); ?>Partages</h3>
                </div>
            <?php 
            $url = get_permalink($post->ID);
            $title = get_the_title($post->ID);
            echo do_shortcode('[easy-social-share buttons="facebook,twitter,google,pinterest,linkedin,print,mail,comments" counters=0 style="icon" template="grey-blocks-retina" fullwidth="yes" fixedwidth_align="left" column="yes" columns="4" url="'.$url.'" text="'.$title.'"]'); 
            ?>
                
                <div class="sidebarForumLink clearfix">
                    <a href="<?php echo get_page_link(12857); ?>">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/forum-icon.png" alt="Forum & Aide" />
                        <p>Posez vos questions <br />et réagissez sur le forum</p>
                    </a>
                </div>
                
            </div>
            
		<?php dynamic_sidebar( $barcelona_sidebar ); ?>

	</div><!-- .sidebar-inner -->

</aside>