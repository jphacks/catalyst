<?php

App::uses('AppController', 'Controller');

class ApiLikesController extends AppController {
	public $components = array('RequestHandler');
	public $uses = array('Favorite');
	public function beforeFilter() {
		parent::beforeFilter();
		// $this->Auth->allow();
	}

	public function index() {
		$this->viewClass = 'Json';
		$this->request->query['user_id'] = $this->Auth->user('id');
		
		$result = $this->Favorite->getLikeNum($this->request->query);

		$this->set(array(
			'result' => $result,
			'_serialize' => array('result')
		));
	}


}