<?php
namespace Drupal\axelerant_task\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller for axlerant task
 * 
 */
class AxelerantTaskController {

  /**
   * we can move this to specific error library later
   */
  const ERROR_ACCESS_DENIED = 'access denied';
  const STATUS_SUCCESS = 'success';
  const STATUS_FAILURE = 'failure';

  public function getNodeData($apiKey, $nodeId) {
    $system_site_config = \Drupal::config('system.site');  
    $siteApiKey = $system_site_config->get('siteapikey');
      
    if(!$siteApiKey || $siteApiKey != $apiKey) {
      return self::ReturnResponse(self::STATUS_FAILURE, self::ERROR_ACCESS_DENIED);
    }

    $node =  \Drupal::entityTypeManager()->getStorage('node')->load($nodeId);
    if(!$node) {
      return self::ReturnResponse(self::STATUS_FAILURE, self::ERROR_ACCESS_DENIED);
    }
    
    $serializer = \Drupal::service('serializer');
    $data = json_decode($serializer->serialize($node, 'json', ['plugin_id' => 'entity']));

    return self::ReturnResponse(self::STATUS_SUCCESS, "", $data);
  }

  /**
   * we can move this to error library later
   */
  public static function ReturnResponse($status, $erroMsg="", $data=array()) {
    $responseData = array();
    switch($status) {
      case self::STATUS_SUCCESS:
        $responseData = array(
          "status" => $status,
          "data" => $data,
          "content-type" => "page"
        );
        break;
      case self::STATUS_FAILURE:
        $responseData = array(
          "status" => $status,
          "error_msg" => $erroMsg
        );
        break;
    }
    
    return new JsonResponse([
      $responseData
    ]);
  }
}