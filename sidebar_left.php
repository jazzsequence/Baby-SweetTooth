<!-- begin l_sidebar -->

<div id="l_sidebar">

	<ul id="l_sidebarwidgeted">
	
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>

		<li id="recent-posts">
		<h2><?php the_ttftext ("Recent Posts", $echo = true, $style="klinkomitepink", $overrides="") ?></h2> 
			<ul>
				<?php wp_get_archives('type=postbypost&limit=5'); ?> 
			</ul>
		</li>

	
		<li id="categories">
		<h2><?php the_ttftext ("Categories", $echo = true, $style="klinkomitepink", $overrides="") ?></h2>
			<ul>
				<?php wp_list_categories('sort_column=name&title_li='); ?>
			</ul>
		</li>
	

	
	<?php endif; ?>
	
	</ul>
</div>

<!-- end l_sidebar -->