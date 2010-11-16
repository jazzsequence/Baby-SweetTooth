/* addRainbowToElement 
 *
 * Add a little color picker to 'name' (which should be an input).
 */

function addRainbowToElement (name) {
  var elt = $(name);
  if (elt) {
    var par = elt.parentNode;
    var img = document.createElement ('img');
    img.src = "/wp-content/themes/babysweettooth/ttftitles/images/colorpicker.png";
    img.id = name + 'icon';
    img.style.paddingBottom = '2px';
    img.injectAfter(elt);
    
    var rb = new MooRainbow (img.id, {
      id:         name + 'picker',
      imgPath:    '/wp-content/themes/babysweettooth/ttftitles/js/images/',
      onComplete: function (color) { elt.value = color.hex; },
    });
    rb.manualSet(elt.value, 'hex');
    elt.addEvent('change', function () { rb.manualSet(this.value,'hex'); });
  }
}





/* addHelpToElement 
 *
 * Adds contextual help with a little slider thing to 'name'.
 */

function addHelpToElement (name, title, body) {
  var elt = $(name);
  if (elt) {
    var helpbox = document.createElement ('div');
    helpbox.className = 'hiddenhelp';
    helpbox.id = name + 'help';
    helpbox.innerHTML = '<h3>' + title + '</h3>' + body;
    helpbox.style.marginLeft = '0px';
    helpbox.style.marginRight = '0px';
    helpbox.style.marginTop = '0px';
    helpbox.style.marginBottom = '0px';

    var img = document.createElement ('img');
    img.src = "/wp-content/themes/babysweettooth/ttftitles/images/help.png";
    img.id = name + 'icon';
    img.title = 'open/close help for "' + title + '"';
    img.style.paddingBottom = '3px';

    img.injectAfter(elt);
    helpbox.injectAfter(elt.parentNode);

    var slider = new Fx.Slide(helpbox,{wait: false, duration: 250}).hide();
    helpbox.slider = slider;
    img.addEvent('click', function (e) {
		   e = new Event(e);
		   $ES('.hiddenhelp').forEach(function(item,index) { if (item != helpbox) {item.slider.slideOut();}}, helpbox);
		   slider.toggle();
		   e.stop();
		 });
    left = elt.offsetLeft - elt.parentNode.offsetLeft;
    helpbox.parentNode.style.marginLeft   = left + 'px'; 
    if (elt.type != 'radio') {
      helpbox.parentNode.style.marginTop    = '-5px';
    }
    helpbox.marginBottom = '1px';
    helpbox.parentNode.style.marginBottom = '10px';
    helpbox.style.marginLeft = '0px';
    helpbox.style.clear = 'both';
  }
}



/* addRainbows
 *
 * Installs the necessary rainbows for ttftitles.
 */

function addRainbows () {
  addRainbowToElement ('bgcolor');
  addRainbowToElement ('fontcolor');
}



/* addHelp
 *
 * Installs the necessary help for ttftitles.
 */

