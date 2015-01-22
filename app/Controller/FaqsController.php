<?php
App::uses('AppController', 'Controller');
/**
 * Faqs Controller
 *
 * @property Faq $Faq
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class FaqsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Faq->recursive = 0;
		$this->set('faqs', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Faq->exists($id)) {
			throw new NotFoundException(__('Invalid faq'));
		}
		$options = array('conditions' => array('Faq.' . $this->Faq->primaryKey => $id));
		$this->set('faq', $this->Faq->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Faq->create();
			if ($this->Faq->save($this->request->data)) {
				$this->Session->setFlash(__('The faq has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The faq could not be saved. Please, try again.'));
			}
		}
		$categories = $this->Faq->Category->find('list');
		$products = $this->Faq->Product->find('list');
		$providers = $this->Faq->Provider->find('list');
		$createUsers = $this->Faq->CreateUser->find('list');
		$modifyUsers = $this->Faq->ModifyUser->find('list');
		$this->set(compact('categories', 'products', 'providers', 'createUsers', 'modifyUsers'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Faq->exists($id)) {
			throw new NotFoundException(__('Invalid faq'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Faq->save($this->request->data)) {
				$this->Session->setFlash(__('The faq has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The faq could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Faq.' . $this->Faq->primaryKey => $id));
			$this->request->data = $this->Faq->find('first', $options);
		}
		$categories = $this->Faq->Category->find('list');
		$products = $this->Faq->Product->find('list');
		$providers = $this->Faq->Provider->find('list');
		$createUsers = $this->Faq->CreateUser->find('list');
		$modifyUsers = $this->Faq->ModifyUser->find('list');
		$this->set(compact('categories', 'products', 'providers', 'createUsers', 'modifyUsers'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Faq->id = $id;
		if (!$this->Faq->exists()) {
			throw new NotFoundException(__('Invalid faq'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Faq->delete()) {
			$this->Session->setFlash(__('The faq has been deleted.'));
		} else {
			$this->Session->setFlash(__('The faq could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
