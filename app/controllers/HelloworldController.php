<?php
class HelloworldController extends Controller {
	
	public function index() {
		$this->view->display('helloworld/index.tpl');	
	}
	
}