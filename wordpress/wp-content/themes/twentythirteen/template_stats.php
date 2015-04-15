<?php
/*
Template Name: Stats
*/
?>
<?php
get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
						<div class="entry-thumbnail">
							<?php the_post_thumbnail(); ?>
						</div>
						<?php endif; ?>

						<h1 class="entry-title"><?php the_title(); ?></h1>
							<div class="entry-title">
					<?php /* The loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
					<?php 	
					
						global $wpdb;
						$result = $wpdb->get_results( "SELECT *  FROM wp_stats ");

						foreach($result as $row)
						 {
							echo $row->statName." ".$row->statCount . "<br>";
						 }
		 
					?>
					</div>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

					
				</article><!-- #post -->

				
			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>