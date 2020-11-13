<?php

namespace Drupal\jokes_api\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block
 *
 * @Block(
 *   id = "jokes_api_block",
 *   admin_label = @Translation("Jokes API block"),
 * )
 */
class JokesApi extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function build() {

    // get existing configuration for this block
    $config = $this->getConfiguration();

    // build the API URL for the fetch JS call
    $apiUrl = "https://sv443.net/jokeapi/v2/joke/Programming,Pun?blacklistFlags=nsfw,religious,political,racist,sexist&type=single&amount={$config['output_limit']}";

    // build an array of data to send to the JS file
    $data = [];
    $data['apiUrl'] = $apiUrl;
    $data['config'] = $config;

    // build/return the render array
    return [
      '#apiblock' => $data,
      '#markup' => '<div id="jokes"></div>',
      '#attached' => [
        'library' => ['jokes_api/jokesapi'],
        'drupalSettings' => [
          'apiconfig' => $data,
        ],
      ],
    ];

  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account, $return_as_object = FALSE) {

    return AccessResult::allowedIfHasPermission($account, 'access content');
  
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $form = parent::blockForm($form, $form_state);

    // get existing configuration for this block
    $config = $this->getConfiguration();

    // Add a form field to the existing block config form
    $form['output_limit'] = [
      '#type' => 'textfield',
      '#title' => t('Output Limit'),
      '#default_value' => isset($config['output_limit']) ? $config['output_limit'] : '',
    ];

    return $form;

  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {

    // save custom settings when the form is submitted
    $this->setConfigurationValue('output_limit', $form_state->getValue('output_limit'));
    $this->configuration['jokes_api_settings'] = $form_state->getValue('jokes_api_settings');

  }

  /**
   * {@inheritdoc}
   */
  public function blockValidate($form, FormStateInterface $form_state) {

    $output_limit = $form_state->getValue('output_limit');

    // validate the input; needs a numeric value between 1 and 10
    if (!is_numeric($output_limit)) {
      $form_state->setErrorByName('output_limit', t('Needs to be an integer!'));
    }
    if ($output_limit < 1) {
      $form_state->setErrorByName('output_limit', t('Needs to be greater than zero!'));
    }
    if ($output_limit > 10) {
      $form_state->setErrorByName('output_limit', t('Max allowed is 10!'));
    }

  }

}