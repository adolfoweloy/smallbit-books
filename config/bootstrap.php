<?php

// defines the absolute context path
define("APPLICATION_PATH", realpath('.'));
define("LOG_PATH", APPLICATION_PATH . DIRECTORY_SEPARATOR . 'server' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR);
define("ENVIRONMENT", "DEV"); // PROD - production, DEV - development, TEST - test mode

/** REGISTRY_BODY_MAIL defines the absolute path to the registry.txt
 *  registry.txt contains the default template for body email when a new user
 *  get an account from your website */
define("REGISTRY_BODY_MAIL", APPLICATION_PATH . DIRECTORY_SEPARATOR . 'server/plaintext/registry.txt');
define("USER_CONDITIONS_FILE", APPLICATION_PATH . DIRECTORY_SEPARATOR . 'server/plaintext/terms.txt');

/** SEO definitions */
define("SEO_FILE", 'config/simpleseo.yaml');

// mail settings
// define("SMTP_SERVER", '');

/** lib para criacao de xml */
require_once 'lib/xdom/xdom.php';

/** 
 * Log4php config
 */
require_once 'lib/log4php/Logger.php';
Logger::configure("config/log4php.properties");

/**
 * YAML interpreter
 */
require_once 'lib/spyc/spyc.php';
$_POST['security_file'] = 'config/security.yaml';

/**
 * configuring smarty php - VIEW lib
 */
require_once 'lib/smarty/Smarty.class.php';

$smarty = new Smarty();
$smarty->setTemplateDir('app/views');
$smarty->setCompileDir('server/smarty_compiled');
$smarty->setCacheDir('server/smarty_cache');
$smarty->setConfigDir('app/views/config');

// locale config
$config['date'] = '%d/%m/%Y';
$config['time'] = '%H:%M:%S';
$config['datetime'] = '%d/%m/%Y %H:%M:%S';
$smarty->assign('config', $config);

$_POST['smarty'] = $smarty;

/**
 * configuring php-activerecord - MODEL lib
 */
require_once 'lib/php-activerecord/ActiveRecord.php';

ActiveRecord\Config::initialize(function($cfg)
{
    $cfg->set_model_directory('app/models');
    $cfg->set_connections(array('development' =>
      'mysql://root:password@localhost/artigo_java_magazine'));
});

?>
