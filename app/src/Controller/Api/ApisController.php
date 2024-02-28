<?php

namespace App\Controller\Api;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ApisController extends AppController{
    public function login(){
        $userData = [];
        if ($this->request->is(['post'])) {
            $result = $this->Authentication->getResult();
            if ($result->isValid()) {
                $userData = $result->getData();
                $key = file_get_contents(CONFIG. '/jwt.key');
                $payload = [
                    'sub' => $userData->id,
                    'exp' => time()+600000,
                ];

                $userData = [
                    'token' => JWT::encode($payload, $key, 'RS256'),
                    'data' => $userData
                ];
            } else {
                $this->response = $this->response->withStatus(401);
                $userData = [
                    'message' => 'Sorry incorrect user detail'
                ];
            }
        }
        $this->set('userData', $userData);
        $this->viewBuilder()->setOption('serialize', 'userData');
    }

    public function list(){
        $articles = TableRegistry::getTableLocator()->get('Articles');
        if ($this->request->is(['get'])) {
            $article = $articles->find('all')->toArray();
            if($article){
                $this->response = $this->response->withStatus(200);
                $message = $article;
            } else {
                $this->response = $this->response->withStatus(400);
                $message = 'Article not found';
            }
            $this->set('data', $message);
            $this->viewBuilder()->setOption('serialize', 'data');
        }
    }

    public function add(){
        $articles = TableRegistry::getTableLocator()->get('Articles');
        if ($this->request->is(['post'])) {
            $jwtToken = $this->request->getHeaderLine('Authorization');
            if (strpos($jwtToken, 'Bearer ') === 0) {
                $jwtToken = substr($jwtToken, 7);
                $key = file_get_contents(CONFIG. '/jwt.pem');
                $decodedToken = JWT::decode($jwtToken, new Key($key, 'RS256'));
                if($decodedToken && $decodedToken->sub){
                    $data = $this->request->getData();
                    $data['user_id'] = $decodedToken->sub;
                    $article = $articles->newEmptyEntity();
                    $article = $articles->patchEntity($article, $data);
                    if ($articles->save($article)) {
                        $this->response = $this->response->withStatus(200);
                        $message = 'Article saved';
                    } else {
                        $this->response = $this->response->withStatus(400);
                        $message = 'Error saving article';
                    }
                } else {
                    $this->response = $this->response->withStatus(403);
                    $message = 'Invalid Token';
                }
            } 
            $this->set('data', $message);
            $this->viewBuilder()->setOption('serialize', 'data');
        }
    }

    public function edit($id){
        $articles = TableRegistry::getTableLocator()->get('Articles');
        if ($this->request->is(['put']) && $id) {
            $jwtToken = $this->request->getHeaderLine('Authorization');
            if (strpos($jwtToken, 'Bearer ') === 0) {
                $jwtToken = substr($jwtToken, 7);
                $key = file_get_contents(CONFIG. '/jwt.pem');
                $decodedToken = JWT::decode($jwtToken, new Key($key, 'RS256'));
                if($decodedToken && $decodedToken->sub){
                    $article = $articles->find('all')->where(['id' => $id])->first();
                    if($article->user_id == $decodedToken->sub){
                        $data = $this->request->getData();
                        $article = $articles->patchEntity($article, $data);
                        if ($articles->save($article)) {
                            $this->response = $this->response->withStatus(200);
                            $message = 'Article Updated';
                        } else {
                            $this->response = $this->response->withStatus(400);
                            $message = 'Error Updating article';
                        }
                    } else {
                        $this->response = $this->response->withStatus(401);
                        $message = 'You are not Authorized to Update Article';
                    }
                } else {
                    $this->response = $this->response->withStatus(403);
                    $message = 'Invalid Token';
                }
            } 
            $this->set('data', $message);
            $this->viewBuilder()->setOption('serialize', 'data');
        }
    }
    public function view($id){
        $articles = TableRegistry::getTableLocator()->get('Articles');
        if ($this->request->is(['get']) && $id) {
            $article = $articles->find('all')->where(['id' => $id])->first();
            if($article){
                $this->response = $this->response->withStatus(200);
                $message = $article;
            } else {
                $this->response = $this->response->withStatus(400);
                $message = 'Article not found';
            }
            $this->set('data', $message);
            $this->viewBuilder()->setOption('serialize', 'data');
        }
    }

    public function delete($id){
        $articles = TableRegistry::getTableLocator()->get('Articles');
        if ($this->request->is(['delete']) && $id) {
            $jwtToken = $this->request->getHeaderLine('Authorization');
            if (strpos($jwtToken, 'Bearer ') === 0) {
                $jwtToken = substr($jwtToken, 7);
                $key = file_get_contents(CONFIG. '/jwt.pem');
                $decodedToken = JWT::decode($jwtToken, new Key($key, 'RS256'));
                if($decodedToken && $decodedToken->sub){
                    $article = $articles->find('all')->where(['id' => $id])->first();
                    if($article->user_id == $decodedToken->sub){
                        if ($articles->delete($article)) {
                            $this->response = $this->response->withStatus(200);
                            $message = 'Article Deleted';
                        } else {
                            $this->response = $this->response->withStatus(400);
                            $message = 'Error Deleting article';
                        }
                    } else {
                        $this->response = $this->response->withStatus(401);
                        $message = 'You are not Authorized to Update Article';
                    }
                } else {
                    $this->response = $this->response->withStatus(403);
                    $message = 'Invalid Token';
                }
            } 
            $this->set('data', $message);
            $this->viewBuilder()->setOption('serialize', 'data');
        }
    }
}