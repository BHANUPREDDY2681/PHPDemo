<?php
/**
 * Config file which is required by Doctrine command line. In this case,
 * we need to have access to Doctrine command line in order to clear metadata cache
 */

require_once __DIR__ . '/vendor/autoload.php';

$context = new \legalcrm\context\RestApi(__DIR__);

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(
    array(
        'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($context['doctrine.entityManager'])
    )
);

return $helperSet;
