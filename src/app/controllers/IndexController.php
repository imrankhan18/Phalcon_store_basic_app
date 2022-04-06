<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;

class IndexController extends Controller
{
    /**
     * indexAction
     *
     * @return void
     */
    public function indexAction()
    {
        $this->view->users = Users::find();
        if(!$this->cookies->has('remember-me'))
        {   
            return $this->response->redirect('/login');
        }
        
    }

    /**
     * Delete Users
     *
     * @param [type] $id
     * @return void
     */
    public function deleteAction($id)
    {   
        $user= new Users();
        $user->id=$id;
        $user->delete();
        $this->response->redirect('index');
    }
  /**
   * logout and delete cookies data
   *
   * @return void
   */
        public function logoutAction()
        {
            $this->session->destroy(); 
            $rememberMeCookie=$this->cookies->get('remember-me');
            $rememberMeCookie->delete();
            $this->response->redirect('login');
        }
}
