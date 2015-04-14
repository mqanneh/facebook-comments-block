<?php

/**
 * @file
 * Default theme implementation to display a facebook comments block.
 *
 * Available variables:
 * - $facebook: array contains all available variables.
 * - url: the page url.
 * - facebook_app_id: the facebook application id.
 * - facebook_app_id_script: javascript code to be appended to
 *   the fb script to include fb app id.
 * - facebook_comments_block_settings_width: The width of the plugin.
 * - facebook_comments_block_settings_number_of_posts: The number of comments
 *   to show by default.
 * - facebook_comments_block_settings_color_schema:
 *   The color scheme used by the plugin.
 */
?>

<div id="fb-root"></div>
<script>
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1<?php print $facebook['facebook_app_id_script']; ?>";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, "script", "facebook-jssdk"));
</script>
<div class="fb-comments" <?php print drupal_attributes($facebook['data_attributes']); ?>></div>
