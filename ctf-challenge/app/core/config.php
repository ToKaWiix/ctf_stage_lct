<?php
// Namespaces de l'application
define('APP_NAMESPACE', 'App');
define('CONTROLLERS_NAMESPACE', APP_NAMESPACE . '\\Controllers');
define('MODELS_NAMESPACE', APP_NAMESPACE . '\\Models');
define('CORE_NAMESPACE', APP_NAMESPACE . '\\Core');

// Chemins de base
define('BASE_PATH', dirname(dirname(__DIR__)));
define('APP_PATH', BASE_PATH . '/app');
define('PUBLIC_PATH', BASE_PATH . '/public'); 