<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\View\JsonView;
/**
 * ArticlesController Controller
 *
 * @method \App\Model\Entity\ArticlesController[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['index', 'add']);
       
    }
    public function viewClasses(): array
    {
        return [JsonView::class];
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $user = $this->request->getAttribute('identity');
        // echo '<pre>user'; print_r($user); echo '</pre>'; die();
        $this->request->allowMethod(['get']);
        $articles = $this->Articles->find('all')->contain(['Likes']);
        // echo '<pre>articles'; print_r($articles->toArray()[0]->likes); echo '</pre>'; die();
        $articles = $this->paginate($articles);
        $this->set(compact('articles'));
        $this->viewBuilder()->setOption('serialize', ['articles']);
    }

    // public function index()
    // {
    //     $this->request->allowMethod(['get']);
    //     $articles = $this->Articles->find('all');
    //     echo '<pre>articles'; print_r($articles->toArray()); echo '</pre>'; die();
    //     $this->set([
    //         'articles' => $articles,
    //         '_serialize' => ['articles']
    //     ]);
    // }

    /**
     * View method
     *
     * @param string|null $id Articles Controller id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $articlesController = $this->ArticlesController->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('articlesController'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {
    //     $articlesController = $this->ArticlesController->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $articlesController = $this->ArticlesController->patchEntity($articlesController, $this->request->getData());
    //         if ($this->ArticlesController->save($articlesController)) {
    //             $this->Flash->success(__('The articles controller has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The articles controller could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('articlesController'));
    // }

    public function add()
    {
        $this->request->allowMethod(['post']);
        die('tyrtytryr');
        $article = $this->Articles->newEmptyEntity();
        $article = $this->Articles->patchEntity($article, $this->request->getData());
        if ($this->Articles->save($article)) {
            $message = 'Article saved';
        } else {
            $message = 'Error saving article';
        }

        echo json_encode($message);
        exit;
    }

    /**
     * Edit method
     *
     * @param string|null $id Articles Controller id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $articlesController = $this->ArticlesController->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $articlesController = $this->ArticlesController->patchEntity($articlesController, $this->request->getData());
            if ($this->ArticlesController->save($articlesController)) {
                $this->Flash->success(__('The articles controller has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The articles controller could not be saved. Please, try again.'));
        }
        $this->set(compact('articlesController'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Articles Controller id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $articlesController = $this->ArticlesController->get($id);
        if ($this->ArticlesController->delete($articlesController)) {
            $this->Flash->success(__('The articles controller has been deleted.'));
        } else {
            $this->Flash->error(__('The articles controller could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function like($id){
        $this->loadModel('Likes');
        $this->request->allowMethod(['get']);
        if($id){
            $userId = $this->request->getAttribute('identity')->getIdentifier();
            $like = $this->Likes->newEmptyEntity();
            $like = $this->Likes->patchEntity($like, [
                'user_id' => $userId,
                'article_id' => $id
            ]);
            if ($this->Likes->save($like)) {
                $this->Flash->success(__('The articles has been Liked.'));
            } else {
                $this->Flash->error(__('The articles not be liked. Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}
