<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Books Controller
 *
 * @property \App\Model\Table\BooksTable $Books
 *
 * @method \App\Model\Entity\Book[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BooksController extends AppController
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
    public function index($src = null)
    {
        $this->paginate = ['contain' => ['Authors']];
        if( isset($src) )
        {
            $search = $this->request->getParam('pass');
            if(is_array($search) && count($search>1) )
                $books = $this->paginate($this->Books, ['conditions' => ['Books.title LIKE' => '%'.$search[1].'%']]);
        } else {
            $books = $this->paginate($this->Books);
        }
        $this->set(compact('books'));
    }

    /**
     * View method
     *
     * @param string|null $id Book id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($slug = null)
    {

		$book = $this->Books->findBySlug($slug)->contain('Authors', 'Users')->firstOrFail();
       // pr($book);exit;
		$this->set(compact('book')); 
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $book = $this->Books->newEntity();
		
        if ($this->request->is('post')) {
			
            $book = $this->Books->patchEntity($book, $this->request->getData());
		    $book->user_id = $this->Auth->user('id');
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }
        $authors = $this->Books->Authors->find('list', ['limit' => 200]);
        $this->set(compact('book', 'authors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Book id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($slug = null)
    {
        $book = $this->Books->findBySlug($slug)->contain('Authors')->firstOrFail();
		//pr($book);exit;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $book = $this->Books->patchEntity($book, $this->request->getData());
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }
        $this->set(compact('book'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Book id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($slug = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $book = $this->Books->findBySlug($slug)->firstOrFail();
        if ($this->Books->delete($book)) {
            $this->Flash->success(__('The book has been deleted.'));
        } else {
            $this->Flash->error(__('The book could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user)
    {
        if($user['role'] === 'admin') {
            return true;
        }
        
        if ($this->request->getParam('action') === 'add') {
            return true;
        }

        if (in_array($this->request->getParam('action'), ['edit', 'delete'])) {
            $slug = $this->request->getParam('pass.0');
            if (!$slug) {
                return false;
            } else {
                $book = $this->Books->findBySlug($slug)->first();
                return $book->user_id === $user['id'];
            }
        }
    }
}
