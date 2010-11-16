=== TTF Titles ===
Contributors: jrrl
Tags: titles, fonts, images
Requires at least: 1.5.2
Tested up to: 2.3.1
Stable tag: trunk

This plugin provides two new template tags to replace plain text with
styled images.  


== Description ==

This plugin provides two new template tags to replace plain text with
styled text images using TrueType fonts.

This is primarily a reworking of the Image Headlines
plugin. Of course, *that* was a reworking of another plugin by Joel
Bennett.  The main changes over Brian's plugin are (a) a richer admin
interface, (b) the ability to predefine multiple image text styles,
and (c) using template tags instead of depending on arguments to
the_title.

Anything that works really well probably came from Brian's code.
Anything screwed up is probably my fault.


== Installation ==

When you unpack this plugin, you'll find two subdirectories of the
`ttftitles` directory.  These are the fonts and cache directory.  You
must have a writable cache directory.  If you chose to keep it inside
ttftitles, then make sure you 'chmod 777' the cache directory.  If you
move it, tell ttftitles the new location in the 
'Presentation/TTF Titles/Cache' admin page.

The fonts directory only has to be writable if you want to be able to
upload fonts through the admin page.  If you want to, then feel free
to 'chmod 777' that directory as well.  As with the cache directory,
you can move it elsewhere if you really feel the need.  Just update
the location in 'Presentation/TTF Titles/Fonts'.

Note to users of Windows and other legacy operating systems: 
'chmod 777' is Unix-speak for making something world-writable.  Please
substitute whatever your OS requires instead.

== Fonts ==

I have included a few fonts to get you started.  First is Warp 1 by
Alex Gollner. This is the one included with Image Headlines, so it
seemed like a good one to include.  See more at [Alex's Website](http://www.project.com/alex/fonts/index.html).

Next are the two Qlassik fonts by Dimitri Castrique.  His site is
currently in disrepair, but the fonts are quite nice.  You *may* be able
to find out more at [his currently dead website](http://www.thebend.be/).

The last is New Order Movement by [Peter Saville](http://www.btinternet.com/~comme6/saville/index222.htm).  This is a
nice art deco headline font.


== Further Instructions ==

Instructions are available at the [TTFTitles Homepage](http://templature.com/2007/10/18/ttftitles-wordpress-plugin/).

== License ==

I dunno.  How about creative commons attribution?  Sound ok?  Good.

