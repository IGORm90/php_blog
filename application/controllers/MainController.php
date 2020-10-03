<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Admin;

class MainController extends Controller{

      

   public function indexAction(){
      $Pagination = new Pagination($this->route, $this->model->postsCount(), 3);
      $vars = [
         'pagination' => $Pagination->get(),
         'list' => $this->model->postsList($this->route),
      ];
      $this->view->render('Главная страница', $vars);
   }

   public function aboutAction(){
      $this->view->render('Обо мне');
   }

   public function contactAction(){
      if(!empty($_POST)){
         if(!$this->model->contactValidate($_POST)){
            $this->view->message('error', 'error');
         }
         mail('igmuz90@gmail.com', 'сообщение из блога', $_POST['text'].','.$_POST['text']);
         $this->view->message('succcess', 'сообщение отправленно');
      }
         $this->view->render('Контакты');
   }

   public function postAction(){
      $adminModel = new Admin;
      if(!$adminModel->isPostExists($this->route['id'])){
         $this->view->errorCode(404);
      }
      $vars = [
         'data' => $adminModel->postData($this->route['id'])[0],
      ];
      $this->view->render('Пост', $vars);
   }

}