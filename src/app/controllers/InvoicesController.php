<?php

use Phalcon\Mvc\Controller;

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

/**
 * @property Request $request
 * @property View    $view
 */
class InvoicesController extends Controller
{
    /**
     * pagination but not used
     *
     * @return void
     */
    public function listAction()
    {
        $currentPage = $this->request->getQuery('page', 'int', 1);
        $paginator   = new PaginatorModel(
            [
                'model'  => Blogs::class,
                'limit' => 2,
                'page'  => $currentPage,
            ]
        );
        
        $page = $paginator->paginate();
        // print_r($page);
        // die();
        
        $this->view->setVar('page', $page);
    
    }
}