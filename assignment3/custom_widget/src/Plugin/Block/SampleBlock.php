<?php

/**
 * @file
 * A custom sample block
 */

namespace Drupal\custom_widget\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Sample' Block.
 *
 * @Block(
 *   id = "sample_block",
 *   admin_label = @Translation("Sample Block"),
 *   category = @Translation("Blocks")
 * )
 */
class SampleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    // Retrieve existing configuration for this block.
    $config = $this->getConfiguration();
    // Add a form field to the existing block configuration form.
    $form['title'] = array(
      '#type' => 'textfield',
      '#title' => t('Title'),
      '#default_value' => isset($config['title']) ? $config['title'] : '',
    );
    $form['image'] = array(
      '#type' => 'file',
      '#title' => t('Image Upload'),
      '#upload_validators' => array(
        'file_validate_extensions' => array('gif png jpg jpeg'),
        'file_validate_size' => array(25600000),
      ),
      '#default_value' => isset($config['image']) ? $config['image'] : '',
    );

    $form['description'] = array(
      '#type' => 'textfield',
      '#title' => t('Description'),
      '#default_value' => isset($config['description']) ? $config['description'] : '',
    );
    $form['ip_address'] = array(
      '#type' => 'textfield',
      '#title' => t('Specific IP Address'),
      '#default_value' => isset($config['ip_address']) ? $config['ip_address'] : '',
    );
    // $form['#attached']['library'][] = 'custom_widget/custom_css';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Nothing.
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    // Save our custom settings when the form is submitted.
    $this->setConfigurationValue('title', $form_state->getValue('title'));
    $this->setConfigurationValue('image', $form_state->getValue('image'));
    $this->setConfigurationValue('description', $form_state->getValue('description'));
    $this->setConfigurationValue('ip_address', $form_state->getValue('ip_address'));
    
    $image = $form_state->getValue('image');
    /* Load the object of the file by it's fid */
    $file = \Drupal\file\Entity\File::load( $image[0] );

    /* Set the status flag permanent of the file object */
    $file->setPermanent();

    /* Save the file in database */
    $file->save();

    drupal_flush_all_caches();
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $config = $this->getConfiguration();

    return [
      '#theme' => 'sample_block',
      '#data' => $config,
    ];
  }

}
