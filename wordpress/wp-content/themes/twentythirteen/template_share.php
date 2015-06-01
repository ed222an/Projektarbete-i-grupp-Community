<?php
/*
Template Name: share
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
global $current_user;
global $wpdb;
get_currentuserinfo();

//Gets the user and achievement parameters
$user = $_GET['user'];
$achievement = $_GET['achievement'];

//Gets the specific achievement
$result = $wpdb->get_results( "SELECT * FROM wp_achievements WHERE username = '$user' AND achievement = '$achievement'");

foreach($result as $row){
	if($row->achievementIsDone == 0){
		 header("Location: http://127.0.0.1/Projektarbeteigrupp/?page_id=10");
	}
}

get_header(); ?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/sv_SE/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>



	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
			
			<?php
			//Function that gets the current url
			//http://webcheatsheet.com/php/get_current_page_url.php
				function currentPageURL() {
				 $pageURL = 'http';
				 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
				 $pageURL .= "://";
				 if ($_SERVER["SERVER_PORT"] != "80") {
				  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
				 } else {
				  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
				 }
				 return $pageURL;
				}
			?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
						<div class="entry-thumbnail">
							<?php the_post_thumbnail(); ?>
						</div>
						<?php endif; ?>

						<h1 class="entry-title"><?php 

							the_title(); 
						
						?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php the_content(); ?>
						<?php 	
			
							global $current_user;
							global $wpdb;
							get_currentuserinfo();
							
							//Gets the user and achievement parameters
							$user = $_GET['user'];
							$achievement = $_GET['achievement'];
							
							//Gets the specific achievement
							$result = $wpdb->get_results( "SELECT * FROM wp_achievements WHERE username = '$user' AND achievement = '$achievement'");
							
							//If no rows exist an error message is shown
							if(empty($result)){
								echo "Something went wrong!";
							}
							else{
								//Shows the achievement
									foreach($result as $row){
											$status = "In Progress";
											if($row->achievementIsDone == 1){
												 $status = "Done";
											}
								
							$desc = $wpdb->get_results( "SELECT description,imgpath FROM wp_achievementlist WHERE name = '$row->achievement'");
							foreach($desc as $descRow){		
								
								echo "<div class='boxDone'>";
								echo "<img src='". $descRow->imgpath ."' alt='test' height='100' width='100'>";
								echo $row->achievementCompletedDate;
								echo "<div class='achiName'>" . $row->achievement . "</div> " . "<div class='achiDesc'>" . $descRow->description . "</div>" . "<div class='achiStatus'>Achivement status: " . $status . "</div> <div class='achiDate'>Completed: " . 
								$row->achievementCompleteDate . "</div>";
								echo"</div>";
											//Add social media here
											$url = currentPageURL();
											if($user == $current_user->user_login){
												//echo "<a href='http://www.facebook.com/share.php?u=http://www.metalgenre.se/wordpress/?page_id=43&user=Admin&achievement=50%20kills&title=Testar'>DELA SKITEN</a>";
												echo "<div class='fb-share-button' data-href='' data-layout='button'></div>";
												echo "<div class='fb-like' data-href='$url' data-layout='standard' data-action='like' data-show-faces='true' data-share='false'></div>";
												//echo "<a href='https://twitter.com/intent/tweet' class='twitter-share-button' data-text=' Completed achievement $row->achievement on $row->achievementCompleteDate'>Tweet</a>";
												echo "<a class='twitter-share-button'
													  href='https://twitter.com/share'
													  data-size='small'
													  data-url='$url'
													  data-count-url='$url'
													  data-via=''
													  data-related=''
													  data-hashtags=''
													  data-text='Completed achievement $row->achievement'>
													Tweet
													</a>";
											}
											else{
												echo "<br><div class='fb-like' data-href='$url' data-layout='standard' data-action='like' data-show-faces='true' data-share='false'></div><br>";
											}
											
										}
									}
							}
 
			?>
						
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
				</article><!-- #post -->

			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>