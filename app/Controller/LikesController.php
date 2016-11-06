<?php

App::uses('AppController', 'Controller');

class LikesController extends AppController {
	public function beforeFilter() {
		parent::beforeFilter();
	}
	public function index() {
		if (empty($this->Auth->user())) {
            // ログインしていない場合、Twitterの認証ページへ移動
            $this->redirect('/auth/twitter');
        }

	}
}