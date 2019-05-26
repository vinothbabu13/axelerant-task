<?php 
namespace Drupal\axelerant_task\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class which listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('system.site_information_settings')) 
      $route->setDefault('_form', 'Drupal\axelerant_task\Form\ExtendedSiteInformationForm');
  }

}