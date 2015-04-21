<?php
/*
Template Name: Achievements
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
						<header class="entry-header">
						<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
						<div class="entry-thumbnail">
							<?php the_post_thumbnail(); ?>
						</div>
						<?php endif; ?>
						<h1 class="entry-title"><?php the_title();?></h1>
						<div class="entry-title">
					<?php /* The loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
					<?php 	
					global $current_user;
					global $wpdb;
					get_currentuserinfo(); 
					//echo 'Username: ' . $current_user->user_login . "\n";
					//echo 'User email: ' . $current_user->user_email . "\n";
					//echo 'User first name: ' . $current_user->user_firstname . "\n";
					//echo 'User last name: ' . $current_user->user_lastname . "\n";
					//echo 'User display name: ' . $current_user->display_name . "\n";
					//echo 'User ID: ' . $current_user->ID . "\n";
			
				
				//Kod som hämtar ut ens egna achievements och om de är avklarade eller inte
				$result = $wpdb->get_results( "SELECT * FROM wp_achievements WHERE username = '$current_user->user_login'");

				if(empty($current_user->user_login)){
					echo "You need to login to see your achievements!";
					
					//Visar ett loginformulär om ingen användare är inloggad
					wp_login_form();
				}
				else{
					//Visar achievements från databasen
					foreach($result as $row)
					 {
						 $status = "In Progress";
						 if($row->achievementIsDone == 1){
							 $status = "Done";
						 }
						 echo $row->achievementCompletedDate;
						echo "<b>Achivement name: " . $row->achievement . "</b> <br> " . "Achivement status: " . $status . "<br> Completed: " . $row->achievementCompleteDate . "<br><br>";
					 }
				}
					?>
					</div>
					</header><!-- .entry-header -->

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			

			
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					


					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

					
				</article><!-- #post -->

				<!--<?php comments_template(); ?>-->
			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>