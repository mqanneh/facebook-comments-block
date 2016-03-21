/**
 * @file
 * Facebook comments block module related scripts.
 */

(function ($, Drupal, drupalSettings) {

  'use strict';

  Drupal.behaviors.FacebookCommentsBlock = {};
  Drupal.behaviors.FacebookCommentsBlock.attach = function () {
    if (drupalSettings && drupalSettings.facebook_comments_block_settings) {
      var facebook_app_id_script = drupalSettings.facebook_comments_block_settings.facebook_app_id_script;
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5" + facebook_app_id_script;
        fjs.parentNode.insertBefore(js, fjs);
      }(document, "script", "facebook-jssdk"));
    }
  };

})(jQuery, Drupal, drupalSettings);
