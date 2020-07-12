<?php
// cli-config.php
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\HelperSet;

require_once (__DIR__)."/config/bootstrap.php";
$entityManager = require (__DIR__). "/config/doctrine.php";

return new HelperSet(array(
    'em' => new EntityManagerHelper($entityManager)
));
