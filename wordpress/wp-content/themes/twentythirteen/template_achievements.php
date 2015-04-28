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
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/sv_SE/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

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
					
					<a title="send to Facebook" 
					  href="http://www.facebook.com/sharer.php?s=100&p[title]=YOUR_TITLE&p[summary]=YOUR_SUMMARY&p[url]=YOUR_URL&p[images][0]=YOUR_IMAGE_TO_SHARE_OBJECT"
					  target="_blank">
					  <span>
						<img width="14" height="14" src="'icons/fb.gif" alt="Facebook" /> Facebook 
					  </span>
					</a>
					
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
	
	
				//Visar update-knappen för admin
					global $user_ID; 
					
					if( $user_ID ){
						if( current_user_can('level_10') ){
							echo "<form method='POST' class='message' action='http://127.0.0.1/achievements/test.php'>
							<p>This will update all achievements on the user so they will have the latest list of achievements. Only the Admin user can use this function. This function will not delete or change the status of the achievements, it will only add those achievements that is missing on the users.</p>
							<br><p>Username</p>
							<input type='text' name='username' value=''>
							<br><p>Password</p>
							<input type='password' name='password' value=''>
							<br><br><input type='submit' name='submit' value='Update achievements'>
							</form>";
						}
					}
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