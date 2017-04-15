<?php

error_reporting(E_ALL);

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->add('legalcrm', __DIR__ . '/src');

$tonic = new \Tonic\Application(
    array(
        'load' => array(
            __DIR__ . '/src/legalcrm/Api/Resource/*.php',
            __DIR__ . '/src/legalcrm/Api/Resource/User/*.php',
            __DIR__ . '/src/legalcrm/doctrine/*.php',
        )
    )
);

try {
    /**
     * @var Tonic\Resource $resource
     */
    $resource = $tonic->getResource();

    /**
     * @var Tonic\Response $response
     */
    $response = $resource->exec();
} catch (\Tonic\NotFoundException $e) {
    $responseData = array("status" => "error", "data" => null, "message" => $e->getMessage());
    $response = new \Tonic\Response(\Tonic\Response::NOTFOUND, $responseData);
} catch (\Tonic\Exception $e) {
//    @TODO commented because of CORS issue while testing app from local machine.
    /*$responseData = array("status" => "error", "data" => null, "message" => $e->getMessage());
    $response = new \Tonic\Response(\Tonic\Response::METHODNOTALLOWED, $responseData);*/
}

$response->body = json_encode($response->body);
$response->headers['content-type'] = 'application/json';
$response->output();
