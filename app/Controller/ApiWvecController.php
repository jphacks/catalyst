<?php

App::uses('AppController', 'Controller');

class ApiWvecController extends AppController {
	public $components = array('RequestHandler');
	public function index() {
		$isError = false;
		$response = null;

		if (isset($this->request->query['word'])) {
			$word = $this->request->query['word'];
		} else {
			// エラー処理
			$isError = true;
		}

		if (!$isError) {
			$ch = curl_init();
			$uri = '' . Configure::read('API_SERVER') . '/word2vec?word=' . urlencode($word);
			$options = array(
				CURLOPT_URL => $uri,
				CURLOPT_HEADER => false,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 60, 
				CURLOPT_CUSTOMREQUEST => 'GET',
			);
			curl_setopt_array($ch, $options);
			$response =curl_exec($ch);
			curl_close($ch);
		}

		$this->set("json", $response);
	}
}