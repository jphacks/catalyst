<?php

App::uses('AppController', 'Controller');

class UserController extends AppController {
	public function opauthComplete() {
		debug($this->data);
	}
}