<?php

  require_once('vendor/autoload.php');

  $data = file_get_contents('service-account.json');
  $parameters = json_decode($data, true);

  $client = new Google_Client();
  $client->setAuthConfig($parameters);
  $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
  $client->setApplicationName('TokenService');
  $client->useApplicationDefaultCredentials();
  $client->refreshTokenWithAssertion();
  $token = $client->getAccessToken();

  $response = array(
    'type'    => 'FCM-HTTP-v1',
    'project' => $parameters['project_id'],
    'token'   => $token['access_token'],
    'expires' => $token['expires_in']
  );

  $data = json_encode($response);

  header("Content-Type: application/json");
  print($data);

?>
