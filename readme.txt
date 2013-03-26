=== Mixcloud Embed ===
Contributors: BJTliveset
Tags: mixcloud, html5, flash, player, shortcode, streaming
Requires at least: 3.5.1
Tested up to: 3.5.1
Stable tag: 1.4

The Mixcloud Embed plugin allows you to embed the Mixcloud player to your Wordpress blog or page.
This plugin can display a playlist of your mix or the cloudcast information.

== Description ==

The Mixcloud Embed plugin allows you to add the Mixcloud player into your WordPress blog or page, by using the [mixcloud] shortcode.

= Usage =

As default you only need to copy the URL of the song from Mixcloud you wish to add into your WordPress post or page, and past it between *[mixcloud]* and *[/mixcloud]*
 
`[mixcloud]http://www.mixcloud.com/artist-name/long-live-set-name/[/mixcloud]`

Make sure it's the permalink (*…com/artist-name/dj-set-or-live-name/*) instead of "*…com/bjtliveset/*". 

The optional parameters are height and width: 

`[mixcloud height="100" width="400"]http://www.mixcloud.com/artist-name/recorded-live-somewhere/[/mixcloud]`

If you want display a cloudcast profile you must add the parameter profile with value true

`[mixcloud profile="true"]http://www.mixcloud.com/BJT/[/mixcloud]`

This shortcode display a cloudcast profile BJT.

= Parameters =

This version accepts the following parameters:

*	Height:     integer value
*	Width:      integer value
*   Iframe:     boolean value
*   Playlist:   boolean value
*   Profile:    boolean value

= Examples =

`[mixcloud]http://www.mixcloud.com/BJT/bjt-liveset-minimal-part1/[/mixcloud]`

`[mixcloud height="100" width="400"]http://www.mixcloud.com/BJT/bjt-djset-1/[/mixcloud]`

`[mixcloud iframe="true"]http://www.mixcloud.com/BJT/bjt-liveset-techno-part1/[/mixcloud]`

`[mixcloud iframe="false"]http://www.mixcloud.com/BJT/live-set-10-short/[/mixcloud]`

`[mixcloud playlist="true"]http://www.mixcloud.com/BJT/live-set-10-short/[/mixcloud]`

`[mixcloud profile="true"]http://www.mixcloud.com/BJT/[/mixcloud]`

== Installation ==

This section describes how to install the plugin and get it working.

1. Download `mixcloud-embed.zip` and unzip it.
2. Upload the folder 'mixcloud-shortcode' to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Place [mixcloud]link goes here[/mixcloud] in your post or page

== Frequently Asked Questions ==

The Mixcloud Embed plugin allows you to embed the Mixcloud player to your WordPress blog or page.

= Usage =

As default you only need to copy the URL of the song from Mixcloud you wish to add into your WordPress post or page, and past it between *[mixcloud]* and *[/mixcloud]*
 
`[mixcloud]http://www.mixcloud.com/artist-name/long-live-set-name/[/mixcloud]`

Make sure it's the permalink (*…com/artist-name/dj-set-or-live-name/*) instead of "*…com/bjtliveset/*". 

The optional parameters are height and width: 

`[mixcloud height="100" width="400"]http://www.mixcloud.com/artist-name/recorded-live-somewhere/[/mixcloud]`

The optional parameters are playlist. This parameter allow you to publish on your blog the playlist of the mixcloud selected.

`[mixcloud playlist="true"]http://www.mixcloud.com/BJT/live-set-10-short/[/mixcloud]`

If you want display a cloudcast profile you must add the parameter profile with value true

`[mixcloud profile="true"]http://www.mixcloud.com/BJT/[/mixcloud]`

This shortcode display a cloudcast profile BJT.

= Parameters =

The first version accepts the following parameters:

*	Height:     integer value
*	Width:      integer value
*   Iframe:     boolean value
*   Playlist:   boolean value
*   Profile:    boolean value

= Examples =

`[mixcloud]http://www.mixcloud.com/BJT/bjt-liveset-minimal-part1/[/mixcloud]`

`[mixcloud height="100" width="400"]http://www.mixcloud.com/BJT/bjt-djset-1/[/mixcloud]`

`[mixcloud iframe="true"]http://www.mixcloud.com/BJT/bjt-liveset-techno-part1/[/mixcloud]`

`[mixcloud iframe="false"]http://www.mixcloud.com/BJT/live-set-10-short/[/mixcloud]`

`[mixcloud playlist="true"]http://www.mixcloud.com/BJT/live-set-10-short/[/mixcloud]`

`[mixcloud profile="true"]http://www.mixcloud.com/BJT/[/mixcloud]`

== Screenshots ==
1. Mixcloud player on a post

== Changelog ==

= 1.4 =
* The cloudcast profile was trasformed in a widget for a widget bar

= 1.3 =
* View a cloudcast profile information

= 1.2.1 =
* Fix bug on the logic of enabled/disabled parameters

= 1.2 =
* Added the function to retrieve a playlist

= 1.1 =
* Setting a default value from admin menu

= 1.0.2 =
* Fix a readme text


= 1.0 =
* First version
