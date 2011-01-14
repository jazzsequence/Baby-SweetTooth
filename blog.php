<?php
/*
Template Name: Blog Page
*/
?>

<?php get_header(); ?>

<div id="content">

	<div id="contentleft">
	
		<div class="postarea">
	
			<!--The blog page template is currently set to show 5 posts.  Change showposts=5 to whatever number of posts you want to display.-->
				
			<?php $page = (get_query_var('paged')) ? get_query_var('paged') : 1; query_posts("showposts=5&paged=$page"); while ( have_posts() ) : the_post() ?>
			<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				
			<div class="date">
			
				<div class="dateleft">
					<p><span class="time"><?php the_time('F j, Y'); ?></span> <!-- uncomment this if you want to display the author or have a multi-author blog by <?php the_author_posts_link(); ?> &nbsp; --><?php edit_post_link('(Edit)', '', ''); ?></p> 
				</div>
				
				<div class="dateright">
					<p><span class="comment"><?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?></span></p> 
				</div>
				
			</div>
				
			<?php the_content(__('[Read more]'));?><div style="clear:both;"></div>
				
			<div class="postmeta2">
				Filed Under: <?php the_category(', ') ?><br /><?php the_tags('Tags: ',', ','') ?>
			</div>
							
			<?php endwhile; ?>
			
			<p><?php posts_nav_link(); ?></p>
		
		</div>
		
	</div>
	
<?php get_sidebar(); ?>
		
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>