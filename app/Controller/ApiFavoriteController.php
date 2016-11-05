<?php

App::uses('AppController', 'Controller');

class ApiFavoriteController extends AppController {
	public $components = array('RequestHandler');
	public $uses = array('Favorite', 'SearchKey');
	public function beforeFilter() {
		parent::beforeFilter();
		// $this->Auth->allow();
	}

	public function index() {
		$this->viewClass = 'Json';
		if (isset($this->request->query['word'])) {
			$result = $this->Favorite->getData($this->Auth->user('id'), $this->request->query['word']);
		} else {
			$result = $this->Favorite->getData($this->Auth->user('id'));
		}
		debug($result);
		$this->set(array(
			'result' => $result,
			'_serialize' => array('result')
		));
	}

	public function add() {
		$result = false;
		$query = $this->request->query;

		if ($query['word1'] && $query['word2']) {
			$saveData = array(
				'user_id' => $this->Auth->user('id'),
				'word1' => $query['word1'],
				'word2' => $query['word2']
			);

			$result = $this->Favorite->registFavorite($saveData);
		}

		$this->set(array(
			'result' => $result,
			'_serialize' => array('result')
		));
	}

}