<?php
/**
 * @package ActiveRecord
 */
namespace ActiveRecord;

/**
 * Interface for a command to be called by a Trigger object
 *
 * This class allows to create a class that implements any kind of business logic
 * using the execute method. So this command can be called by Trigger object.
 *
 * @package ActiveRecord
 */
interface TriggerCommand {
	
	/**
	 * Implement this method to create a trigger like business logic.
	 * 
	 * @param ActiveRecord\Model current model (with new or old values)
	 * @return void
	 */
	public function execute($model);
	
}