<?php

use Phalcon\Mvc\Controller;


class LoginController extends Controller
{
    public function indexAction()
    {
        // Redirect to view
    }
    public function checkAction()
    {
        $check = $this->mongo->user->findOne(['$and' => [
            ['email' => $_POST['email']],
            ['password' => $_POST['password']]
        ]]);
        if ($check['_id']) {
            if ($check['type'] == 'admin') {
                $this->response->redirect('/admin');
            } else {
                $this->session->set('id', $check['_id']);
                $this->logger
                    ->excludeAdapters(['error'])
                    ->info("Login Successful => Name: " . $check["name"] . " Email: " . $check["email"]);
                $this->response->redirect('/index/login');
            }
        } else {
            $this->logger
                ->excludeAdapters(['login'])
                ->error("Authentication Failed => Email: " . $_POST["email"] . " Password: " . $_POST["password"]);
            $this->response->redirect('/login');
        }
    }
}
