<?php get_header(); ?>

<div id="content">

	<div id="contentleft">
	
		<div class="postarea">
				
			<h1>Not Found, Error 404</h1>
			<p>The page you are looking for no longer exists. Perhaps you can find what you are looking for by searching the site archives by page, month, or category:</p>
			
				<b>by page:</b>
					<ul>
						<?php wp_list_pages('title_li='); ?>
					</ul>
				
				<b>by month:</b>
					<ul>
						<?php wp_get_archives('type=monthly'); ?>
					</ul>
							
				<b>by category:</b>
					<ul>
						<?php wp_list_categories(); ?>
					</ul>
		</div>
		
	</div>
	
<?php get_sidebar(); ?>
		
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>