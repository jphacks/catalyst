<?php
App::uses('AppModel', 'Model');

	class Favorite extends AppModel{
		public $useTable = 'favorites';

		public function getData($userId, $word = null) {
			if (is_null($word)) {
				return $this->getByUserId($userId);
			} else {
				return $this->getByWord($userId, $word);
			}
		}
		public function getByWord($userId, $word) {
			// wordとuserIdで検索
			$data = $this->find('all', array(
				'conditions' => array(
					'Favorite.user_id' => $userId,
					'or' => array(
						'Favorite.word1' => $word, 
						'Favorite.word2' => $word
						)
				),
				'fields' => array(
					'Favorite.word1',
					'Favorite.word2',
				)
			));
			return $data;
		}
		// 全データをuserIdで取得
		public function getByUserId($userId) {
			$data = $this->find('all', array(
				'conditions' => array(
					'Favorite.user_id' => $userId
				),
				'fields' => array(
					'Favorite.word1',
					'Favorite.word2',
				)
			));
			return $data;
		}
		// 保存
		public function registFavorite($data) {
			// 							debug($data);
			// die();
			// user1, word1, word2が重複していなければ保存できる
			if (!isset($data['user_id']) || !isset($data['word1']) || !isset($data['word2'])) {

				return false;
			}
				
			$result = $this->find('first', array(
				'conditions' => array(
					'Favorite.user_id' => $data['user_id'],
					'Favorite.word1' => $data['word1'],
					'Favorite.word2' => $data['word2']
				)
			));
			if (!empty($result)) {
				return false;
			}
			
			return $this->save($data);

		}
	}