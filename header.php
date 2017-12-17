<?php

$barcelona_options = barcelona_get_options( array(
	'show_top_bar_menu',
	'show_header_social_icons',
	'header_style',
	'header_cover_image'
) );

if ( ! has_nav_menu( 'top' ) ) {
	$barcelona_options['show_top_bar_menu'] = 'off';
}

$barcelona_social_icons = barcelona_social_icons();
if ( empty( $barcelona_social_icons ) ) {
	$barcelona_options['show_header_social_icons'] = 'off';
}

$barcelona_fb_app_id = barcelona_get_option( 'facebook_app_id' );

?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>>
<head>

	<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>">
	<meta name="viewport" content="user-scalable=yes, width=device-width, initial-scale=1.0, maximum-scale=1">

	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->

	<link rel="pingback" href="<?php echo esc_url( get_bloginfo('pingback_url') ); ?>">

	<?php wp_head(); ?>
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri(); ?>/img/apple-touch-icon.png">
        <link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon.png"/>
</head>
<body <?php body_class(); ?>>
<?php if ( barcelona_get_option( 'add_facebook_sdk' ) == 'on' ) { ?>
<div id="fb-root"></div>
<script>
	window.fbAsyncInit = function(){
		FB.init({
			<?php if ( is_numeric( $barcelona_fb_app_id ) ): ?>
			appId: '<?php echo intval( $barcelona_fb_app_id ); ?>',
			<?php endif; ?>
			status: true,
			xfbml: true,
			version: 'v2.3'
		});
	};

	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/<?php echo barcelona_get_locale(); ?>/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
<?php } ?>
<div id="leftMenuWrapper">
    <div class="leftMenu">
        <a class="menu-close"><span class="fa fa-remove"></a>
        <div itemprop="publisher" itemscope itemtype="http://schema.org/Organization"><a itemprop="url" href="<?php echo esc_url( home_url( '/' ) ); ?>" class="menu-logo"><meta itemprop="name" content="Kowala">
            <img itemprop="logo" src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo-kowala-menu.png" alt="Kowala" />
        </a></div>
        
        <?php if ( has_nav_menu( 'main' ) ): ?>
        <div class="menuMain clearfix">
        <?php

                wp_nav_menu( array(
                        'theme_location' => 'main',
                        'container'      => false,
                        'menu_class'     => '',
                        'walker'         => new barcelona_megamenu_walker
                ) );

        ?>
        </div><!-- .navbar-collapse -->
        <?php endif; ?>
                        
        <div class="clearfix menuPaysList">
            <ul>
                <?php $args = array( 'post_type' => 'pays', 'posts_per_page' => -1, 'orderby' => 'name', 'order' => 'ASC');
                $pays_query = new WP_Query( $args );
                if ( $pays_query->have_posts() ) : ?>
                <?php while ( $pays_query->have_posts() ) : $pays_query->the_post(); 
                $paysTitreAlt = "";
                $paysTitreAlt = get_post_meta($post->ID, 'pays-titre-alt', true);
                ?>
                <li class="menuPaysList-item-<?php echo $post->ID; ?>">
                    <a href="<?php the_permalink(); ?>"><?php if(!empty($paysTitreAlt)){ echo $paysTitreAlt; } else { the_title(); } ?></a>
                </li>
                <?php endwhile; endif; wp_reset_postdata(); ?>
                <li class="menuPaysList-item-tout-du-monde">
                    <a href="<?php echo get_post_permalink(12484); ?>">Tour du monde</a>
                </li>
            </ul>
        </div>
        
        <div class="menuLeftBottom">
                    <?php wp_nav_menu( array(
                                    "menu" => "MenuColonneBottom",
                                    'container' => false,
                                    'menu_class' => ''
                            ) ); ?>

        </div>
        
    </div>
</div>
<div class="wrapper">
    
<nav class="<?php echo esc_attr( barcelona_nav_class() ); ?>">

	<div class="navbar-inner">

		<div class="container">

			<?php if ( in_array( 'on', $barcelona_options ) ): ?>
			<div class="navbar-top clearfix">

				<div class="navbar-top-left clearfix">
					<?php
					if ( $barcelona_options['show_top_bar_menu'] == 'on' ) {

						wp_nav_menu( array(
							'theme_location' => 'top',
							'container' => false,
							'menu_class' => 'navbar-top-menu'
						) );

					}
					?>
				</div>

				<div class="navbar-top-right">
					<?php wp_nav_menu( array(
							"menu" => "Top right Menu",
							'container' => false,
							'menu_class' => 'navbar-top-right-menu'
						) ); ?>
				</div>

			</div><!-- .navbar-top -->
			<?php endif; ?>

			<div class="navbar-header">
                            
                            <div class="navbar-right">
                            <?php if ( barcelona_get_option( 'show_header_social_icons' ) == 'on' ) {
                                echo $barcelona_social_icons;
                            }
                            ?>
                            </div><!-- .navbar-right -->
                                
				<button type="button" class="menu-toggle">
					<span class="sr-only">Menu</span>
					<span class="fa fa-navicon"></span>
				</button><!-- .navbar-toggle -->
                                
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
					<span class="sr-only">Menu</span>
					<span class="fa fa-navicon"></span>
				</button><!-- .navbar-toggle -->

				
				<button type="button" class="navbar-search btn-search">
					<span class="fa fa-search"></span>
				</button>
				

				<?php barcelona_header_ad(); ?>

				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar-logo">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo-kowala.png" alt="Kowala" />
				</a>

				<?php if ( $barcelona_options['header_style'] == 'c' && ! empty( $barcelona_options['header_cover_image'] ) ): ?>
				<div class="header-cover-image">
					<img src="<?php echo $barcelona_options['header_cover_image']; ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" />
				</div>
				<?php endif; ?>

			</div><!-- .navbar-header -->

			

		</div><!-- .container -->

	</div><!-- .navbar-inner -->

</nav><!-- .navbar -->

<div id="page-wrapper">