<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {
        public $uses = array('User');
    //     public $components = array(
    //     'Auth' => array(
    //         'authenticate' => array(
    //             'Form' => array(
    //                 'fields' => array('username' => 'email')
    //             )
    //         )
    //     )
    // );
	public function beforeFilter() {
        parent::beforeFilter();//これがないと、親であるAppControllerのbeforeFilter()が実行されない
        $this->Auth->allow(array(
                                'mypage',
                                'login',
                                'logout',
                                'opauthComplete'
                                ));


    }
	public function opauthComplete() {

        // 新規ユーザー
        $user = $this->User->login($this->data);
        if ($user === false) {
            $this->redirect(array('controller' => 'Home', 'action' => 'index'));
        }

        $this->request->data['User'] = array(
            'username' => $user['username'],
            'password' => $user['username']
        );
        debug($this->request->data);
        $this->setAction('login');

	}
    public function login() {
        $this->Auth->login();
        $this->redirect(array('controller' => 'home', 'action' => 'index'));
    }
    public function logout() {
        $this->redirect($this->Auth->logout());
    }
}