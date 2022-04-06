<?php 


use Phalcon\Mvc\Controller;

class DashboardController extends Controller
{
    /**
     * show users details on index page
     *
     * @return void
     */
    public function indexAction()
    {
        $this->view->users = Users::find();
    }

}
