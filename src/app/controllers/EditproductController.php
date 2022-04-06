<?php



use Phalcon\Mvc\Controller;

class EditproductController extends Controller
{
    /**
     * edit products with product ID
     *
     * @param [type] $productid
     * @return void
     */
    public function indexaction($productid)
    {
        $this->view->productid=$productid;
    }
    /**
     * update products
     *
     * @param [type] $productid
     * @return void
     */
    public function editproductAction($productid)
    {

        $editproduct= Products::findFirst($productid);
        $editproduct->productname=$this->request->getPost('productname');
        $editproduct->quantity=$this->request->getPost('quantity');
        $editproduct->description=$this->request->getPost('description');
        $editproduct->price=$this->request->getPost('price');
        $editproduct->update();
        $this->response->redirect('index');
    }
}