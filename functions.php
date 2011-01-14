<?php
if ( function_exists('register_sidebars') )
    register_sidebar(array(
		'name' => 'Top Sidebar',
		'description' => 'This is the wide sidebar at the top',	
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
    ));
    register_sidebar(array(
		'name' => 'Bottom Left Sidebar',
		'description' => 'This is the skinny sidebar on the bottom left.',	
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
    ));
    register_sidebar(array(
		'name' => 'Bottom Right Sidebar',
		'description' => 'This is the skinny sidebar on the bottom right.',	
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
    ));

require (TEMPLATEPATH.'/ttftitles/ttftitles.php');
require (TEMPLATEPATH.'/update-notice.php');

/** Tell WordPress to run sweettooth_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'sweettooth_setup' );

if ( ! function_exists( 'sweettooth_setup' ) ):

function sweettooth_setup() {

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'sweettooth' ),
	) );	

} 
endif;


// set content width
if ( ! isset( $content_width ) ) $content_width = 650;

// this changes the output of the comments
function sweettooth_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
      <div class="comment-author vcard">
         <?php echo get_avatar
($comment,$size='64',$default='<path_to_url>' ); ?>
On <?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()) ?>
     <?php printf(__('<cite>%s</cite> <span class="says">said:</span>'), get_comment_author_link()) ?>
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>
      <?php comment_text() ?>
      <div class="comment-meta commentmetadata"><?php edit_comment_link(__('(Edit)'),'  ','') ?></div>
      <div class="reply"><button>
         <?php comment_reply_link(array_merge
		 ( $args, array('depth' => $depth, 'reply_text' => 'Respond to this', 'max_depth' => $args['max_depth']))) ?>
      </button></div>
     </div>
<?php
        }

/* Here's soem theme options */
$themename = "Baby Sweettooth";
$shortname = "sweettooth";
$options = array (
				array(	"name" => "<h2>Baby Sweettooth Options</h2>",
						"type" => "title"),
				array(	"name" => "<h2>General Settings</h2>",
						"type" => "title"),
						
				array(	"name" => "Feedburner ID",
						"desc" => "Learn how to find your Feedburner ID by reading this <a href='http://www.nathanrice.net/blog/whats-my-feedburner-id/'>tutorial</a>.<br /><br />",
			    		"id" => $shortname."_feedburner_id",
			    		"std" => "",
			    		"type" => "text"),

				array(	"name" => "Video Code",
						"desc" => "This is for the featured video in the sidebar. <br /> Recommended size for the video is 300x250, so don't forget to change that from the embedded video code.<br /><br />For example, you'd want to change the bolded items in this: &lt;object width='<b style='font-size: 1.3em;'>300</b>' height='<b style='font-size: 1.3em;'>250</b>'&gt;&lt;param name='movie' value='http://www.youtube.com/v/npP73QIApFE&hl=en&fs=1'&gt;&lt;/param&gt;&lt;param name='allowFullScreen' value='true'&gt;&lt;/param&gt;&lt;param name='allowscriptaccess' value='always'&gt;&lt;/param&gt;&lt;embed src='http://www.youtube.com/v/npP73QIApFE&hl=en&fs=1' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='<b style='font-size: 1.3em;'>300</b>' height='<b style='font-size: 1.3em;'>250</b>'&gt;&lt;/embed&gt;&lt;/object&gt;",						"id" => $shortname."_you_tube",
			    		"id" => $shortname."_video",
						"std" => "",
						"type" => "textarea"),
				array ( "name" => "<h2>Header Images</h2>These are the three images that appear in the header.  Images must be 117px square.  If you need a program to crop your photos, use <a href='http://www.picnik.com/' target='_blank'>Piknik</a>.",
						"type" => "title"),						
				array ( "name" => "Top Left",
						"desc" => "This is the image that appears in the left box in the header.",
						"id" => $shortname."_toppic1",
						"std" => "",
						"type" => "text"),
				array ( "name" => "Top Middle",
						"desc" => "This is the image that appears in the middle box in the header.",
						"id" => $shortname."_toppic2",
						"std" => "",						
						"type" => "text"),
				array ( "name" => "Top Right",
						"desc" => "This is the image that appears in the right box in the header.",
						"id" => $shortname."_toppic3",
						"std" => "",						
						"type" => "text"),												
				array ( "name" => "<h2>Home Page</h2>",
						"type" => "title"),						
				array ( "name" => "Featured Pic",
						"desc" => "This is the featured image that appears on the home page. <br />Photos for this section should be 625px wide.  Smaller photos will be stretched to 625px wide and original height. Larger photos will be scaled down to 625px wide.  You can upload images using the <a href='media-new.php'>Add New Media</a> section and then paste the image URL here when you are done.",
						"id" => $shortname."_featuredpic",
						"std" => "",
						"type" => "text"),
				array ( "name" => "Featured Pic Link",
						"desc" => "You can add a URL to link the image on the home page to, like a larger version of the image or a post or page.",
						"id" => $shortname."_featuredlink",
						"std" => "",
						"type" => "text"),
				array ( "name" => "Featured Post",
						"desc" => "Underneath the featured pic (if you have one) there will be the most recent post from a specific category will be displayed.  Pick the category you want to feature in this area here.  Category must exist and the category must be spelled correctly.  <a href='edit-tags.php?taxonomy=category'>Click here to check your existing categories.</a>",
						"id" => $shortname."_featuredpost",
						"std" => "Uncategorized",
						"type" => "text"),
				array ( "name" => "Featured Category 1",
						"desc" => "Underneath the featured post, there are two columns of featured categories.  This is for the category that displays on the left.",
						"id" => $shortname."_featuredcat1",
						"std" => "Uncategorized",
						"type" => "text"),
				array ( "name" => "Featured Category 2",
						"desc" => "This is the category that displays on the right side, underneath the featured post.",
						"id" => $shortname."_featuredcat2",
						"std" => "Uncategorized",
						"type" => "text"),
				array ( "name" => "Featured Category 3",
						"desc" => "Underneath those two featured categories, there is one more featured category that displays in a wider box.  Enter the category you want to display here.  (This section is optional.)",
						"id" => $shortname."_featuredcat3",
						"std" => "Uncategorized",
						"type" => "text"),						
		  );
		
