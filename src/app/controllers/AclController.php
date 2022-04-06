<?php

use MyApp\Locale;
use Phalcon\Mvc\Controller;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;
use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

class AclController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function indexAction()
    {
        
    }
    /**
     * acl
     */
  
    public function aclAction()
    {
    

        $role=$this->request->getPost();
        $components=$this->request->getPost('components');
        $actions=$this->request->getPost('actions');
        // print_r($role['dropdown']);
        
        $r= $role['dropdown'];
        
        $aclfile = APP_PATH . '/security/acl.cache';
        if (true !== is_file($aclfile)) {

            $acl = new Memory();
            $acl->addRole('admin');
            $acl->addRole("$r");
            foreach($components as $comp )
            {
            foreach($actions as $act)
            {
                $acl->addComponent(
                    "$comp",
                    [
                        "$act",                    ]
                );
            $acl->allow($r, "$comp", "$act");
            }
        }
            $acl->allow('admin', "*", '*');
            



            file_put_contents(
                $aclfile,
                serialize($acl)
            );
        } else {
            $acl = unserialize(
                file_get_contents($aclfile)
            );

            file_put_contents(
                $aclfile,
                serialize($acl)
            );
        }
        echo "Granted Role Permissions";
           
    }
}
