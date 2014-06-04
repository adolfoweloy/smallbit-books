<?php
class AboutController extends Controller {
	public function index() {
		$this->view->display('home/about.tpl');
	}
}