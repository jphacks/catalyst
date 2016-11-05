<?php

App::uses('AppController', 'Controller');

class LikesController extends AppController {
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('index');
	}
	public function index() {

	}
}