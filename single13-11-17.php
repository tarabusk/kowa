<?php

$barcelona_is_pw_req = post_password_required();

get_header();

barcelona_breadcrumb();
$isGuide = 0;
/*
$guideCatChildren = get_term_children( 286, 'category' );
if(!empty($guideCatChildren)){
    foreach($guideCatChildren as $childID){
        if( has_category( $childID ) ){ $isGuide = 1; break; }
    }
}
*/
if( has_category( 315 ) OR has_category( 318 ) OR has_category( 361 ) ){ $isGuide = 1; }

?>


<?php if(! $isGuide): ?>
<?php
if ( ! $barcelona_is_pw_req ) {
	barcelona_featured_img();
}

?>
<?php  endif; ?>



<div class="<?php echo esc_attr( barcelona_single_class() ); ?>">

	<div class="<?php echo esc_attr( barcelona_row_class() ); ?>">


                <?php if($isGuide): ?>
            <div class="row clearfix guideTopRow">
                <div class="col-md-8">
                    <?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'barcelona-full', false, '' ); ?>

                    <div id="smallOnly">
                        <div class="fimg-wrapper fimg-fw ">
                            <div class="guide-featured-image">
                                <div class="fimg-inner"><?php if(!empty($src)): ?><img src="<?php echo $src[0]; ?>" alt="" /><?php endif; ?></div>
                            </div>

                        </div>
                    </div>

                    <div id="bigOnly">
                        <script>jQuery(document).ready(function($){ $('.fimg-inner').backstretch('<?php echo $src[0]; ?>', {fade: 600}); });</script>
			<div class="fimg-wrapper fimg-fw ">
                            <div class="featured-image">
				<div class="fimg-inner">
						<div class="vm-wrapper">
							<div class="vm-middle"></div>
					</div>
				</div>



                            </div>


                        </div>
                    </div>
                </div>

                <?php $postTags = wp_get_post_tags($post->ID); ?>

                <div class="col-md-4">
                    <div class="sidebar-widget select-widget">
                        <div class="widget-title"><h4 class="title">Guides</h4></div>
                        <div class="linksListWrapper">
                            <a class="selectedItem">Destinations <i class="fa fa-angle-down"></i></a>
                            <ul class="bigSelectItem">
                                <?php $args = array( 'post_type' => 'pays', 'posts_per_page' => -1, 'orderby' => 'name', 'order' => 'ASC');
                                $pays_query = new WP_Query( $args );
                                if ( $pays_query->have_posts() ) : ?>
                                <?php while ( $pays_query->have_posts() ) : $pays_query->the_post();
                                $paysTitreAlt = "";
                                $paysTitreAlt = get_post_meta($post->ID, 'pays-titre-alt', true); ?>
                                <li class="selectorGuidePays-item-<?php echo $post->ID; ?> <?php if($post->post_slug == $postTags->slug): ?>selected<?php endif; ?>">
                                    <a href="<?php the_permalink(); ?>"><?php if(!empty($paysTitreAlt)){ echo $paysTitreAlt; } else { the_title(); } ?></a>
                                </li>
                                <?php endwhile; endif; wp_reset_postdata(); ?>
                            </ul>
                        </div>
                    </div>
                    <div class="guideTopPromo sidebar-widget">
                        <div class="widget-title"><h4 class="title">Bons plans</h4></div>
                        <?php get_template_part('promo-colonne'); ?>
                    </div>

                </div>
            </div>

<?php  endif; ?>


		<main id="main" class="<?php echo esc_attr( barcelona_main_class() ); ?>">

			<?php if ( have_posts() ): while( have_posts() ): the_post(); ?>
				<?php $withtitle = false; ?>
				<article id="post-<?php echo intval( get_the_ID() ); ?>" <?php post_class(); ?>>
                                    <?php if(! $isGuide): ?>
                                    <?php barcelona_featured_img(); ?>
                                    <?php else: ?>
																		<?php $withtitle = true; ?>
                                    <h1 itemprop="name" class="post-title entry-title"><?php the_title(); ?></h1>
                                    <?php endif; ?>
					<?php
					if ($withtitle) {
						echo '<div class="container-blocs container-blocs-retrait">';
					} else {
						echo '<div class="container-blocs">';
					}

					$categories = get_the_category();
					$separator = ' ';
					$output = '';
					if ( ! empty( $categories ) ) {
					    foreach( $categories as $category ) {
					        $output .= ' <a class="lien-bloc-categorie" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
					    }
					    echo trim( $output, $separator );
					}
					echo get_the_tag_list('<span class="lien-bloc-tag">','' , '</span>');
					echo '</div>';
					if (wp_is_mobile()) {echo '<div class="sommaire-mobile">'.do_shortcode( '[sommaire]' ).'</div>';}

					?>
					<?php if ( barcelona_get_option( 'show_content' ) == 'on' ): ?>

					<section itemprop="articleBody" class="post-content">
					<?php

						the_content();

						if ( ! $barcelona_is_pw_req ) {

							wp_link_pages( array(
								'before'   => '<div class="pagination"><span class="page-numbers title">' . esc_html__( 'Pages:', 'barcelona' ) . '</span>',
								'after'    => '</div>',
								'pagelink' => '%'
							) );

						}

					?>
					<span class="updated">Article mis à jour le <?php echo get_the_modified_time('j F Y'); ?></span>
					<!-- JETPACK RELATED ARTICLES SHORTCODE --><?php
					if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
					   echo do_shortcode( '[jetpack-related-posts]' );
					}
					?>
					</section><!-- .post-content -->
					<?php endif; ?>

					<?php if ( ! $barcelona_is_pw_req ): ?>
					<footer class="post-footer">

						<?php if ( barcelona_get_option( 'show_tags' ) == 'on' && $barcelona_post_tags = get_the_tags() ): ?>
						<div class="post-tags">
							<?php the_tags( '<strong class="title">'. esc_html__( 'Tags:', 'barcelona' ) .'</strong> ' ); ?>
						</div><!-- .post-tags -->
						<?php endif; ?>

						<?php

						barcelona_post_voting();

						barcelona_social_sharing();

						barcelona_author_box();

						barcelona_pagination( 'nextprev' );

						barcelona_post_ad();


                                                if(! $isGuide){ comments_template(); }

						?>

					</footer><!-- .post-footer -->
					<?php endif; ?>

				</article>

			<?php endwhile; endif; ?>

		</main>

		<?php get_sidebar(); ?>

	</div><!-- .row -->

        <?php get_template_part('promo-bandeau'); ?>

	<?php barcelona_related_posts(); ?>

</div><!-- .container -->
<?php

get_footer();
