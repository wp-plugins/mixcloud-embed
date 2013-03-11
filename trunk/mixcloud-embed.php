<?php
/*
Plugin Name: Mixcloud Embed
Plugin URI: http://www.bjtliveset.com/
Description: MixCloud Shortcode for posts and pages. Defaut usage: [mixcloud]http://www.mixcloud.com/artist-name/long-live-set-name/[/mixcloud]. Make sure it's the track permalink (...com/artist-name/dj-set-or-live-name/) instead of "...com/player/". Optional parameters: height and width. [mixcloud height="100" width="400"]http://www.mixcloud.com/artist-name/recorded-live-somewhere/[/mixcloud]. The slash at the end is necessary.
Version: 1.0.2
Author: Domenico Biancardi <bjtliveset@gmail.com>
Author URI: http://www.bjtliveset.com

*/


/*
    Checking if a class named mixcloudShortcode exists to avoid
    naming collisions with other WordPress plugins.
*/
if (!class_exists("mixcloudEmbed")) {
    // If it doesn't exist, create mixcloudShortcode class
    class mixcloudEmbed
    {
        function mixcloudEmbed()
        {
            //constructor
        }

        /**
         * [mixcloud height="int value" width="int value" iframe="boolean value"]
         * The following function creates a "[mixcloud]" shortcode that supports two attributes: ["height" and "width"].
         * Both attributes are optional and will take on default options [height="300" width="300" iframe="true"] if they are not provided.
         * This shortcode handler function accepts two arguments:
         * $atts, an associative array of attributes
         * $content, the enclosed content (if the shortcode is used in its enclosing form)
         */
        function createShortcode($atts, $content = null)
        {
            extract(shortcode_atts(array(
                'height' => '300',
                'width' => '300',
                'color' => 'ffffff',
                'iframe' => 'true',
            ), $atts));

            if ($atts["iframe"]) {
                $code = "<iframe width='" . $atts["width"] . "' height='" . $atts["height"] . "' src='//www.mixcloud.com/widget/iframe/?feed=$content&embed_uuid=4743a4fe-c254-4cb4-a49e-bf2d6d1e8d94&stylecolor=" . $atts['color'] . "&embed_type=widget_standard' frameborder='0'></iframe>";
            } else {
                $code = "<object width='" . $atts["width"] . "' height='" . $atts["height"] . "'><param name='movie' value='//www.mixcloud.com/media/swf/player/mixcloudLoader.swf?feed=$content&embed_uuid=c4579e14-9570-4cce-9f7a-97c1f9e17929&stylecolor=" . $atts["color"] . "&embed_type=widget_standard'></param><param name='allowFullScreen' value='true'></param><param name='wmode' value='opaque'></param><param name='allowscriptaccess' value='always'></param><embed src='//www.mixcloud.com/media/swf/player/mixcloudLoader.swf?feed=$content&embed_uuid=c4579e14-9570-4cce-9f7a-97c1f9e17929&stylecolor=" . $atts["color"] . "&embed_type=widget_standard' type='application/x-shockwave-flash' wmode='opaque' allowscriptaccess='always' allowfullscreen='true' width='" . $atts["width"] . "' height='" . $atts["height"] . "'></embed></object>";
            }

            return $code;
        }

    }

} //End class mixcloudShortcode
$obj_mixcloud = new mixcloudEmbed();


// If an instance of the $obj_mixcloud object was created, add shortcode 
if (isset($obj_mixcloud)) {
    // Adding 'mixcloud' shortcode. & is necessary because we are calling a function inside the class.
    add_shortcode('mixcloud', array(&$obj_mixcloud, 'createShortcode'));
}

?>