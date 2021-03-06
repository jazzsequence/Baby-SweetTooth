<?php get_header(); ?>

<div id="content">

	<div id="contentleft">
	
		<div class="postarea">
			
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div <?php post_class(); ?>>
            <h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
			
			<div class="date">
			
				<div class="dateleft">
					<p><span class="time"><?php the_time('F j, Y'); ?></span> &nbsp;<?php edit_post_link('(Edit)', '', ''); ?> <br /> Filed under <?php the_category(', ') ?></p> 
				</div>
				
				<div class="dateright">
					<p><span class="comment"><a href="<?php the_permalink() ?>#respond">Leave a comment</a></span></p> 
				</div>
				
			</div>
			<div class="clear"></div>

			<?php the_content(__('Read more'));?><div style="clear:both;"></div>
            <div class="navigation"><?php wp_link_pages(); ?></div>                    							
			<div class="postmeta">
				<p><span class="tags"><?php the_tags('Tags: ',', ','') ?></span></p>
			</div>
		 			
			<!--
			<?php trackback_rdf(); ?>
			-->
			</div>
			<?php endwhile; else: ?>
			
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
			
		</div>
				
		<div class="comments" id="comments">
	
			<h4>Comments</h4>
			<?php comments_template(); // Get wp-comments.php template ?>
			
		</div>
		
	</div>
	
<?php get_sidebar(); ?>
		
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>