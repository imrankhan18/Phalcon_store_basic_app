<?php

use Phalcon\Mvc\Controller;

class EdituserController extends Controller
{
    /**
     * Edit user 
     *
     * @param [type] $id
     * @return void
     */
    public function indexAction($id)
    {
        $this->view->id=$id;

    }
    /**
     * after edit update in db
     *
     * @param [type] $id
     * @return void
     */
    public function edituserAction($id)
    {


        $edituser= Users::findFirst($id);
        $edituser->name=$this->request->getPost('name');
        $edituser->email=$this->request->getPost('email');
        $edituser->password=$this->request->getPost('password');
        $edituser->update();
        $this->response->redirect('index');
    }
}
