<?php



use Phalcon\Mvc\Controller;

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class ProductsController extends Controller
{
    /**
     * product index
     *
     * @return void
     */
    public function indexAction()
    {
       
    }
    /**
     * add products in db
     *
     * @return void
     */
    public function addAction()
    {
        $products = new Products();
        $products->assign(
            $this->request->getPost(),
            [ 'name', 'description' , 'tags','price','stock']
        );
        $values = Settings::find('id = 1');
        if($values){
        $eventsManager = $this->di->get('EventsManager');
        $val = $eventsManager->fire('Handle:checkzip', $products, $values);
        }
        $success=$val->save();
    }
    /**
     * display products
     *
     * @return void
     */
    public function displayAction()
    {
        echo "<h1 style='text-align:center'>Products Details</h1>";
        $products= $this->view->orders = Products::find();
        if ($products->count() > 0) {
            ?>
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Tag</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>

                </tr>
                </thead>
                <tfoot>
                <tr>
                    <td colspan="3">Products quantity: <?php echo $products->count(); ?></td>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($products as $p) { ?>
                    <tr>
                        <td><?php echo $p->productid; ?></td>
                        <td><?php echo $p->name; ?></td>
                        <td><?php echo $p->description; ?></td>
                        <td><?php echo $p->tags; ?></td>
                        <td><?php echo $p->price; ?></td>
                        <td><?php echo $p->stock; ?></td>
                        <td><?php echo $this->tag->linkTo([
                                'editproduct/index/'.$p->productid,
                                'Edit', 'class' => 'btn btn-primary' ]);?>
                        <?php echo $this->tag->linkTo([
                                'products/delete/'.$p->productid,
                                'Delete', 'class' => 'btn btn-danger' ]);?></td>
    
                    </tr>
                <?php
    }         ?>
                </tbody>
            </table>
            <?php
        }
}
/**
 * delete products
 *
 * @param [type] $productid
 * @return void
 */
    public function deleteAction($productid)
    {   
        $products= new Products();
        $products->productid=$productid;
        $products->delete();
        $this->response->redirect('index');
    }
}
