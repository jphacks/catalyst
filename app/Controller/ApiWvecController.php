<?php

App::uses('AppController', 'Controller');

class ApiWvecController extends AppController {
	public $components = array('RequestHandler');
	public function index() {
		$this->viewClass = 'Json';
		$isError = false;
		$response;

		if (isset($this->request->query['word'])) {
			$word = $this->request->query['word'];
		} else {
			// エラー処理
			$isError = true;
		}

		if (!$isError) {
			// ISBNを用いて、国会図書館APIから書籍情報を取得する
			$ch = curl_init();
			$uri = 'http://150.42.5.138//word2vec?word=' . $word;
			$options = array(
				CURLOPT_URL => $uri,
				CURLOPT_HEADER => false,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 60, 
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_POSTFIELDS => null, // URLエンコードして application/x-www-form-urlencoded でエンコード。URLエンコードしないとmultipart/form-dataになる
			);
			curl_setopt_array($ch, $options);
			$response =curl_exec($ch) ;// 第2引数をtrueにすると連想配列で返ってくる
			curl_close($ch);
		}

		$this->set(array(
			'result' => $response,
			'_serialize' => array('result')
		));
	}
}