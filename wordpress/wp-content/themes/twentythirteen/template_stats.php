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
					
					global $current_user;
					global $wpdb;
					get_currentuserinfo(); 

						$userResult = $wpdb->get_results( "SELECT * FROM wp_stats WHERE Username = '$current_user->user_login'");
						$topResultKills = $wpdb->get_results( "SELECT * FROM wp_stats WHERE statName = 'kills' ORDER BY statCount DESC LIMIT 10");
						$topResultDeaths = $wpdb->get_results( "SELECT * FROM wp_stats WHERE statName = 'deaths' ORDER BY statCount DESC LIMIT 10");
						
						$KillsKDR = $wpdb->get_results( "SELECT statCount FROM wp_stats WHERE Username = '$current_user->user_login' AND statName = 'kills'");
						$DeathsKDR = $wpdb->get_results( "SELECT statCount FROM wp_stats WHERE Username = '$current_user->user_login' AND statName = 'deaths'");

					if(empty($current_user->user_login)){
						echo "You need to login to see your own stats!";
					
					//Visar ett loginformulär om ingen användare är inloggad
					wp_login_form();
					}else{
						if(!empty($userResult)){
							echo "<div class='statColumn'><h2>Your stats</h2><br>";
							foreach($userResult as $row)
							 {
								 //Gör så att första bokstaven blir stor i statName
								$statName = ucfirst($row->statName);
								//Visar den inloggade användarens stats
								echo $statName . " ".$row->statCount . "<br>";
								
							 }
							 foreach($KillsKDR as $row){
								$kills = $row->statCount;
								foreach($DeathsKDR as $row2){
									$deaths = $row2->statCount;
								}
								
								$KDR = $kills/$deaths;
								
								echo "Kill/Death ratio " . $KDR;
								echo "</div>";
							}
							 
 
						}else{
							echo "You need to play the game to get stats!";
							echo "</div>";
						}

					}
					
							echo "<div class='statColumn'><h2>Top 10 killers</h2><br>";
								foreach($topResultKills as $row){
									echo $row->Username . " got " . " ".$row->statCount . " kills<br>";
								}
							echo "</div>";
							
							echo "<div class='statColumn'><h2>Top 10 most killed</h2><br>";
								foreach($topResultDeaths as $row){
									echo $row->Username . " have died " . " ".$row->statCount . " times<br>";
								}
							echo "</div>";
							
							echo "<h2>Top 10 highest level</h2><br>";
							echo "<h2>Top 10 longest playtime</h2><br>";
		 
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