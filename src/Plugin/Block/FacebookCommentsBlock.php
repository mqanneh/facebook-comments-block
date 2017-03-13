<?php

/**
 * @file
 * Contains \Drupal\facebook_comments_block\Plugin\Block\FacebookCommentsBlock.
 */

namespace Drupal\facebook_comments_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Template\Attribute;

/**
 * Provides a 'Facebook Comments Block' block.
 *
 * Drupal\Core\Block\BlockBase gives us a very useful set of basic functionality
 * for this configurable block. We can just fill in a few of the blanks with
 * defaultConfiguration(), blockForm(), blockSubmit(), and build().
 *
 * @Block(
 *   id = "facebook_comments_block",
 *   admin_label = @Translation("Facebook Comments Block"),
 *   category = @Translation("Social")
 * )
 */
class FacebookCommentsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['facebook_comments_settings'] = array(
        '#type' => 'fieldset',
        '#title' => $this->t('Facebook comments box settings'),
        '#description' => $this->t('Configure facebook comments box.'),
        '#collapsible' => FALSE,
      );
      $form['facebook_comments_settings']['facebook_comments_block_settings_app_id'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('Facebook Application ID'),
        '#default_value' => isset($config['facebook_comments_block_settings_app_id']) ? $config['facebook_comments_block_settings_app_id'] : '',
        '#maxlength' => 20,
        '#description' => $this->t('Optional: Enter Facebook App ID.'),
      );
      $form['facebook_comments_settings']['facebook_comments_block_settings_domain'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('Main domain'),
        '#default_value' => isset($config['facebook_comments_block_settings_domain']) ? $config['facebook_comments_block_settings_domain'] : '',
        '#maxlength' => 75,
        '#description' => $this->t('Optional: If you have more than one domain you can set the main domain for facebook comments box to use the same commenting widget across all other domains.<br />ex: <i>http://www.mysite.com</i>'),
        '#required' => FALSE,
      );
      $form['facebook_comments_settings']['facebook_comments_block_settings_color_schema'] = array(
        '#type' => 'select',
        '#title' => $this->t('Color scheme'),
        '#options' => array(
          'light' => $this->t('Light'),
          'dark' => $this->t('Dark'),
        ),
        '#default_value' => isset($config['facebook_comments_block_settings_color_schema']) ? $config['facebook_comments_block_settings_color_schema'] : 'light',
        '#description' => $this->t('Set the color schema of facebook comments box.'),
        '#required' => TRUE,
      );
      $form['facebook_comments_settings']['facebook_comments_block_settings_order'] = array(
        '#type' => 'select',
        '#title' => $this->t('Order of comments'),
        '#options' => array(
          'social' => t('Top'),
          'reverse_time' => t('Newest'),
          'time' => t('Oldest'),
        ),
        '#default_value' => isset($config['facebook_comments_block_settings_order']) ? $config['facebook_comments_block_settings_order'] : 'social',
        '#description' => $this->t('Set the order of comments.'),
        '#required' => TRUE,
      );
      $form['facebook_comments_settings']['facebook_comments_block_settings_number_of_posts'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('Number of posts'),
        '#default_value' => isset($config['facebook_comments_block_settings_number_of_posts']) ? $config['facebook_comments_block_settings_number_of_posts'] : '5',
        '#maxlength' => 3,
        '#description' => $this->t('Select how many posts you want to display by default.'),
        '#required' => TRUE,
      );
      $form['facebook_comments_settings']['facebook_comments_block_settings_width'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('Width'),
        '#default_value' => isset($config['facebook_comments_block_settings_width']) ? $config['facebook_comments_block_settings_width'] : '500',
        '#maxlength' => 4,
        '#description' => $this->t('Set width of facebook comments box.'),
        '#required' => TRUE,
      );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('facebook_comments_block_settings_app_id', $form_state->getValue(array('facebook_comments_settings', 'facebook_comments_block_settings_app_id')));
    $this->setConfigurationValue('facebook_comments_block_settings_domain', rtrim(rtrim($form_state->getValue(array('facebook_comments_settings', 'facebook_comments_block_settings_domain'))), '/'));
    $this->setConfigurationValue('facebook_comments_block_settings_color_schema', $form_state->getValue(array('facebook_comments_settings', 'facebook_comments_block_settings_color_schema')));
    $this->setConfigurationValue('facebook_comments_block_settings_order', $form_state->getValue(array('facebook_comments_settings', 'facebook_comments_block_settings_order')));
    $this->setConfigurationValue('facebook_comments_block_settings_number_of_posts', $form_state->getValue(array('facebook_comments_settings', 'facebook_comments_block_settings_number_of_posts')));
    $this->setConfigurationValue('facebook_comments_block_settings_width', $form_state->getValue(array('facebook_comments_settings', 'facebook_comments_block_settings_width')));
  }

  /**
   * {@inheritdoc}
   */
  public function blockValidate($form, FormStateInterface $form_state) {
    $main_domain = $form_state->getValue(array('facebook_comments_settings', 'facebook_comments_block_settings_domain'));
    if ($main_domain !== '' && (!UrlHelper::isValid($main_domain, TRUE))) {
     drupal_set_message($this->t('Main domain must be a valid absolute URL.'), 'error');
     $form_state->setErrorByName('facebook_comments_block_settings_domain', $this->t('Main domain must be a valid absolute URL.'));
    }

    $number_of_posts = $form_state->getValue(array('facebook_comments_settings', 'facebook_comments_block_settings_number_of_posts'));
    if (!is_numeric($number_of_posts)) {
     drupal_set_message($this->t('Number of posts must be a valid number.'), 'error');
     $form_state->setErrorByName('facebook_comments_block_settings_domain', $this->t('Number of posts must be a valid number.'));
    }

    $width = $form_state->getValue(array('facebook_comments_settings', 'facebook_comments_block_settings_width'));
    if (!is_numeric($width)) {
     drupal_set_message($this->t('Width must be a valid number.'), 'error');
     $form_state->setErrorByName('facebook_comments_block_settings_domain', $this->t('Width must be a valid number.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    global $base_url;
    $config = $this->getConfiguration();
    $current_unaliased_path = \Drupal::service('path.current')->getPath();

    $main_domain = $base_url;
    if ($config['facebook_comments_block_settings_domain'] !== '') {
      $main_domain = $config['facebook_comments_block_settings_domain'];
    }

    $url = $main_domain . $current_unaliased_path;

    $facebook_app_id = $config['facebook_comments_block_settings_app_id'];
    $facebook_app_id_script = ($facebook_app_id != '') ? "&appId=$facebook_app_id" : '';

    $js_vars = array(
      'facebook_app_id_script' => $facebook_app_id_script,
    );

    $theme_vars = array(
      'data_attributes' => array(
        'href' => $url,
        'data-href' => $url,
        'data-width' => $config['facebook_comments_block_settings_width'],
        'data-numposts' => $config['facebook_comments_block_settings_number_of_posts'],
        'data-colorscheme' => $config['facebook_comments_block_settings_color_schema'],
        'data-order-by' => $config['facebook_comments_block_settings_order'],
      ),
    );

    return array(
      '#cache' => array(
        'contexts' => array('url'),
      ),
      '#theme' => 'facebook_comments_block_block',
      '#data_attributes' => new Attribute($theme_vars['data_attributes']),
      '#attached' => array(
        'library' =>  array(
          'facebook_comments_block/facebook-comments-block',
        ),
        'drupalSettings' => array(
          'facebook_comments_block_settings' => $js_vars,
        ),
      ),
    );
  }

}
