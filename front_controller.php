<?php
/**
 * This script implements the front controller of this simple framework.
 * To get it working, you only need to create Command classes and implements
 * its methods that will be treated as actions retrieved from a rewrited URL.
 * 
 * Follow this simple convention for URL:
 * command/action/id
 * 
 * where: 
 * - command will be the prefix of your command class implementation
 * - action will be defined by methods that you create (at least index must be implemented)
 * - id can be used as an id argument
 * 
 * any suggestion: adolfo_eloy@yahoo.com.br
 */

require_once 'app/include/functions.php';
require_once 'app/helpers/Controller.php';
require_once 'app/helpers/ControllerManager.php';
require_once 'config/bootstrap.php';

session_start();

class FrontController {
	public function start() {
		
		// retrieving URL parameters 
		$command = get_default('command', 'home');
		$action  = get_default('action', 'index');    
		$id      = get_default('id', null);

		// parameter logs
		$logger = Logger::getLogger(__CLASS__);
		$logger->debug("GET:", print_r($_GET, true));
		$logger->debug("command: {$command}");
		$logger->debug("action: {$action}");
		$logger->debug("id: {$id}");
		
		// authentication produces this kind of object
		$security = SecurityManager::createInstance($_POST['security_file']);
		$security->configSmartySecurityInfo($_POST['smarty']);
		$sc = $security->getSecuredCommandAction($command, $action);
		
		// creating an instance of a command
    	if ($ws == 1) {
      		$cmd = ControllerFactory::createWSController($sc->command);
    	} else {
    		$cmd = ControllerFactory::createController($sc->command);
    	}
		
		// session config
		SessionConfig::build();
		
		// front controller executing the command
		$controller = new ControllerManager();
		$controller->execute($cmd, $sc->action, $id);
	}
}

$front = new FrontController();
$front->start();

