<?php
App::uses('AppModel', 'Model');

	class SearchKey extends AppModel{
		public $useTable = 'search_keys';


		//検索キーの保存
		public function saveData($data){
			$saveData = array();
			// 取得できたデータから必要なものを抜き出す
			if (!isset($data['user_id']) || !isset($data['word'])) {
				return false;
			}
			$result = $this->find('first', array(
				'conditions' => array(
					'SearchKey.user_id' => $data['user_id'],
					'SearchKey.word' => $data['word']
				)
			));

			// 登録済みでなければ保存しない
			if (!empty($result)) {
				return false;
			}

			// 保存済みのデータを渡す
			return $this->save($data);
		}
	}