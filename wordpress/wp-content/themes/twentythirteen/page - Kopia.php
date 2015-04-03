<?php
/*
Template Name: MyOwnCode
*/
?>
<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<h1>Highscores</h1>
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<?php 	
			
global $wpdb;
$result = $wpdb->get_results( "SELECT *  FROM highscore ");

foreach($result as $row)
 {
	echo $row->Highscore."  ".$row->HighscoreUsername."<br>";
 }
 
 
 
			?>
			<h1>Achievements</h1>
			
			<?php 
			
				global $current_user;
					get_currentuserinfo(); 
					//echo 'Username: ' . $current_user->user_login . "\n";
					//echo 'User email: ' . $current_user->user_email . "\n";
					//echo 'User first name: ' . $current_user->user_firstname . "\n";
					//echo 'User last name: ' . $current_user->user_lastname . "\n";
					//echo 'User display name: ' . $current_user->display_name . "\n";
					//echo 'User ID: ' . $current_user->ID . "\n";
			
				
				global $wpdb;
				$result = $wpdb->get_results( "SELECT *  FROM achievements WHERE achievementUserID = $current_user->ID");

				foreach($result as $row)
				 {
					 $status = "In Progress";
					 if($row->achievementIsDone == 1){
						 $status = "Done";
					 }
					echo "<b>Achivement name: " . $row->achievement."</b> <br> ". "Achivement status: " . $status."<br><br><br>";
				 }
			
			?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
						<div class="entry-thumbnail">
							<?php the_post_thumbnail(); ?>
						</div>
						<?php endif; ?>

						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
				</article><!-- #post -->

				<?php comments_template(); ?>
			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>