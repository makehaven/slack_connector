<?php

namespace Drupal\slack_connector\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Slack Connector settings.
 */
class SlackConnectorSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'slack_connector_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['slack_connector.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('slack_connector.settings');

    $form['webhook_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Slack Webhook URL'),
      '#default_value' => $config->get('webhook_url'),
      '#description' => $this->t('Enter your Slack webhook URL.'),
      '#required' => TRUE,
    ];

    // Add a test button.
    $form['test_slack'] = [
      '#type' => 'submit',
      '#value' => $this->t('Test Slack Connection'),
      '#submit' => ['::testSlackConnectionSubmit'],
      '#ajax' => [
        'callback' => '::testSlackConnectionAjaxCallback',
        'wrapper' => 'slack-connector-settings-form',
      ],
    ];

    $form['#prefix'] = '<div id="slack-connector-settings-form">';
    $form['#suffix'] = '</div>';

    return parent::buildForm($form, $form_state);
  }

  /**
   * AJAX callback for testing Slack connection.
   */
  public function testSlackConnectionAjaxCallback(array &$form, FormStateInterface $form_state) {
    return $form;
  }

  /**
   * Custom submit handler for testing Slack connection.
   */
  public function testSlackConnectionSubmit(array &$form, FormStateInterface $form_state) {
    $webhook_url = $form_state->getValue('webhook_url');

    // Prepare a test payload for channel #testing.
    $payload = [
      'channel' => '#testing',
      'text' => 'Test message from Slack Connector module.',
    ];

    try {
      $client = \Drupal::httpClient();
      $response = $client->post($webhook_url, [
        'headers' => ['Content-Type' => 'application/json'],
        'json' => $payload,
      ]);
      $result = $response->getBody()->getContents();
      \Drupal::messenger()->addMessage($this->t('Test message posted to #testing. Response: @response', [
        '@response' => $result,
      ]));
    }
    catch (\Exception $e) {
      \Drupal::messenger()->addMessage($this->t('Error posting test message: @error', [
        '@error' => $e->getMessage(),
      ]), 'error');
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('slack_connector.settings')
      ->set('webhook_url', $form_state->getValue('webhook_url'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
