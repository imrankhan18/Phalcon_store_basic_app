<?php

use Phalcon\Mvc\Controller;


class OrderController extends Controller
{
    /**
     * order index
     *
     * @return void
     */
    public function indexAction()
    {
        

    }

    public function orderAction()
    {
        /**
         * adding order
         */
        $order = new Orders();
        $order->assign(
            $this->request->getPost(),
            ['name', 'address' , 'zipcode','dropdown','quantity']
        );

        $values = Settings::find('id = 1');
        $eventsManager = $this->di->get('EventsManager');
        $val = $eventsManager->fire('Handle:checkz', $order, $values);
        $success = $val->save();
    }
    /**
     * show order
     *
     * @return void
     */
    public function showorderAction()
    {
        echo "<h1 style='text-align:center'>Order Details</h1>";
        $orders= $this->view->orders = Orders::find();
        if ($orders->count() > 0) {
            ?>
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                <tr>
                    <th>Order ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Zipcode</th>
                    <th>Quantity</th>
                    <th>Product Name</th>
                    <th>Action</th>

                </tr>
                </thead>
                <tfoot>
                <tr>
                    <td colspan="3">orders quantity: <?php echo $orders->count(); ?></td>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($orders as $order) { ?>
                    <tr>
                        <td><?php echo $order->orderid; ?></td>
                        <td><?php echo $order->name; ?></td>
                        <td><?php echo $order->address; ?></td>
                        <td><?php echo $order->zipcode; ?></td>
                        <td><?php echo $order->quantity; ?></td>
                        <td><?php echo $order->productname; ?></td>
                        <td><?php echo $this->tag->linkTo([
                                'edit/index/'.$order->orderid,
                                'Edit', 'class' => 'btn btn-primary' ]);?>
                        <?php echo $this->tag->linkTo([
                                'order/delete/'.$order->orderid,
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
     * delete order by id
     *
     * @param [type] $orderid
     * @return void
     */
    public function deleteAction($orderid)
    {   
        $order= new Orders();
        $order->orderid=$orderid;
        $order->delete();
        $this->response->redirect('index');
    }
}
