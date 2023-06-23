<?php

use Phalcon\Mvc\Controller;


class BlogController extends Controller
{
    public function indexAction()
    {
        $data = $this->mongo->blog->find(array("user" => new MongoDB\BSON\ObjectId($this->session->get('id'))));
        foreach ($data as $value) {
            $this->view->blog .= "<div class='col-lg-4 col-md-12 mb-4'>
            <div class='cards'>
                <div class='bg-image hover-overlay ripple' data-mdb-ripple-color='light'>
                    <img src=".$value->image." class='img-fluid' />
                    <a href=''>
                        <div class='mask' style='background-color: rgba(251, 251, 251, 0.15);'></div>
                    </a>
                </div>
                <div class='card-body'>
                    <h5 class='card-title'>Title: ".$value->title."</h5>
                    <p class='card-text'>Price: ".$value->data."₹</p>
                </div>
                <div>
                    <a class='btn btn-warning' href='/blog/edit?id=$value->_id'>Edit</a>
                    <a class='btn btn-danger' href='/blog/delete?id=$value->_id'>Delete</a>
                </div>
            </div>
        </div>";
        }
    }
    public function addAction()
    {
        $arr = [
            'title' => $_POST['title'],
            'data' => $_POST['data'],
            'image' => $_POST['image'],
            'user' => $this->session->get('id')
        ];
        $success = $this->mongo->blog->insertOne($arr);
        if ($success) {
            $this->response->redirect("/blog ");
        }
    }
    public function editAction()
    {
        $this->view->data = $this->mongo->blog->findOne(array("_id" => new MongoDB\BSON\ObjectId($_GET['id'])));
    }
    public function updateAction()
    {
        $success = $this->mongo->blog->
        updateOne(array("_id" => new MongoDB\BSON\ObjectId($_GET['id'])), array('$set' => $_POST));
        if ($success) {
            $this->response->redirect("/blog");
        }
    }
    public function deleteAction()
    {
        $success = $this->mongo->blog->deleteOne(array("_id" => new MongoDB\BSON\ObjectId($_GET['id'])));
        if ($success) {
            $this->response->redirect("/blog");
        }
    }
}
