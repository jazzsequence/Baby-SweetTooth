<?php include (TEMPLATEPATH.'/get-theme-options.php'); ?>
<?php get_header(); ?>

<div id="content">

	<div id="homepage">
			<?php if ($sweettooth_featuredpost == null) { ?>
            <div class="featuredtop">
            <h2>Thanks for installing Baby Sweettooth!</h2>
            <h3>It looks like this is the first time you've used this theme.  That means you need to set it up.</h3>
            <p>Head over to the <a href="<?php bloginfo('url'); ?>/wp-admin/themes.php?page=functions.php">theme options</a> page in your dashboard to get started or take a look at the <a href="<?php bloginfo('template_directory'); ?>/readme.php">Readme</a> file included in the theme.</p>
            <p>If you feel that you are seeing this message in error, make sure that the Featured Post section in the <a href="<?php bloginfo('url'); ?>/wp-admin/themes.php?page=functions.php">Baby Sweettooth Options</a> page is entered.  (For that matter, make sure all the Featured sections are filled in.)</p>
            </div>
            <?php } else { ?>	
		<div id="homepagetop">
		
			<div class="featuredtop">
			<!-- this is the featured photo -->
            <!-- photos for this section should be 625px wide.  Smaller photos will be stretched to 625px wide and original height.
            Larger photos will be scaled to 625px wide -->
			<span id="featuredpic">
			<?php if ($sweettooth_featuredpic != null) { ?>
			<p align="center">
			<?php if ($sweettooth_featuredlink != null) { ?><a href="<?php echo $sweettooth_featuredlink; ?>"><?php } ?>
            <img src="<?php echo $sweettooth_featuredpic ?>" alt="<?php bloginfo('title'); ?>" />
            <?php if ($sweettooth_featuredlink != null) { ?></a><?php } ?>
            </p>
            <?php } ?>
            </span>
            <p>
			<!-- this is the featured post -->
			<div id="featuredpost">
			<?php $recent = new WP_Query("category_name=".$sweettooth_featuredpost."&showposts=1"); while($recent->have_posts()) : $recent->the_post();?>
            <h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
				<?php the_content_limit(350, "Read more..."); ?></div></p>
            <?php endwhile; ?>
			</div>
			
		</div>
        
        	<!-- if the first two featured categories aren't blank -->
			<?php if (($sweettooth_featuredcat1 != null) && ($sweettooth_featuredcat2 != null)) { ?>					
		<div id="homepageleft">
		
<!-- first, lets get some links -->
<?php
    // Get the ID of a given category
    $cat1 = get_cat_ID( $sweettooth_featuredcat1 );

    // Get the URL of this category
    $cat1_link = get_category_link( $cat1 );

    // Get the ID of a given category
    $cat2 = get_cat_ID( $sweettooth_featuredcat2 );

    // Get the URL of this category
    $cat2_link = get_category_link( $cat2 );	
	
    // Get the ID of a given category
    $cat3 = get_cat_ID( $sweettooth_featuredcat3 );

    // Get the URL of this category
    $cat3_link = get_category_link( $cat3 );	
?>
				
			<div class="hpfeatured">
			<h3><a href="<?php echo $cat1_link; ?>" title="<?php echo $sweettooth_featuredcat1; ?>"><?php the_ttftext ($sweettooth_featuredcat1, $echo = true, $style="klinkomitepink", $overrides="") ?></a></h3>
				<div class="the_featured_content">			
				<?php $recent = new WP_Query("category_name=".$sweettooth_featuredcat1."&showposts=3"); while($recent->have_posts()) : $recent->the_post();?>
				<b><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></b>
				<?php the_content_limit(80, "Read more..."); ?>
				
				<div style="border-bottom:1px dotted #ef69b5; margin-bottom:10px; padding:0px 0px 10px 0px; clear:both;"></div>
				
				<?php endwhile; ?>
				
				<b><a href="<?php echo $cat1_link; ?>" title="<?php echo $sweettooth_featuredcat1; ?>">Read More Posts From This Category</a></b>
				</div>
			</div>			
		</div>
		
		<div id="homepageright">			
			<div class="hpfeatured">
			<h3><a href="<?php echo $cat2_link; ?>" title="<?php echo $sweettooth_featuredcat2; ?>"><?php the_ttftext ($sweettooth_featuredcat2, $echo = true, $style="klinkomitepink", $overrides="") ?></a></h3>
				<div class="the_featured_content">
				<?php $recent = new WP_Query("category_name=".$sweettooth_featuredcat2."&showposts=3"); while($recent->have_posts()) : $recent->the_post();?>
			
				<b><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></b>				
				<?php the_content_limit(80, "Read more..."); ?>
								
				<div style="border-bottom:1px dotted #ef69b5; margin-bottom:10px; padding:0px 0px 10px 0px; clear:both;"></div>
				
				<?php endwhile; ?>
						
				<b><a href="<?php echo $cat2_link; ?>" title="<?php echo $sweettooth_featuredcat2; ?>">Read More Posts From This Category</a></b>
				</div>
			</div>		
	
		</div>
		<?php } ?>
        <?php if ($sweettooth_featuredcat3 != null) { ?>
		<div id="homepagebottom">
		
			<div class="hpbottom">
			
				<h3><a href="<?php echo $cat3_link; ?>" title="<?php echo $sweettooth_featuredcat3; ?>"><?php the_ttftext ($sweettooth_featuredcat3, $echo = true, $style="klinkomitepink", $overrides="") ?></a></h3>
				<div class="the_featured_content">
				<?php $recent = new WP_Query("category_name=".$sweettooth_featuredcat3."&showposts=3"); while($recent->have_posts()) : $recent->the_post();?>
			
				<b><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></b>
				<?php the_content_limit(350, "Read more..."); ?>
					
				<div style="border-bottom:1px dotted #ef69b5; margin-bottom:10px; padding:0px 0px 10px 0px; clear:both;"></div>
					
				<?php endwhile; ?>
	
				<!--This is where you can specify the archive link for each section. Replace the # with the appropriate URL-->
					
				<b><a href="<?php echo $cat3_link; ?>" title="<?php echo $sweettooth_featuredcat3; ?>">Read More Posts From This Category</a></b>
				</div>
			</div>

		</div>
        <?php } ?>
	<?php } ?>        
	</div>
	
<?php include(TEMPLATEPATH."/sidebar.php");?>
		
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>