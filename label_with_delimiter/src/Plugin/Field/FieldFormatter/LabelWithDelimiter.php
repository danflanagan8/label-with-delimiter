<?php

namespace Drupal\label_with_delimiter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Component\Utility\Html;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceLabelFormatter;
use Drupal\Core\Field\EntityReferenceFieldItemListInterface;
use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;



/**
 *
 * @FieldFormatter(
 *   id = "entity_reference_label_delimiter",
 *   label = @Translation("Label (with delimitter)"),
 *   description = @Translation("Display the labels of the referenced entities, separated by a delimiter."),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class LabelWithDelimiter extends EntityReferenceLabelFormatter {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'delimiter' => ',',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {

    $elements = parent::settingsForm($form, $form_state);

    $elements['delimiter'] = [
      '#title' => t('Delimiter'),
      '#type' => 'textfield',
      '#default_value' => $this->getSetting('delimiter'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();
    $summary[] = 'Delimiter: ' . $this->getSetting('delimiter');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function view(FieldItemListInterface $items, $langcode = NULL) {

    $elements = parent::view($items, $langcode);
    if (Element::children($elements)) {
      $elements['#theme'] = 'field__label_with_delimiter';
      $elements['#delimiter'] = $this->getSetting('delimiter');
    }

    return $elements;
  }

}
