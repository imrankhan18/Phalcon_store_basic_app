<?php

use Phalcon\Mvc\Controller;

class EditController extends Controller
{
    /**
     * View page
     *
     * @param [type] $orderid
     * @return void
     */
    public function indexAction($orderid)
    {
        
        $this->view->orderid=$orderid;
      

     
    }
    /**
     * Edit order and update in db
     *
     * @param [type] $orderid
     * @return void
     */
    public function editAction($orderid)
    {

        $editorder= Orders::findFirst($orderid);
        $editorder->name=$this->request->getPost('name');
        $editorder->address=$this->request->getPost('address');
        $editorder->zipcode=$this->request->getPost('zipcode');
        $editorder->qauntity=$this->request->getPost('quantity');
        $editorder->productname=$this->request->getPost('productname');
        $editorder->update();
        $this->response->redirect('index');
    }
    
}
