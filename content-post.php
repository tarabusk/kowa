<?php global $barcelona_mod_post_meta; ?>
<div class="col col-md-3 col-sm-6 mas-item postInList">

		<article class="post-summary post-format-<?php echo sanitize_html_class( barcelona_get_post_format() ); ?> clearfix">

			<div class="post-image">

				<a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
					<?php barcelona_psum_overlay(); barcelona_thumbnail( 'barcelona-md' ); ?>
				</a>

			</div><!-- .post-image -->

			<div class="post-details">

				<h2 class="post-title">
					<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
				</h2>


				<?php //if ( is_array( $barcelona_mod_post_meta ) && ! empty( $barcelona_mod_post_meta ) && in_array( 'excerpt', $barcelona_mod_post_meta ) ) : ?>
					<p class="post-excerpt">
						<?php echo esc_html( barcelona_get_excerpt( 18 ) ); ?>
					</p>

					<?php
				//endif;
				if ( isset( $barcelona_mod_post_meta ) ) {
					//barcelona_post_meta( $barcelona_mod_post_meta );
				}
				?>

			</div><!-- .post-details -->

		</article>

	</div>