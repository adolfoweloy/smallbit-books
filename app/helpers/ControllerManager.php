<?php
/**
 * This class, provides a way to execute dynamically a Command instance
 * invoking the method defined by $action argument.
 * @author Adolfo Eloy
 */
class ControllerManager {
    public function execute($command, $action, $id = null) {              
        $obj = new ReflectionObject($command);       
        
        try {
            $method = $obj->getMethod($action);
            $method->invoke($command, $id);            
        } catch (ReflectionException $e) {
            $method = $obj->getMethod('index');
            $method->invoke($command, $id);
        }
        
    }
}
?>