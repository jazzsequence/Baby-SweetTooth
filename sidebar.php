<!-- begin sidebar -->
<?php include (TEMPLATEPATH.'/get-theme-options.php'); ?>
<div id="sidebar">

		<?php if ($sweettooth_feedburner_id != null) { ?>
	<div class="newsletter">	
		<h2><?php the_ttftext ("Get Updates", $echo = true, $style="klinkomitepink", $overrides="") ?></h2>
		<img src="<?php bloginfo('template_url'); ?>/images/rss.jpg" style="padding-right: 10px; float: left;" /><p>Sign up to receive news as well as other updates!</p>
<form id="subscribe" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=jazzsequence-kidsblog', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true"><input type="text" value="Enter your email address..." id="subbox" onfocus="if (this.value == 'Enter your email address...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Enter your email address...';}" name="email"/><input type="hidden" value="<?php $feedburner_id = get_option('sweettooth_feedburner_id'); echo $feedburner_id; ?>" name="uri"/><input type="hidden" name="loc" value="en_US"/><input type="submit" value="Subscribe" id="subbutton" /></form>                
	</div>
	<?php } ?>
	<?php if ($sweettooth_video != null) { ?>
	<!--To determine what video is shown on the homepage,  remove the arrows and go to your WP dashboard and go to Presentation -> Theme Options and enter your video code here.	-->
	<div class="video">
		<h2><?php the_ttftext ("Featured Video", $echo = true, $style="klinkomitepink", $overrides="") ?></h2>
		<?php $video = get_option('sweettooth_video'); echo stripslashes($video); ?>		
	</div>
    <?php } ?>
	<div class="widgetarea">
	
	<ul id="sidebarwidgeted">
	
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>

	<?php endif; ?>
	
	</ul>
	
	</div>

	<?php get_sidebar('left');?>
	<?php get_sidebar('right');?>
	<div style="height: 5px; padding: 10px 0 10px 0; clear:both;"></div>	
</div>

<!-- end sidebar -->