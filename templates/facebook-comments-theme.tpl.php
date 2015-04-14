<?php
print '<div id="fb-root"></div>';
$facebook_script = '<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1' . $facebook_app_id_script . '
    fjs.parentNode.insertBefore(js, fjs);
  }(document, "script", "facebook-jssdk"));</script>';
print $facebook_script;
print '<div class="fb-comments" data-href="' . $url . '" data-width="' . $facebook_comments_block_settings_width . '" data-numposts="' . $facebook_comments_block_settings_number_of_posts . '" data-colorscheme="' . $facebook_comments_block_settings_color_schema . '"></div>';
