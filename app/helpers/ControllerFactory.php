<?php
/**
 * Dynamically creates Command instances based on the given command name.
 * @see Command
 * @author Adolfo Eloy
 */
class ControllerFactory {
    
	/**
	 * Creates a WS controller 
	 * 
	 * WS Controller does not have smarty binding and no SEO features.
	 * 
	 * @param String $controllerName
	 */
	public static function createWSController($controllerName) {
		
        try {
            $class = new ReflectionClass(ucfirst($controllerName).'WSController');
        } catch (ReflectionException $e) {
            // $class = new ReflectionClass('HomeController');
            // TODO - tratar este erro de forma especifica para WebService 
        }
        
        $instance = $class->newInstance();
                
        return $instance;
	}
	
    /**
     * Creates a command object defined by app controller
     * 
     * @param String $commandName
     * @return Controller command
     */
    public static function createController($controllerName) {
        
        try {
            $class = new ReflectionClass(ucfirst($controllerName).'Controller');
        } catch (ReflectionException $e) {
            $class = new ReflectionClass('HomeController');
        }
        
        $instance = $class->newInstance();
        $instance->setView($_POST['smarty']);
        
        // building the seo helper
		$seo = SEOHelper::build($controllerName, SEO_FILE);
        
		// assign SEO data to the view
        $instance->getView()->assign('seo_title', $seo->title);
        $instance->getView()->assign('seo_description', $seo->description);
        
        return $instance;

    }
    
}
?>