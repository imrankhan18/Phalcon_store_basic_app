<?php

use Phalcon\Mvc\Controller;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Events\Manager as EventsManager;

class ComponentsController extends Controller
{
    /**
     * index
     */

    public function indexAction()
    {

    }
    /**
     * components and actions
     *
     * @return void
     */
    public function compoAction()
    {
        // print_r($_POST['components']);
        // die;
        $components= new Components();
        $components->assign(
            $this->request->getPost(),
            ['components','actions']
        );
        $components->save();
        $this->response->redirect('components');
    }
}