<?php
/*
Template Name: Stats
*/
?>
<?php
get_header(); ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/sv_SE/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
						<div class="entry-thumbnail">
							<?php the_post_thumbnail(); ?>
						</div>
						<?php endif; ?>
						<h1 class="entry-title">
						<?php the_title(); ?></h1>
						<?php
						global $current_user;
						if(empty($current_user->user_login))
						{
							echo "<p class='center'>You need to login to see your own stats!<br>";
							echo "<a  href='http://127.0.0.1/Projektarbeteigrupp/wp-login.php'>Log in</a></p>";
						}						
						?>
						
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
						$topResultGold = $wpdb->get_results( "SELECT * FROM wp_stats WHERE statName = 'gold' ORDER BY statCount DESC LIMIT 10");
						
						
						$KillsKDR = $wpdb->get_results( "SELECT statCount FROM wp_stats WHERE Username = '$current_user->user_login' AND statName = 'kills'");
						$DeathsKDR = $wpdb->get_results( "SELECT statCount FROM wp_stats WHERE Username = '$current_user->user_login' AND statName = 'deaths'");

					if(empty($current_user->user_login)){
						
					
					//Visar ett loginformulär om ingen användare är inloggad
					//wp_login_form();
					
					}else{
						if(!empty($userResult)){
							echo "<div class='statColumn'><h2>Your stats</h2>";
						
							foreach($userResult as $row)
							 {
								 //Gör så att första bokstaven blir stor i statName
								$statName = ucfirst($row->statName);
								//Visar den inloggade användarens stats

								
								echo $statName . " ".$row->statCount . "<br>";
								
							 }
							 if(empty($KillsKDR) || empty($DeathsKDR)){
								 echo "KDR not available";
							 }
							 else{
								foreach($KillsKDR as $row){
								$kills = $row->statCount;
								foreach($DeathsKDR as $row2){
									$deaths = $row2->statCount;
								}
								
								$KDR = $kills/$deaths;
								
								echo "Kill/Death ratio " . $KDR;
								//echo "</div>";
							 }

							}
							echo "</div>";
							 
 
						}else{
							echo "You need to play the game to get stats!<br>";
						}
					}
							echo "<div class='statColumn'><h2>Top 10 killers</h2><br>";
								foreach($topResultKills as $row){
									echo "<b><a href='http://127.0.0.1/Projektarbeteigrupp/user/?user=$row->username'>$row->username</a>" . "</b> got " . " ".$row->statCount . " kills<br>";
								}
							echo "</div>";
							
							echo "<div class='statColumn'><h2>Top 10 most killed</h2><br>";
								foreach($topResultDeaths as $row){
									echo "<b><a href='http://127.0.0.1/Projektarbeteigrupp/user/?user=$row->username'>$row->username</a>" . "</b> have died " . " ".$row->statCount . " times<br>";
								}
							echo "</div>";
							
							
							
							echo "<div class='statColumn'><h2>Top 10 most gold</h2><br>";
								foreach($topResultGold as $row){
									echo "<b><a href='http://127.0.0.1/Projektarbeteigrupp/user/?user=$row->username'>$row->username</a>" . "</b> collected " . " ".$row->statCount . " goldcoins<br>";
								}
							echo "</div>";
							echo "</div>";
					echo "<div class='searchUser'>Search for a user";
					echo "<form action='http://127.0.0.1/Projektarbeteigrupp/user/' method='GET'>
						<input name='user' type='text' value=''/>
						<input type='submit' value='Search'>
					</form>";
					
					echo "<a href='http://127.0.0.1/Projektarbeteigrupp/user/?showAll'>Show all members</a></div>";
					?>
					
					<div class="fb-like" data-href="http://127.0.0.1/Projektarbeteigrupp/" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div><br>
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