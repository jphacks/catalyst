<?php
	App::uses('AppController', 'Controller');	
	class TwLoginsController extends AppController {
		public $name = 'TwLogins';
		public $layout = "bootstrap"; //board.ctp レイアウトを利用
		public $uses = array('NewUser'); //Userモデルを追加
		/****認証周り*****/
		public $components = array(
			// 'DebugKit.Toolbar', //デバッグきっと
			'TwitterKit.Twitter', //twitter
			'Auth' => array( //ログイン機能を利用する
				'authenticate' => array(
					'Form' => array(
						'userModel' => 'NewUser'
					)
				),
				//ログイン後の移動先
				'loginRedirect' => array('controller' => 'tw_logins', 'action' => 'index/'),
				//ログアウト後の移動先
				'logoutRedirect' => array('controller' => 'tw_logins', 'action' => 'login'),
				//ログインページのパス
				'loginAction' => array('controller' => 'tw_logins', 'action' => 'login'),
				//未ログイン時のメッセージ
				'authError' => 'あなたのお名前とパスワードを入力して下さい。',
			)
		);

		public function beforeFilter(){//login処理の設定
		 	$this->Auth->allow('twitter_login', 'login', 'oauth_callback');
		 	$this->set('user',$this->Auth->user()); // ctpで$userを使えるようにする 。
		}
		public function twitter_login(){//twitterのOAuth用ログインURLにリダイレクト
					$this->redirect($this->Twitter->getAuthenticateUrl(null, true));
		}
		
		//ログインアクション
		public function login(){}

		public function logout(){
			$this->Auth->logout();
			$this->Session->destroy(); //セッションを完全削除
			$this->Session->setFlash(__('ログアウトしました'));
			$this->redirect(array('action' => 'login'));
		}

		function oauth_callback() {
			if(!$this->Twitter->isRequested()){//認証が実施されずにリダイレクト先から遷移してきた場合の処理
				$this->flash(__('invalid access.'), '/', 5);
				return;
			}
			$this->Twitter->setTwitterSource('twitter');//アクセストークンの取得を実施
			$token = $this->Twitter->getAccessToken();
			$data['NewUser'] = $this->NewUser->signin($token); //ユーザ登録
			$this->Auth->login($data); //CakePHPのAuthログイン処理
			$this->redirect($this->Auth->loginRedirect); //ログイン後画面へリダイレクト
		}

		public function index(){}
		
	}
