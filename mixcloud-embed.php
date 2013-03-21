<?php
/*
Plugin Name: Mixcloud Embed
Plugin URI: http://www.bjtliveset.com/
Description: MixCloud Shortcode for posts and pages. Defaut usage: [mixcloud]http://www.mixcloud.com/artist-name/long-live-set-name/[/mixcloud]. Make sure it's the track permalink (...com/artist-name/dj-set-or-live-name/) instead of "...com/player/". Optional parameters: height and width. [mixcloud height="100" width="400"]http://www.mixcloud.com/artist-name/recorded-live-somewhere/[/mixcloud]. The slash at the end is necessary.
Version: 1.3
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
        private $table_name;
        private $wpdb;

        function mixcloudEmbed()
        {
            //constructor
            global $wpdb;
            $this->wpdb = $wpdb;
            $this->errors = new WP_Error();
            $this->table_name = $this->wpdb->prefix . "mixcloudPlaylist";
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


            // read if there are a default value or a customizated value
            $atts = array(
                'height' => ($atts["height"] != "") ? $atts["height"] : $this->getOption("player_height"),
                'width' => ($atts["width"] != "") ? $atts["width"] : $this->getOption("player_width"),
                'color' => ($atts["color"] != "") ? $atts["color"] : $this->getOption("player_color"),
                'iframe' => ($atts["iframe"] != "") ? $atts["iframe"] : $this->getOption("player_iframe"),
                'playlist' => ($atts["playlist"] != "") ? $atts["playlist"] : $this->getOption("player_playlist"),
                'profile' => ($atts["profile"] != "") ? $atts["profile"] : $this->getOption("widget_profile"),
            );

            // clear a width or height value
            $atts["width"] = str_replace("px", "", $atts["width"]);
            $atts["height"] = str_replace("px", "", $atts["height"]);

            // the content are required
            if ($content == "") {
                $this->errors->add('no_url', __('The url to mixcloud stream are required!'));
            }

            if ($atts["profile"] == "true") {
                $code = $this->makeProfileWidget($atts, $content);
            } else {
                $code = $this->makeEmbedWidget($atts, $content);
            }

            return $code;
        }

        function makeEmbedWidget($atts, $content)
        {
            $playlistCode = "";
            if ($atts["iframe"] !== "false") {
                $code = "<iframe width='" . $atts["width"] . "' height='" . $atts["height"] . "' src='//www.mixcloud.com/widget/iframe/?feed=$content&embed_uuid=4743a4fe-c254-4cb4-a49e-bf2d6d1e8d94&stylecolor=" . $atts['color'] . "&embed_type=widget_standard' frameborder='0'></iframe>";
            } else {
                $code = "<object width='" . $atts["width"] . "' height='" . $atts["height"] . "'><param name='movie' value='//www.mixcloud.com/media/swf/player/mixcloudLoader.swf?feed=$content&embed_uuid=c4579e14-9570-4cce-9f7a-97c1f9e17929&stylecolor=" . $atts["color"] . "&embed_type=widget_standard'></param><param name='allowFullScreen' value='true'></param><param name='wmode' value='opaque'></param><param name='allowscriptaccess' value='always'></param><embed src='//www.mixcloud.com/media/swf/player/mixcloudLoader.swf?feed=$content&embed_uuid=c4579e14-9570-4cce-9f7a-97c1f9e17929&stylecolor=" . $atts["color"] . "&embed_type=widget_standard' type='application/x-shockwave-flash' wmode='opaque' allowscriptaccess='always' allowfullscreen='true' width='" . $atts["width"] . "' height='" . $atts["height"] . "'></embed></object>";
            }

            if ($atts["playlist"] != "false") {
                // get a playlist information
                $playlistCode = $this->getPlaylist($content);
            }

            if (sizeof($this->errors->get_error_messages()) > 0) {
                $code = "<b>##############<br/>Cannot generate a Mixcloud Embed because: <ul>";
                for ($i = 0; $i < sizeof($this->errors->get_error_messages()); $i++) {
                    $code .= "<li>" . $this->errors->get_error_message("no_url") . "</li>";
                }
                $code .= "</ul>##############</b>";
            }
            return $code . $playlistCode;
        }

        function makeProfileWidget($atts, $content)
        {
            $explode = explode("/", $content);
            $profile = $explode[0] . "//" . $explode[2] . "/" . $explode[3] . "/";
            $code = '<a class="mixcloud-follow-widget" href="' . $profile . '" data-h="' . $atts["height"] . '"  data-w="' . $atts["width"] . '" data-faces="on">Follow '.$explode[3].' on Mixcloud</a><script type="text/javascript" src="http://widget.mixcloud.com/media/js/follow_embed.js"></script>';
            return $code;
        }

        function getPlaylist($url)
        {
            // extract a array with a playlist of tracks
            $playlist = array();
            // if the playlist are saved to db, i load it from db
            $playlist = $this->wpdb->get_row("SELECT ID, url, playlist FROM " . $this->table_name . " WHERE url = '" . $url . "'");
            if ($this->wpdb->num_rows > 0) {
                $playlist = unserialize($playlist->playlist);
            } else {
                $code = implode("", file($url));
                if ($code == "") $this->errors->add('no_content', __('The url $url are not valid!'));
                preg_match_all("/section-row-track(.+)/", $code, $results);
                for ($i = 0; $i < sizeof($results[0]); $i++) {
                    preg_match("/class=\"tracklisttrackname mx-link\">(.+)<\/a>/U", $results[0][$i], $match);
                    $title = $match[1];
                    preg_match("/class=\"tracklistartistname mx-link\">(.+)<\/a>/U", $results[0][$i], $match);
                    $artist = $match[1];
                    if ($title != "" || $artist != "") {
                        $playlist[] = array("title" => $title, "artist" => $artist);
                    }
                }

                $this->wpdb->show_errors();
                // save to db the playlist for this url
                $this->wpdb->insert($this->table_name, array("url" => $url, "playlist" => serialize($playlist)), array("%s", "%s"));
            }
            $code = "<h3>Playlist</h3><ul class='mixcloud-embed-playlist'>";
            for ($i = 0; $i < count($playlist); $i++) {
                $code .= "<li><span class='mixcloud-embed-position'>" . ($i + 1) . "</span>";
                $code .= "<span class='mixcloud-embed-artist'>" . $playlist[$i]["artist"] . "</span>";
                $code .= "<span class='mixcloud-embed-title'>" . $playlist[$i]["title"] . "</span></li>";

            }
            $code .= "</ul>";
            return $code;
        }

        function addCss()
        {
            wp_enqueue_style('mixcloud-embed', plugins_url('mixcloud-embed.css', __FILE__));
        }

        /**
         *  Connect the action to render the admin menu for mixcloud default settings
         */
        function hookOptionsMenu()
        {
            add_options_page('Mixcloud Embed Options', 'Mixcloud', 'manage_options', 'mixcloud-embed', array(&$this, 'adminOptionsMenu'));
            add_action('admin_init', array(&$this, 'registerMixcloudSettings'));

        }

        function jal_install()
        {
            global $jal_db_version;


            $sql = "CREATE TABLE " . $this->table_name . " (
              id mediumint(9) NOT NULL AUTO_INCREMENT,
              url VARCHAR(55) DEFAULT '' NOT NULL,
              playlist text NOT NULL,
              UNIQUE KEY id (id)
                );";


            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);

            add_option("jal_db_version", $jal_db_version);
        }


        function registerMixcloudSettings()
        {
            register_setting('mixcloud-embed-settings', 'mixcloud-embed_player_height');
            register_setting('mixcloud-embed-settings', 'mixcloud-embed_player_width ');
            register_setting('mixcloud-embed-settings', 'mixcloud-embed_player_iframe');
            register_setting('mixcloud-embed-settings', 'mixcloud-embed_player_color');
            register_setting('mixcloud-embed-settings', 'mixcloud-embed_player_playlist');
            register_setting('mixcloud-embed-settings', 'mixcloud-embed_widget_profile');
        }

        /**
         * Plugin options getter
         * @param  {string|array}  $option   Option name
         * @param  {mixed}         $default  Default value
         * @return {mixed}                   Option value
         */
        function getOption($option, $default = false)
        {
            $value = get_option('mixcloud-embed_' . $option);
            return $value === '' ? $default : $value;
        }


        /**
         * Generate the page to do a default setting
         */
        function adminOptionsMenu()
        {
            if (!current_user_can('manage_options')) {
                wp_die(__('You do not have sufficient permissions to access this page.'));
            }
            ?>
        <div class="wrap">
            <h2>Mixcloud Embed Default Settings</h2>

            <p>These settings will become the new defaults used by the Mixcloud Embed throughout your blog.</p>

            <p>You can always override these settings on a per-shortcode basis. Setting the 'params' attribute in a
                shortcode overrides these defaults individually.</p>

            <form method="post" action="options.php">
                <?php settings_fields('mixcloud-embed-settings'); ?>
                <table class="form-table">

                    <tr valign="top">
                        <th scope="row">Widget Type</th>
                        <td>
                            <input type="radio" id="player_iframe_true" name="mixcloud-embed_player_iframe" value="true"  <?php if (strtolower(get_option('mixcloud-embed_player_iframe')) === 'true') echo 'checked'; ?> />
                            <label for="player_iframe_true" style="margin-right: 1em;">HTML5 (Iframe)</label>
                            <input type="radio" id="player_iframe_false" name="mixcloud-embed_player_iframe" value="false" <?php if (strtolower(get_option('mixcloud-embed_player_iframe')) === 'false') echo 'checked'; ?> />
                            <label for="player_iframe_false" style="margin-right: 1em;">Flash (Object Tag)</label>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Player Height for Tracks</th>
                        <td>
                            <input type="text" name="mixcloud-embed_player_height" value="<?php echo get_option('mixcloud-embed_player_height'); ?>"/>
                            (px, or %)<br/>
                            Leave blank to use the default.
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Player Width</th>
                        <td>
                            <input type="text" name="mixcloud-embed_player_width" value="<?php echo get_option('mixcloud-embed_player_width'); ?>"/>
                            (px, or %)<br/>
                            Leave blank to use the default.
                        </td>
                    </tr>


                    <tr valign="top">
                        <th scope="row">Color</th>
                        <td>
                            <input type="text" name="mixcloud-embed_color" value="<?php echo get_option('mixcloud-embed_color'); ?>"/>
                            (color hex code e.g. ff6699)<br/>
                            Defines the color to paint the play button, waveform and selections.
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Playlist</th>
                        <td>
                            <input type="radio" id="player_playlist_true" name="mixcloud-embed_player_playlist" value="true"  <?php if (strtolower(get_option('mixcloud-embed_player_playlist')) === 'true') echo 'checked'; ?> />
                            <label for="player_playlist_true" style="margin-right: 1em;">Display playlist of the
                                mixcloud</label>
                            <input type="radio" id="player_playlist_false" name="mixcloud-embed_player_playlist" value="false" <?php if (strtolower(get_option('mixcloud-embed_player_playlist')) === 'false') echo 'checked'; ?> />
                            <label for="player_playlist_false" style="margin-right: 1em;">Don't display playlist</label>
                        </td>
                    </tr>

                </table>

                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>"/>
                </p>

            </form>
        </div>
        <?php
        }

    }

} //End class mixcloudShortcode
$obj_mixcloud = new mixcloudEmbed();


// If an instance of the $obj_mixcloud object was created, add shortcode 
if (isset($obj_mixcloud)) {

    register_activation_hook(__FILE__, array(&$obj_mixcloud, 'jal_install'));

    add_action('wp_print_styles', array(&$obj_mixcloud, 'addCss'));

    // Adding 'mixcloud' shortcode. & is necessary because we are calling a function inside the class.
    add_shortcode('mixcloud', array(&$obj_mixcloud, 'createShortcode'));

    // Adding a admin menu to do a default setting for the embed code
    add_action('admin_menu', array(&$obj_mixcloud, 'hookOptionsMenu'));


}




?>