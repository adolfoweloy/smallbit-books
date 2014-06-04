<?php
/**
 * @package ActiveRecord
 */
namespace ActiveRecord;

/**
 * Defines a programmatic trigger when database triggers cannot be created 
 *
 * This class behaves such as a trigger and is used by the Model class to
 * execute operations before or after (insert/delete/update).
 *
 * @package ActiveRecord
 */
class Trigger {
	
	/**
	 * Defines when this trigger must be called
	 * Accepted values: before or after
	 * @var string 
	 */
	private $execute_when = null;
	
	/**
	 * Defines the kind of operation to be treated by this trigger.
	 * Accepted values: insert, update, delete
	 * @var string
	 */
	private $operation = null;
	
	/**
	 * TriggerCommand implementation with any kind of business logic
	 * @var ActiveRecord\TriggerCommand
	 */
	private $command = null;
	
	/**
	 * Creates the trigger defining all needed parameters
	 * 
	 * add description. ...
	 * 
	 * @param string $execute_when
	 * @param string $operation
	 * @param TriggerCommand $command
	 */
	public function __construct($execute_when, $operation, $command) {
		$this->execute_when = $execute_when;
		$this->operation = $operation;
		$this->command = $command;
	}
	
	/**
	 * Executes the business logic defined within the trigger command.
	 * @param ActiveRecord\Model
	 */
	public function execute_command($model) {
		$this->command->execute($model);
	}
	
	/**
	 * Retrieves the operation to be treated: insert, update or delete
	 * @return string
	 */
	public function get_operation() {
		return $this->operation;
	}
	
	/**
	 * Retrieves when the operation must be called
	 * @return string
	 */
	public function get_execute_when() {
		return $this->execute_when;
	}
	
}

/**
 * This class groups all triggers by before or after execution 
 * 
 * This class was created to facilitate the trigger retrieving by model.
 * 
 * @package ActiveRecord 
 */
class TriggerManager {
	
	/**
	 * Group triggers regarding when this must be triggered (before or after) 
	 * and operations to be treated (insert, update, delete)
	 * 
	 * @var ActiveRecord\TriggerOperations
	 */
	private $group = null;

	/**
	 * This constructor prepares the data structure to manage how to hold all the triggers for such a model.
	 */
	public function __construct() {
		$this->group = array(
		
			'before' => array(
				'insert' => array(),
				'update' => array(),
				'delete' => array()),
		
			'after' => array(
				'insert' => array(),
				'update' => array(), 
				'delete' => array())
		);	
	}
	
	/**
	 * add trigger operation 
	 * @param ActiveRecord\Trigger $trigger
	 * @param string $operation
	 */
	public function add_trigger($trigger) {
		$when = $trigger->get_execute_when();
		$operation = $trigger->get_operation();
		
		if (array_key_exists($when, $this->group)) {
			
			if (array_key_exists($operation, $this->group[$when])) {
				array_push($this->group[$when][$operation], $trigger);				
			} else {
				throw new TriggerException(
					"keyword {$operation} was not defined - try insert, update or delete", 
					9000, null);
			}
			
		} else {
			throw new TriggerException(
				"keyword {$when} was not defined - try before or after", 
				9001, null);
		}
		
	}
	
	public function execute_before($operation, $model) {
		$this->execute('before', $operation, $model);
	}
	
	public function execute_after($operation, $model) {
		$this->execute('after', $operation, $model);
	}
	
	private function execute($when, $operation, $model) {
		$triggers = $this->group[$when][$operation];
		foreach ($triggers as $t) {
			$t->execute_command($model);
		}
	}
}