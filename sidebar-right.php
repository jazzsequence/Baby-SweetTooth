<!-- begin r_sidebar -->

<div id="r_sidebar">

	<ul id="r_sidebarwidgeted">
	
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(3) ) : else : ?>
		
		<li id="archives">
		<h2><?php the_ttftext ("Archives", $echo = true, $style="klinkomitepink", $overrides="") ?></h2> 
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
		</li>
		
		<li id="links">
		<h2><?php the_ttftext ("Blogroll", $echo = true, $style="klinkomitepink", $overrides="") ?></h2> 
			<ul>
				<?php wp_list_bookmarks('title_li=&categorize=0'); ?>
			</ul>
		</li>        
	<?php endif; ?>

	</ul>
</div>

<!-- end r_sidebar -->