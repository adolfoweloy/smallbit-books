<?php
class Subject {
	private $user = null;
	private $roles = array();
	private $auth = false;
	
	/**
	 * Determines if the subject being managed has the specified role name.
	 * @param string $roleName
	 * @return boolean
	 */
	public function hasRole($roleName) {
		return in_array($roleName, $this->roles);	
	}
	
	public function __construct($isAuth = false) {
		$this->auth = $isAuth;
	}

	public function setUser($user)
	{
		$this->user = $user;
		return $this;
	}
	
	public function getUser()
	{
		return $this->user;
	}
	
	public function setAuth($auth) {
		$this->auth = $auth;
		return $this;
	}
	
	public function isAuth() {
		return $this->auth;
	}
	
	public function setRoles($roles)
	{
		$this->roles = $roles;
		return $this;
	}
	
	public function getRoles()
	{
		return $this->roles;
	}
	
}