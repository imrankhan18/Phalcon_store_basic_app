<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Phalcon\Http\Request;
class LoginController extends Controller
{
    /**
     * login index
     *
     * @return void
     */
    public function indexAction()
    {
    }
    /**
     * login,cookies and checking for admin role
     *
     * @return void
     */
    public function registerAction()
    {
        $userdetails = $this->request->getPost();
        $this->session->details=$userdetails;
        if(isset($_POST['remember']))
        {
            $this->cookies->set(
                'remember-me',
                json_encode(
                    ['email'=>$userdetails['email'],
                    'password'=>$userdetails['password']
                    ]),
                time() +(3600*2)
            );
            $this->cookies;
        }
        $result = Users::find(['conditions' => 'email = ?1 AND password =?2 AND role = ?3','bind'=> [1 => 'ikik@gmail.com',2 => '123',3=>'admin']]);
        $userdetails = $this->request->getPost();
        if ($result[0]->email == $userdetails['email'] && $result[0]->password == $userdetails['password'] && $result[0]->role == 'admin' ) {
            
            $this->response->redirect('index');
        } 
        elseif($userdetails['email'] =='' && $userdetails['password' ]=='')
        {
            $response = new Response(
                "Sorry, the page doesn't exist",
                404, 
                'Not Found'
            );
            $response->send();
            die();   
        }
        else{
            $response = new Response("Sorry, the page doesn't exist", 404, 'Not Found');
            $response->send();
            die();
        }
}
}