function addHelp () {
  addHelpToElement ('cachedir', 'Cache Directory', "<p>The cache directory is where the generated images will actually be stored.  This directory must be writable by your web server process.  The easiest way is just to make it world writable with 'chmod 777'.</p>");

  addHelpToElement ('cacheurl', 'Cache URL', '<p>The cache URL is the URL to the cache as accessed over the web.  This will usually be something like <em>http://www.example.com/wp-content/themes/babysweettooth/ttftitles/cache/</em>.  If you move your cache directory, you probably need to change this as well.</p>');
  
  addHelpToElement ('cachelifetime', 'Cache Lifetime', '<p>To keep from cluttering up your server too much, old generated images are cleaned out on a regular basis.  The Cache Lifetime is how many days an imae is allowed to persist before being purged.</p>');
  
  addHelpToElement ('fontdir', 'Font Directory', "<p>The font directory is where the font files are stored.  If you want to be able top upload fonts through this interface, the font directory must be writable by your web server process.  The easiest way is just to make it world writable with 'chmod 777'.  If you don't want to use this upload interface, please feel free to ignore this part.</p>");
  
  addHelpToElement ('font_file', 'Font to Upload', "<p>This is the name of a TrueType or OpenType font file on your local machine.  These usually have an extension of .TTF or .OTF.  Don't upload PostScript fonts.  It wastes your time and annoys the plugin.</p>");
  
  addHelpToElement ('name', 'Style Name', '<p>This is the name of this style definition.  The name is used to tell TTFTitles which style definition to use.</p>');
  
  addHelpToElement ('imagetype', 'Image Type', "<p>This is the kind of image you want to use.  Unless you have a really important reason to use GIF, you should use PNG.</p>");
  
  addHelpToElement ('fontsize', 'Font Size', "<p>This is how large you want the text to appear.  Note that different fonts look larger or smaller even when their size is set to the same value.  This is due to the fonts, not to anything here.</p>");
  
  addHelpToElement ('font', 'Font Name', "<p>This is the font you want to use.  If there are no choices, you need to add some fonts to the font directory.</p>");
  
  addHelpToElement ('fontcolor', 'Font Color', '<p>This is the color you want your text to be.  It should be given as a hex value, just like in CSS.</p>');

  addHelpToElement ('lettercase', 'Letter Case', '<p>This is what case change, if any, you want to your text.  You can have it ALL UPPERCASE, all lowercase, Every Word Capitalized, or unchanged</p>');

  addHelpToElement ('bgcolor', 'Background Color', '<p>This is the color of your background.  Even if you want the background transparent, you still want to set this to be as close to your background as possible.  This will help around the edges of the letters and in any shadows.</p>');

  addHelpToElement ('bgtrans', 'Background Transparent', '<p>This is whether or not you want the background of your image to be transparent.  Even if you want the background transparent, you still want to set the background color to be as close to your background as possible.  This will help around the edges of the letters and in any shadows.</p>');

  addHelpToElement ('bgimage', 'Background Image', '<p>This is an image that will be tiled behind your text.  Useful if you have a complex background pattern that you want to have behind your text, albeit tricky to line up.  Future versions will include offsets which will make lining up waaaay easier.  Sorry.</p>');

  addHelpToElement ('indent', 'Left Indent', '<p>This is padding to the left of the text in the image.</p>');
  addHelpToElement ('subindent', 'Subindent', '<p>This is additional padding to the left of all but the first line of text.</p>');
  addHelpToElement ('maxwidth', 'Maximum Width', '<p>This is how wide text images are allowed to get.  If the text does not fit, it will be broken on word boundaries into multiple lines.  If you don\'t want to limit the width, use zero for the value or leave it blank.</p>');
  addHelpToElement ('leading', 'Leading', '<p>This is how much space to leave between lines of text.</p>');
  addHelpToElement ('effectnone', 'No Effect', '<p>This options leaves your text alone with a shadow or other effect.</p>');
  addHelpToElement ('effectsoft', 'Soft Shadow', '<p>This options gives your text a nice soft drop shadow.</p>');
  addHelpToElement ('effecthard', 'Hard Shadow', '<p>This options gives your text a harder shadow.</p>');
  addHelpToElement ('soft_shadow_color', 'Soft Shadow Color', '<p>This is the color of your soft shadow.  Use hex (e.g. #FF0000 or #F00 for red).</p>');
  addHelpToElement ('soft_shadow_spread', 'Soft Shadow Spread', '<p>This is the how spread out you want the soft shadow to be (i.e. how diffuse) in pixels.</p>');
  addHelpToElement ('soft_shadow_x_offset', 'Soft Shadow X Offset', '<p>This is the how far you want the shadow offset from the original text horizontally in pixels.</p>');
  addHelpToElement ('soft_shadow_y_offset', 'Soft Shadow Y Offset', '<p>This is the how far you want the shadow offset from the original text vertically in pixels.</p>');
  addHelpToElement ('hard_shadow_color_1', 'Hard Shadow Outer Color', '<p>This is the color of the outer part of the hard shadow.  Use hex (e.g. #888 or #888888 for a medium gray).</p>');
  addHelpToElement ('hard_shadow_color_2', 'Hard Shadow Inner Color', '<p>This is the color of the inner part of the hard shadow.  Use hex (e.g. #FFF or #FFFFFF for white).</p>');
  addHelpToElement ('hard_shadow_offset', 'Hard Shadow Offset', '<p>This is the width of each part of the hard shadow in pixels.</p>');



}




/* And finally we set it all to start when the DOM is ready for us. */

window.addEvent('domready', function() {
		  addHelp();
		  addRainbows();
		});
