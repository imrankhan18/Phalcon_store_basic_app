<?php


use Phalcon\Mvc\Controller;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream ;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class SignupController extends Controller
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
     * add users in db
     */

    public function registerAction()
    {
        
        $userdata= $this->request->getPost();
        $user = new Users();
    
        $user->name=$this->escaper->escapeHtml($userdata['name']);
        $user->email=$this->escaper->escapeHtml($userdata['email']);
        $user->password=$this->escaper->escapeHtml($userdata['password']);
        $user->role=$this->escaper->escapeHtml($userdata['role']);
        $user->assign(
            $this->request->getPost(),
            [
            'name',
            'email' , 
            'password',
            'role'
            ]
        );
            $success=$user->token=$this->tokenByThirdParty($userdat['name'], $userdata['role']);
            $user->save();
            $this->response->redirect('signup');


        $success = $user-> save();

        $this->view->success = $success;

        if ($success) {
            $this->view->message = "Register succesfully";
        } else {
            $this->view->message = "Not Register succesfully due to following reason: <br>".implode("<br>", $user->getMessages());
            $message = implode(" & ", $user->getMessages());
            $adapter = new Stream('../app/logs/login.log');
            $logger = new Logger(
                'messages',
                [
                    'main'=>$adapter,
                ]
            );
               $logger->error($message);
        }
    }
    /**
     * get token by JWT
     *
     * @param [type] $name
     * @param [type] $role
     * @return void
     */
    public function tokenByThirdParty($name, $role)
    {


        $key = "example_key";
        $payload = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000,
            "name" => $name,
            "sub" => $role
        );


        $jwt = JWT::encode($payload, $key, 'HS256');
   
         return $jwt;
    }
}
