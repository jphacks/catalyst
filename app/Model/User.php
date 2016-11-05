<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

	class User extends AppModel{
		public $name = 'User';
		public $useTable = 'users';
		
		var $validate = array(
	        'tw_name' => array(
	            'rule' => 'isUnique', //重複登録回避
	            'message' => '重複です'
	        ),
	        'username' => array(
	            'rule' => 'isUnique', //重複登録回避
	            'message' => '重複です'
	        )
	    );
		public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']
			);
		}
		return true;
		}

		//新規登録＆ログイン
		public function login($data){
			$saveData = array();
			// 取得できたデータから必要なものを抜き出す
			if (isset($data['auth']['uid']) && $data['auth']['info']['name'] && $data['auth']['info']['image']) {
				$saveData['User']['username'] = $data['auth']['uid'];
				$saveData['User']['tw_name'] = $data['auth']['info']['name'];
				$saveData['User']['img'] = $data['auth']['info']['image'];
				$saveData['User']['password'] = $data['auth']['uid'];
			} else {
				return false;
			}

			// 
			$result = $this->find('first', array(
				'conditions' => array(
					'User.tw_name' => $saveData['User']['tw_name']
				)
			));
			// 登録済みでなければ保存
			if (empty($result)) {
				if (!$this->save($saveData)) {
					return false;
				}
				// 改めて取得
				$result = $this->find('first', array(
				'conditions' => array(
					'User.tw_name' => $saveData['User']['tw_name']
				)
			));
			}
			// 保存済みのデータを渡す
			return array(
				'username' => $result['User']['username'],
				'password' => $result['User']['password']
			);
		}
	}