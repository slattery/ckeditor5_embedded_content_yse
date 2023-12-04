<?php

namespace Drupal\ckeditor5_embedded_content_yse\Plugin\EmbeddedContent;

use Drupal\ckeditor5_embedded_content\EmbeddedContentInterface;
use Drupal\ckeditor5_embedded_content\EmbeddedContentPluginBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Plugin iframes.
 *
 * @EmbeddedContent(
 *   id = "alert_block",
 *   label = @Translation("Alert Bloc"),
 *   description = @Translation("Renders an alert block with title, copy, and optional link."),
 * )
 */
class AlertBlock extends EmbeddedContentPluginBase implements EmbeddedContentInterface {

  const RIGHT = 'align-right';

  const FULL = 'align-center';

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'decorator' => NULL,
      'title' => NULL,
      'wysiwyg' => NULL,
      'href' => NULL,
      'linktext' => NULL,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    return [
      '#theme' => 'ckeditor5_embedded_content_alert_block',
      '#decorator' =>  $this->configuration['decorator'],
      '#title' =>  $this->configuration['title'],
      '#wysiwyg' => [
        '#type' => 'processed_text',
        '#text' => $this->configuration['wysiwyg']['value'],
        '#format' => $this->configuration['wysiwyg']['format'],
      ],
      '#href' =>  $this->configuration['href'],
      '#linktext' =>  $this->configuration['linktext'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['decorator'] = [
      '#type' => 'select',
      '#title' => $this->t('Style'),
      '#options' => [
        self::RIGHT => $this->t('align-right'),
        self::FULL => $this->t('align-center'),
      ],
      '#default_value' => $this->configuration['decorator'],
    ];
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $this->configuration['title'],
      '#required' => FALSE,
    ];
    $form['wysiwyg'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Copy'),
      '#format' => $this->configuration['wysiwyg']['format'] ?? 'basic_html',
      '#default_value' => $this->configuration['wysiwyg']['value'] ?? '',
      '#required' => FALSE,
    ];
    $form['href'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Link URL'),
      '#default_value' => $this->configuration['href'],
      '#required' => FALSE,
    ];
    $form['linktext'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Link text'),
      '#default_value' => $this->configuration['linktext'],
      '#required' => FALSE,
    ];
    return $form;
  }

}
