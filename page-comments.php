<?php
/*
Template Name: Page with Comments
*/
?>
<?php get_header(); ?>

<div id="content">

	<div id="contentpage">
	
		<div class="postarea">
	
	
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="dateright">
					<p><span class="comment"><?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?></span></p> 
				</div> 
			<h1><?php the_title(); ?></h1><br />
		
			<?php the_content(__('Read more'));?>
					<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
						// Both Comments and Pings are open ?>
					<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
						// Neither Comments, nor Pings are open ?>
						Both comments and pings are currently closed.

					<?php } edit_post_link('Edit this entry','','.'); ?>
	<?php comments_template(); ?>           
            <div style="clear:both;"></div>
				</div>
			</div>


			<?php endwhile; else: ?>
			
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
		
		</div>
		
	</div>
	
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>