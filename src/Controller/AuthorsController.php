<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Authors Controller
 *
 * @property \App\Model\Table\AuthorsTable $Authors
 *
 * @method \App\Model\Entity\Author[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AuthorsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['index', 'view']);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $authors = $this->paginate($this->Authors);

        $this->set(compact('authors'));
    }

    /**
     * View method
     *
     * @param string|null $id Author id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $author = $this->Authors->get($id, [
            'contain' => ['Books']
        ]);

        $this->set('author', $author);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $author = $this->Authors->newEntity();
        if ($this->request->is('post')) {
            $author = $this->Authors->patchEntity($author, $this->request->getData());
            $author->user_id = $this->Auth->user('id');
            if ($this->Authors->save($author)) {
                $this->Flash->success(__('The author has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The author could not be saved. Please, try again.'));
        }
        $this->set(compact('author'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Author id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $author = $this->Authors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $author = $this->Authors->patchEntity($author, $this->request->getData());
            if ($this->Authors->save($author)) {
                $this->Flash->success(__('The author has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The author could not be saved. Please, try again.'));
        }
        $this->set(compact('author'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Author id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $author = $this->Authors->get($id, ['contain' => ['Books']] );
        
        if( is_array($author->books) && count($author->books) > 0 ) {
            $this->Flash->error(__('The author could not be deleted. because has one or more books.'));
        } else if ($this->Authors->delete($author)) {
            $this->Flash->success(__('The author has been deleted.'));
        } else {
            $this->Flash->error(__('The author could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function autocomplete($name) 
    {
		$this->autoRender = false;
		$res = $this->Authors->find('list', 
		['conditions' => ['Authors.name LIKE' => '%'.$name.'%']]);
		echo json_encode($res);
			
	}
	
	public function isAuthorized($user)
    {
        if($user['role'] === 'admin') {
            return true;
        }

        if ($this->request->getParam('action') === 'add' OR $this->request->getParam('action') === 'autocomplete') {
            return true;
        }
        
        if (in_array($this->request->getParam('action'), ['edit', 'delete'])) {
            $authorId = (int)$this->request->getParam('pass.0');
            $author = $this->Authors->get($authorId);
             return $author->user_id === $user['id'];
        }
        return parent::isAuthorized($user);
    }
}
