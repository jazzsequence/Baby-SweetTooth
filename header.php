<?php include (TEMPLATEPATH.'/get-theme-options.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="distribution" content="global" />
<meta name="robots" content="follow, all" />
<meta name="language" content="en, sv" />

<title><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>
<link rel="Shortcut Icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_get_archives('type=monthly&format=link'); ?>
<?php wp_head(); ?>
<style type="text/css" media="screen"><!-- @import url( <?php bloginfo('stylesheet_url'); ?> ); --></style>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/master.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/jquery.formalize.js"></script>
<script type="text/javascript"><!--//--><![CDATA[//><!--
sfHover = function() {
	if (!document.getElementsByTagName) return false;
	var sfEls = document.getElementById("nav").getElementsByTagName("li");

	// if you only have one main menu - delete the line below //
	var sfEls1 = document.getElementById("subnav").getElementsByTagName("li");
	//

	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" sfhover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}

	// if you only have one main menu - delete the "for" loop below //
	for (var i=0; i<sfEls1.length; i++) {
		sfEls1[i].onmouseover=function() {
			this.className+=" sfhover1";
		}
		sfEls1[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover1\\b"), "");
		}
	}
	//

}
if (window.attachEvent) window.attachEvent("onload", sfHover);
//--><!]]></script> 
	<!-- this activates Twitter @anywhere hovercards -->
	  <script src="http://platform.twitter.com/anywhere.js?id=3O4tZx3uFiEPp5fk2QGq1A&v=1">
      </script>
      <script type="text/javascript">
         twttr.anywhere(function(twitter) {
                  twitter.hovercards();
         });
      </script>
<?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
</head>

<body <?php body_class();?>><div class="topstripes"></div>
<div align="center">
<div id="wrap">

	

<div id="header">
<?php if ($sweettooth_toppic1 == null) { ?>
<!-- do nothing, don't display the picture frames -->
<?php } else { ?>
<div class="threepicboxes">
<img src="<?php bloginfo('template_url'); ?>/images/pictopleft.png" style="background: url('<?php echo $sweettooth_toppic1 ?>') 50px 40px no-repeat;" alt="<?php bloginfo('title'); ?>" /><img src="<?php bloginfo('template_url'); ?>/images/pictopmiddle.png" style="background: url('<?php echo $sweettooth_toppic2 ?>') 15px 48px no-repeat;" alt="<?php bloginfo('title'); ?>" /><img src="<?php bloginfo('template_url'); ?>/images/pictopright.png" style="background: url('<?php echo $sweettooth_toppic3 ?>') 13px 40px no-repeat;" alt="<?php bloginfo('title'); ?>" />
</div>
<?php } ?>
<div class="headerleft">
        <h1><a href="<?php echo get_option('home'); ?>" rel="nofollow">
		<?php the_ttftext(get_bloginfo('name'),$echo = true, $style="sweettooth"); ?>
        </a></h1> 
	</div>
<div style="clear:both;"></div>
			<?php wp_nav_menu( array( 'container' => 'ul','menu_id' => 'nav','depth' => 1, 'theme_location' => 'primary' ) ); ?>            



</div>


<div style="clear:both;"></div>