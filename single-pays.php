<?php

$barcelona_is_pw_req = post_password_required();

get_header();

//barcelona_breadcrumb();
$barcelona_mod_post_meta = barcelona_get_option( 'post_meta_choices' );
?>
<?php 
$paysTitreAlt = "";
$paysTitreAlt = get_post_meta($post->ID, 'pays-titre-alt', true); 
$paysTagSlug = get_post_meta($post->ID, 'pays-tag-slug', true); 
$paysTexteBouton = get_post_meta($post->ID, 'pays-texte-bouton', true); 
$paysLienBouton = get_post_meta($post->ID, 'pays-lien-bouton', true);
$paysUrl = get_permalink();
?>
<div class="<?php echo esc_attr( barcelona_single_class() ); ?>">

	<div class="row-primary sidebar-none clearfix">

		<main id="main" class="<?php echo esc_attr( barcelona_main_class() ); ?>">

			
                    <div class="row clearfix paysTopRow">
                        
                        <div class="col-sm-8 paysTextPromo">
                        <?php if ( have_posts() ): while( have_posts() ): the_post(); ?>

				<article id="post-<?php echo intval( get_the_ID() ); ?>" <?php post_class(); ?>>
                                    
                                        
                                    
					
                                    <div class="clearfix">
                                        <div class="pays-header">
                                            <h1 class="pays-title"><?php the_title(); ?></h1>
                                        </div>
                                    </div>
                                    
                                    <div class="row clearfix">
                                        <div class="col-sm-6 paysContentText">
					<?php if ( barcelona_get_option( 'show_content' ) == 'on' ): ?>
					<section class="pays-content">
					<?php

						the_content();

						if(!empty($paysTexteBouton) && !empty($paysLienBouton)): ?>
                                            
                                            <p class="btnWrapper"><a href="<?php echo $paysLienBouton; ?>" class="btn btn-arrow"><span><?php echo $paysTexteBouton; ?></span> <i class="fa fa-chevron-right"></i></a></p>
                                                <?php endif;
					?>
					</section><!-- .post-content -->
					<?php endif; ?>
                                        </div>
                                        <div class="col-sm-6 paysPromo">
                                            
                                            <?php get_template_part('promo-colonne'); ?>                                        
                                            
                                            
                                        </div>
                                        
                                        
                                    </div><!-- .row -->

					

				</article>

			<?php endwhile; endif; ?>
                            
                        </div>
                        <div class="col-sm-4 paysThumbnailSelector">
                            
                            <?php if(has_post_thumbnail()): ?>
                            <div class="paysThumbnail">
                                <?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', false, '' ); ?>
                                <img src="<?php echo $src[0]; ?>" alt="" class="projetThumbnailScreen" />
                            </div>
                            <?php endif; ?>
                            
                            
                            
                        </div>
                    </div><!-- .row -->
                    
                    <div class="row clearfix paysFilterRow">
                        <div class="col-sm-8 paysSelectorLabelWrapper">
                            <div class="paysSelectorLabelInner">
                                <label>Filtrer par sujet :</label>
                            </div>
                        </div>
                        <div class="col-sm-4 paysSelectorColumn">
                            <?php //$tagPays = get_term_by('slug', $paysTagSlug, 'post_tag');
                            //echo '..'.$paysTagSlug;
                            $requestedFiltre = '';
                            if (get_query_var('filtre')) {
                                $requestedFiltre = $filtre;
                                $filtreCategory = get_term_by('slug', $requestedFiltre, 'category');
                            }
                            //$childrenCategories = get_term_children( 0, 'category' );  
                            $childrenCategories = get_categories( array('orderby' => 'slug', 'order' => 'ASC', 'include' => '315, 361, 308, 362') ); //print_r($childrenCategories);
                            if(!empty($childrenCategories)): ?>
                            <div class="select-widget sidebar-widget">
                                <div class="linksListWrapper">
                                    
                                    <a class="selectedItem"><i class="fa fa-angle-down"></i><?php if(!empty($requestedFiltre)) { echo $filtreCategory->name; } else { echo 'Tous les articles'; } ?></a>
                                    <ul class="bigSelectItem">
                                        <?php foreach($childrenCategories as $childCat): 
                                            $term = get_term_by('id', $childCat->term_id, 'category'); //print_r($childCat);
                                            ?>
                                        <li class="<?php if($filtreCategory->term_id == $term->term_id){ echo 'selected'; } ?>">
                                            <a href="<?php echo get_permalink(); ?>?filtre=<?php echo $term->slug; ?>"><?php echo $term->name; ?></a>
                                        </li>
                                        <?php endforeach; ?>
                                        <li class="<?php if(empty($requestedFiltre)) { echo 'selected'; } ?>"><a href="<?php echo get_permalink(); ?>">Tous les articles</a></li>
                                    </ul>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        
                    </div><!-- .paysFilterRow -->
                    
                    
                    <div class="paysPostsList row clearfix">
                    
                    
                    <?php 

                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                    $args = array( 'post_type' => 'post', 'showposts' => 8, 'tag' => $paysTagSlug, 'paged' => $paged );
                    if(!empty($requestedFiltre)) {
                        $args['cat'] = $filtreCategory->term_id;
                    }
                    $temp = $wp_query;
                    $wp_query= null;
                    $wp_query = new WP_Query();
                    $wp_query = new WP_Query( $args );
                    if ( $wp_query->have_posts() ) : ?>
                    
                    <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                    <?php

			
			include( get_template_part( 'content', 'post' ) );

			

			

		?>
                    <?php endwhile; ?>
                        
                        <?php if( has_next_posts() ): ?>
                        <section class="navigation clearfix col-sm-12">
                            <p class="nav-next">
                                <?php 
                                ob_start();
                                next_posts_link("Plus d'articles");
                                $next_posts_link_str = ob_get_contents();
                                ob_end_clean();
                                
                                echo $next_posts_link_str;
                                ?>
                            </p>
                        </section>
                        <?php endif; ?>
                    <?php else: ?>
                        
                    <div class="nf-wrapper">
                    <span class="nf-title">Aucun résultat</span>
                    <span class="nf-desc">Désolé, mais il n'y a pas encore d'articles dans cette catégorie pour cette destination.<br />
                    <a href="<?php echo $paysUrl; ?>">Retour à tous les articles</a></span>
                    
                    </div>
                        
                        
                    <?php endif; wp_reset_postdata(); ?>
                    <?php $wp_query = null; $wp_query = $temp;?>
                    </div><!-- .paysPostsList -->
                    
                    
                    
                    <div class="paysPostsListTmp" style="display: none;"></div>
                    
		</main>

		

	</div><!-- .row -->

	<?php get_template_part('promo-bandeau'); ?>                                        

</div><!-- .container -->
<?php

get_footer();