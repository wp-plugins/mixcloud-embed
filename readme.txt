=== Mixcloud Embed ===
Contributors: BJTliveset
Tags: mixcloud, html5, flash, player, shortcode, streaming
Requires at least: 3.5.1
Tested up to: 3.5.1
Stable tag: 1.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Mixcloud Embed plugin allows you to embed the Mixcloud player with the playlist or put a widget with your Mixcloud account.

== Description ==

The Mixcloud Embed plugin allows you to add the Mixcloud player into your WordPress blog or page, by using the [mixcloud] shortcode.
You can also display a playlist of the cloudcast.
In the last version there is the possibility to use a widget on your sidebar for view your Mixcloud profile.

= Usage =

As default you only need to copy the URL of the song from Mixcloud you wish to add into your WordPress post or page, and past it between *[mixcloud]* and *[/mixcloud]*
 
`[mixcloud]http://www.mixcloud.com/artist-name/long-live-set-name/[/mixcloud]`

Make sure it's the permalink (*…com/artist-name/dj-set-or-live-name/*) instead of "*…com/bjtliveset/*". 

The optional parameters are height and width: 

`[mixcloud height="100" width="400"]http://www.mixcloud.com/artist-name/recorded-live-somewhere/[/mixcloud]`

If you want display a cloudcast profile you must add the parameter profile with value true

`[mixcloud profile="true"]http://www.mixcloud.com/BJT/[/mixcloud]`

If you want embed an entire playlist you must add the url of the playlist:

`[mixcloud]http://www.mixcloud.com/BJT/playlists/bjt-djset/[/mixcloud]`

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

`[mixcloud]http://www.mixcloud.com/BJT/playlists/bjt-djset/[/mixcloud]`

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


== Screenshots ==

1. Mixcloud player on a post.

== Changelog ==

= 1.6.3 =
* Fix a bug that closed a <?php tag to the end of the file.

= 1.6.2 =
* Fix a reported bug "Warning: Illegal string offset after updating server to latest PHP 5.4"

= 1.6.1 =
* Fix a reported bug "Doesn't escape ampersands and breaks XML (RSS)"

= 1.6 =
* Fix some bug and add the button to tinymce

= 1.5.1 =
* Fix a bug with a urlencode of the movie

= 1.5 =
* No changes for the users, but I have do a refactor for the all plugin

= 1.4.2 =
* Fixed an idiot bug

= 1.4.1 =
* Added the possibility to embed an entire playlist.

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