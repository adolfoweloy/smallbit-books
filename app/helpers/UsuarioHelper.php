<?php
class UsuarioHelper {
	
	/**
	 * Recupera o usuario autenticado no momento
	 * @return Usuario
	 */
	public static function getUsuarioAtual() {
		$subj = SecurityManager::getSubject();
		return $subj->getUser();
	}
	
}