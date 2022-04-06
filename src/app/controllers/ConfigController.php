<?php
use Phalcon\Mvc\Controller;

class ConfigController extends Controller
{
    /**
     * config Trial
     *
     * @return void
     */
    public function indexAction()
    {
        $config=$this->di->get('config');
        $this->view->name=$config->app->name;
        $this->view->version=$config->app->version;
        
        
    }
}