// here's the styling and cases and such for the theme options page

/*
	this code comes courtesy of Alex Denning from wpshout.com who based his off of the Arras and MiniBlog themes.  you can read all about it here:
	http://wpshout.com/create-an-awesome-wordpress-theme-options-page-part-1/
*/
function mytheme_add_admin() {

    global $themename, $shortname, $options;

    if ( $_GET['page'] == basename(__FILE__) ) {

        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                header("Location: themes.php?page=functions.php&saved=true");
                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($options as $value) {
                delete_option( $value['id'] ); }

            header("Location: themes.php?page=functions.php&reset=true");
            die;

        }
    }

    add_theme_page($themename." Options", "".$themename." Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');

}

function mytheme_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';

?>
<div class="wrap" style="margin:0 auto; padding:20px 0px 0px;">

<form method="post">

<?php foreach ($options as $value) {
switch ( $value['type'] ) {

case "open":
?>
<div style="width:808px; background:#eee; border:1px solid #ddd; padding:20px; overflow:hidden; display: block; margin: 0px;">

<?php break;

case "close":
?>

</div>

<?php break;

case "clear";
?>
<div style="clear: both;"></div>
<?php break;

case "misc":
?>
<div style="width:808px; display: block; margin: 0px;">
	<?php echo $value['name']; ?>
</div>
<?php break;

case "title":
?>

<div style="width:810px; margin:0px; font-weight:normal;">
	<?php echo $value['name']; ?>
</div>

<?php break;

case 'text':
?>

<div style="width:808px; padding:0px 0px 10px; margin:0px 0px 10px; border-bottom:1px solid #ddd; overflow:hidden;">
	<span style="font-family:Arial, sans-serif; font-size:16px; font-weight:bold; color:#444; display:block; padding:5px 0px;">
		<?php echo $value['name']; ?>
	</span>
	<?php if ($value['image'] != "") {?>
		<div style="width:808px; padding:10px 0px; overflow:hidden;">
			<img style="padding:5px; background:#FFF; border:1px solid #ddd;" src="<?php bloginfo('template_url');?>/images/<?php echo $value['image'];?>" alt="image" />
		</div>
	<?php } ?>
	<input style="width:200px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'] )); } else { echo stripslashes($value['std']); } ?>" />
	<br/>
	<span style="font-family:Arial, sans-serif; font-size:11px; font-weight:bold; color:#444; display:block; padding:5px 0px;">
		<?php echo $value['desc']; ?>
	</span>
</div>

<?php
break;

case 'text2':
?>

<div style="width:380px; padding:0px 0px 10px; margin:0px 5px 10px 5px; overflow:hidden; float: left;">
	<span style="font-family:Arial, sans-serif; font-size:16px; font-weight:bold; color:#444; display:block; padding:5px 0px;">
		<?php echo $value['name']; ?>
	</span>
	<?php if ($value['image'] != "") {?>
		<div style="width:380px; padding:10px 0px; overflow:hidden;">
			<img style="padding:5px; background:#FFF; border:1px solid #ddd;" src="<?php bloginfo('template_url');?>/images/<?php echo $value['image'];?>" alt="image" />
		</div>
	<?php } ?>
	<input style="width:200px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'] )); } else { echo stripslashes($value['std']); } ?>" />
	<br/>
	<span style="font-family:Arial, sans-serif; font-size:11px; font-weight:bold; color:#444; display:block; padding:5px 0px;">
		<?php echo $value['desc']; ?>
	</span>
</div>

<?php
break;

case 'textarea':
?>

<div style="width:808px; padding:0px 0px 10px; margin:0px 0px 10px; border-bottom:1px solid #ddd; overflow:hidden;">
	<span style="font-family:Arial, sans-serif; font-size:16px; font-weight:bold; color:#444; display:block; padding:5px 0px;">
		<?php echo $value['name']; ?>
	</span>
	<?php if ($value['image'] != "") {?>
		<div style="width:808px; padding:10px 0px; overflow:hidden;">
			<img style="padding:5px; background:#FFF; border:1px solid #ddd;" src="<?php bloginfo('template_url');?>/images/<?php echo $value['image'];?>" alt="image" />
		</div>
	<?php } ?>
	<textarea name="<?php echo $value['id']; ?>" style="width:400px; height:200px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'] )); } else { echo stripslashes($value['std']); } ?></textarea>
	<br/>
	<span style="font-family:Arial, sans-serif; font-size:11px; font-weight:bold; color:#444; display:block; padding:5px 0px;">
		<?php echo $value['desc']; ?>
	</span>
</div>

<?php
break;
/*Ralph Damiano*/
case 'select':
?>

<div style="width:808px; padding:0px 0px 10px; margin:0px 0px 10px; border-bottom:1px solid #ddd; overflow:hidden;">
	<span style="font-family:Arial, sans-serif; font-size:16px; font-weight:bold; color:#444; display:block; padding:5px 0px;">
		<?php echo $value['name']; ?>
	</span>
	<?php if ($value['image'] != "") {?>
		<div style="width:808px; padding:10px 0px; overflow:hidden;">
			<img style="padding:5px; background:#FFF; border:1px solid #ddd;" src="<?php bloginfo('template_url');?>/images/<?php echo $value['image'];?>" alt="image" />
		</div>
	<?php } ?>
	<select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select>
	<br/>
	<span style="font-family:Arial, sans-serif; font-size:11px; font-weight:bold; color:#444; display:block; padding:5px 0px;">
		<?php echo $value['desc']; ?>
	</span>
</div>

<?php
break;

case "checkbox":
?>

<div style="width:808px; padding:0px 0px 10px; margin:0px 0px 10px; border-bottom:1px solid #ddd; overflow:hidden;">
	<span style="font-family:Arial, sans-serif; font-size:16px; font-weight:bold; color:#444; display:block; padding:5px 0px;">
		<?php echo $value['name']; ?>
	</span>
	<?php if ($value['image'] != "") {?>
		<div style="width:808px; padding:10px 0px; overflow:hidden;">
			<img style="padding:5px; background:#FFF; border:1px solid #ddd;" src="<?php bloginfo('template_url');?>/images/<?php echo $value['image'];?>" alt="image" />
		</div>
	<?php } ?>
	<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
	<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" style="float:left; margin-right: 10px;" value="true" <?php echo $checked; ?> />
	<span style="font-family:Arial, sans-serif; font-size:11px; font-weight:bold; color:#444; display:block;">
		<?php echo $value['desc']; ?>
	</span>
</div>


<?php
break;

case "background":
?>

<div style="width:245px; float:left; padding:0px 0px 10px; margin:0px 10px 10px 10px; border-bottom:1px solid #ddd; overflow:hidden;">
	<span style="font-family:Arial, sans-serif; font-size:16px; font-weight:bold; color:#444; display:block; padding:5px 0px;">
		<?php echo $value['name']; ?>
	</span>
	<?php if ($value['image'] != "") {?>
		<div style="width:808px; padding:10px 0px; overflow:hidden;">
			<img style="padding:5px; background:#FFF; border:1px solid #ddd;" src="<?php bloginfo('template_url');?>/images/<?php echo $value['image'];?>" alt="image" />
		</div>
	<?php } ?>
	<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
	<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" style="float:left; margin-right: 10px;" value="true" <?php echo $checked; ?> />
	<span style="font-family:Arial, sans-serif; font-size:11px; font-weight:bold; color:#444; display:block;">
		<?php echo $value['desc']; ?>
	</span>
</div>


<?php
break;

case "palette":
?>

<div style="width:300px; float:left; padding:0px 0px 10px; margin:0px 10px 10px 10px; border-bottom:1px solid #ddd; overflow:hidden;">
	<span style="font-family:Arial, sans-serif; font-size:16px; font-weight:bold; color:#444; display:block; padding:5px 0px;">
		<?php echo $value['name']; ?>
	</span>
	<?php if ($value['image'] != "") {?>
		<div style="width:808px; padding:10px 0px; overflow:hidden;">
			<img style="padding:5px; background:#FFF; border:1px solid #ddd;" src="<?php bloginfo('template_url');?>/images/<?php echo $value['image'];?>" alt="image" />
		</div>
	<?php } ?>
	<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
	<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" style="float:left; margin-right: 10px;" value="true" <?php echo $checked; ?> />
	<span style="font-family:Arial, sans-serif; font-size:11px; font-weight:bold; color:#444; display:block;">
		<?php echo $value['desc']; ?>
	</span>
</div>


<?php
break;

case "submit":
?>

<p class="submit">
<input name="save" type="submit" value="Save changes" />
<input type="hidden" name="action" value="save" />
</p>

<?php break;
}
}
?>


<p class="submit">
<input name="save" type="submit" value="Save changes" />
<input type="hidden" name="action" value="save" />
</p>
</form>
<form method="post">
<p class="submit">
<input name="reset" type="submit" value="Reset" />
<input type="hidden" name="action" value="reset" />
</p>
</form>

<?php
}

add_action('admin_menu', 'mytheme_add_admin');
/*End of Add a Theme Options Page*/

/*End of Theme Options =======================================*/

// this truncates post excerpts
	function the_content_limit($max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);

   if (strlen($_GET['p']) > 0) {
      echo "<p>";
      echo $content;
      echo "&nbsp;<a href='";
      the_permalink();
      echo "'>"."Read More &rarr;</a>";
      echo "</p>";
   }
   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
        $content = substr($content, 0, $espacio);
        $content = $content;
        echo "<p>";
        echo $content;
        echo "...";
        echo "&nbsp;<a href='";
        the_permalink();
        echo "'>".$more_link_text."</a>";
        echo "</p>";
   }
   else {
      echo "<p>";
      echo $content;
      echo "&nbsp;<a href='";
      the_permalink();
      echo "'>"."Read More &rarr;</a>";
      echo "</p>";
   }
}

?>
