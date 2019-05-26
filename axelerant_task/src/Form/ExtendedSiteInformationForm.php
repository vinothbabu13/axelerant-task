<?php
namespace Drupal\axelerant_task\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;

/**
 * class which extends site information to add new field in site information
 */
class ExtendedSiteInformationForm extends SiteInformationForm {
 
   /**
   * {@inheritdoc}
   */
	public function buildForm(array $form, FormStateInterface $form_state) {
    $site_config = $this->config('system.site');
    $form =  parent::buildForm($form, $form_state);
    $form['site_information']['siteapikey'] = [
      '#type' => 'textfield',
      '#title' => t('Site API Key'),
      '#default_value' =>  $site_config->get('siteapikey') ?: '',
      '#description' => t("Custom field to set the API Key"),
        ];
		
		$form['actions']['submit']['#value'] = t("Update Configuration");
		return $form;
	}

  /**
   * method to save siteapikey update
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('system.site')
      ->set('siteapikey', $form_state->getValue('siteapikey'))
      ->save();
    parent::submitForm($form, $form_state);
  }
}