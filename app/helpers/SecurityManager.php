<?php
/**
 * Manage subject and its authorization rules.
 * @author adolfo
 */
class SecurityManager {
	
	/** rules have role definitions that matches to modules and actions available by this app 
	 *  It is an associative array with commands that is an array of actions that is an array of roles. */
	private $rules		= null;
	
	/**
	 * This constructor is private to force creation of security manager by a factory method.
	 * @param Rules   $rules
	 */
	private function __construct($rules) {
		$this->rules 	= $rules;
	}
	
	/**
	 * This method provides security info to smarty variables.
	 * This must evolve to have much more data.
	 * @param Smarty $smarty
	 */
	public function configSmartySecurityInfo($smarty) {
		$subject = SecurityManager::getSubject();
		$smarty->assign('isauth', $subject->isAuth());	
		$smarty->assign('user', $subject->getUser());
		
		$roles = $subject->getRoles();
		
	}
	
	/**
	 * Get an existing or newly created subject in the session scope
	 * @return Subject
	 */
	public static function getSubject() {
		if (isset($_SESSION['subject'])) {
			if (!empty($_SESSION['subject'])) {
				return $_SESSION['subject'];
			}
		}		
		$subj = new Subject(FALSE);
		$_SESSION['subject'] = $subj;
		return $subj;
	}
	
	/**
	 * Defines a valid authenticated subject.
	 * @param SecurityUser $user
	 */
	public static function setAuthSubject($user) {
		$subj = new Subject();
		$subj->setAuth(TRUE);
		$subj->setUser($user);

		// retrieving the user roles
		$roles = array();
		foreach ($user->usuario_roles as $user_role) {
			array_push($roles, $user_role->roles->name);
		}
		$subj->setRoles($roles);
		
		$_SESSION['subject'] = $subj;
	}
	
	/**
	 * Verifies if the command and action required must be executed by logged users.
	 * @param string	$command	name of the controller
	 * @param string	$action		method name of a controller
	 * @param array	 	$auth 		an associative array with commands that is an array of actions that is an array of roles.
	 * @return boolean
	 */
	public function isProtectedAction($command, $action) { 
		$requires_login = false;
		
		if (array_key_exists($command, $this->rules)) {
			
			$protected_action = array_key_exists($action, $this->rules[$command]);
			$all_protected = array_key_exists('all', $this->rules[$command]);
			
			if ($protected_action || $all_protected) {
				$requires_login = true;
			}
		}
		
		return $requires_login;
	}
	
	/**
	 * Decides to redirect or do not redirect to login page.
	 * @param string	$command	name of the controller
	 * @param string	$action		method name of a controller
	 * @return boolean
	 */
	public function mustRedirect($command, $action) {
		if ($this->isProtectedAction($command, $action)) {
			$subject = SecurityManager::getSubject();
			return !$subject->isAuth();
		}
		return false;
	}
	
	/**
	 * Creates an instance of Security Manager.
	 * @param Rules $rules an associative array with commands that is an array of actions that is an array of roles.
	 * @return SecurityManager
	 */
	public static function createInstance($security_file_path) {
		$rules = Spyc::YAMLLoad($security_file_path);
		return new SecurityManager($rules);	
	}

	
	public function getSecuredCommandAction($command, $action) {
		$sec = new SecuredCommandAction();
		
		if ($this->isProtectedAction($command, $action)) {
			
			// must redirect
			if ($this->mustRedirect($command, $action)) {
				$sec->command = 'login';
				$sec->action  = 'form';
				return $sec;
			} 
			
			// does not have permission
			if (!$this->hasPermission($command, $action)) {
				$sec->command = 'unauthorized';
				$sec->action  = 'index';
				return $sec;
			}
			
		}
		
		$sec->command = $command;
		$sec->action  = $action;
		return $sec;
	}
	
	/**
	 * Ask for permition about a command and maybe an action.
	 * @param string $command
	 * @param string $action
	 * @return boolean
	 */
	public function hasPermission($command, $action = '') {
		$roles = $this->getAllowedRoles($command, $action);
		
		// if there is no roles, so any subject has permission
		if (count($roles) == 0) {
			return true;
		}

		if (count(array_intersect($roles, SecurityManager::getSubject()->getRoles())) > 0) {
			return true;
		}

		return false;
	}
	
	public function getAllowedRoles($command, $action) {
		$roles = array();
		if ($this->isProtectedAction($command, $action)) {
			
			if (array_key_exists($action, $this->rules[$command])) {
				$roles = $this->rules[$command][$action];
			}

			if (array_key_exists('all', $this->rules[$command])) {
				$roles = $this->rules[$command]['all'];
			}
			
		}
		
		if (!is_array($roles)) {
			$roles = array();
		}
		
		return $roles;
	}
	
	
}