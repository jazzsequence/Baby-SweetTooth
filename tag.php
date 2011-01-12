<?php get_header(); ?>

<div id="content"> 

	<div id="contentleft">
	
		<div class="postarea">
	

			
			<?php if (have_posts()) : ?>
            <h2 class="the_post_title">Posts tagged with <?php single_tag_title(); ?></h2>            
             <?php while (have_posts()) : the_post(); ?>
			<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			
			<div class="date">
			
				<div class="dateleft">
					<p><span class="time"><?php the_time('F j, Y'); ?></span> <!-- by <?php the_author_posts_link(); ?> &nbsp; --><?php edit_post_link('(Edit)', '', ''); ?> <br /> Filed under <?php the_category(', ') ?></p> 
				</div>
				
				<div class="dateright">
					<p><span class="comment"><?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?></span></p> 
				</div>
				
			</div>
		
			<?php the_content(__('Read more'));?><div style="clear:both;"></div>
			
			<div class="postmeta2">
				<p><span class="tags"><?php the_tags('Tags: ',', ','') ?></span></p>
			</div>
			
			<?php endwhile; else: ?>
			
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
			<p><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?></p>
			
		</div>
				
	</div>
	
<?php include(TEMPLATEPATH."/sidebar.php");?>
		
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>