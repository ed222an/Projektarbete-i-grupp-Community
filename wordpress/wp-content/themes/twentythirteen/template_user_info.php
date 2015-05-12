<?php
/*
Template Name: UserInfo
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

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<?php 	
				
				

 
 
 
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
						<?php 
							the_content();
						if(empty($_GET['user'])){
							$user = isset($_POST['user']) ? $_POST['user'] : "";
						}
						else{
							$user = $_GET['user'];
						}
										
						//$user = $_GET['user'];
						global $current_user;
						global $wpdb;
						get_currentuserinfo(); 
						
						$result = $wpdb->get_results( "SELECT * FROM wp_achievements WHERE username = '$user'");
						$id = $wpdb->get_results( "SELECT * FROM wp_users WHERE display_name = '$user'");
						echo "<h2>$user</h2>";
						//Hårdkodat
						foreach($id as $row){
							echo get_avatar( $row->ID, 128 );
						}
						
						echo "<h2>Achievements</h2>";
						foreach($result as $row)
						{
							$desc = $wpdb->get_results( "SELECT description FROM wp_achievementlist WHERE name = '$row->achievement'");
							foreach($desc as $descRow){
							
							$status = "In Progress";
							if($row->achievementIsDone == 1){
								$status = "Done";
								echo "<div class='boxDone'>";
								echo "<img src='https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcRRah4V-2abPr1pIqhEvGG9d3_qpc_4n4FR9CjXAnHYTQpPb9He' alt='test' height='100' width='100'>";
								echo $row->achievementCompletedDate;
								echo "<div class='achiName'>Achivement name: " . $row->achievement . "</div> " . "<div class='achiDesc'>" . $descRow->description . "</div>" . "<div class='achiStatus'>Achivement status: " . $status . "</div> <div class='achiDate'>Completed: " . 
								$row->achievementCompleteDate . "</div>";
								echo"</div>";
							}
							if($row->achievementIsDone == 0)
							{
								echo "<div class='boxNotDone'>";
								echo "<img src='https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcRRah4V-2abPr1pIqhEvGG9d3_qpc_4n4FR9CjXAnHYTQpPb9He' alt='test' height='100' width='100'>";
								echo $row->achievementCompletedDate;
								echo "<div class='achiName'>Achivement name: " . $row->achievement . "</div>" . "<div class='achiDesc'>" . $descRow->description . "</div>" . "<div class='achiStatus'>Achivement status: " . $status . "</div> <div class='achiDate'>Completed: " . 
								$row->achievementCompleteDate . "</div>";
								echo"</div>";
							}
							}							
						}
						$userResult = $wpdb->get_results( "SELECT * FROM wp_stats WHERE Username = '$user'");
						//echo "<h2>Stats</h2>";
							
							
						echo "<div class='statColumn'><h2>$user stats</h2><br>";
							foreach($userResult as $row)
							 {
								 //Gör så att första bokstaven blir stor i statName
								$statName = ucfirst($row->statName);
								//Visar den inloggade användarens stats
								echo $statName . " ".$row->statCount . "<br>";
								
							 }
					echo "</div><br>";

					echo "Search for a user";
					echo "<form action='http://127.0.0.1/Projektarbeteigrupp/user/' method='GET'>
						<input name='user' type='text' value=''/>
						<input type='submit' value='Search'>
					</form>";
						
						
						
						?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
				</article><!-- #post -->

				<!--<?php comments_template(); ?>-->
			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>