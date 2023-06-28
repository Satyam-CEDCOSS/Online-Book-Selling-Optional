<?php

use Phalcon\Mvc\Controller;


class AdminController extends Controller
{
    public function indexAction()
    {
        $data = $this->mongo->blog->find();
        foreach ($data as $value) {
            $this->view->blog .= "<div class='col-lg-4 col-md-12 mb-4'>
            <div class='card'>
                <div class='bg-image hover-overlay ripple' data-mdb-ripple-color='light'>
                    <img src=" . $value->image . " class='img-fluid'/>
                    <a href=''>
                        <div class='mask' style='background-color: rgba(251, 251, 251, 0.15);'></div>
                    </a>
                </div>
                <div class='card-body'>
                    <h5 class='card-title'>Title: " . $value->title . " </h5>
                    <p class='card-text'>Price: " . $value->data . "₹</p>
                </div>
            </div>
        </div>";
        }
    }
    public function orderAction()
    {
        $data = $this->mongo->order->find();
        foreach ($data as $value) {
            $this->view->blog .= "<div class='col-lg-4 col-md-12 mb-4'>
            <div class='card'>
                <div class='bg-image hover-overlay ripple' data-mdb-ripple-color='light'>
                    <img src=" . $value->image . " class='img-fluid' />
                    <a href=''>
                        <div class='mask' style='background-color: rgba(251, 251, 251, 0.15);'></div>
                    </a>
                </div>
                <div class='card-body'>
                    <h5 class='card-title'>Title: " . $value->title . "</h5>
                    <p class='card-text'>Price: " . $value->price . "₹</p>
                </div>
            </div>
        </div>";
        }
    }
    public function userAction()
    {
        $data = $this->mongo->user->find(array("type"=>"user"));
        foreach ($data as $value) {
            $this->view->blog .= "
            <tr>
            <td>$value->name</td>
            <td>$value->email</td>
            <td>$value->type</td>
            </tr>
            ";
        }
    }
    public function blogAction()
    {
        $data = $this->mongo->blog->find();
        foreach ($data as $value) {
            $this->view->blog .= "<div class='col-lg-4 col-md-12 mb-4'>
            <div class='cards'>
                <div class='bg-image hover-overlay ripple' data-mdb-ripple-color='light'>
                    <img src=" . $value->image . " class='img-fluid' />
                    <a href=''>
                        <div class='mask' style='background-color: rgba(251, 251, 251, 0.15);'></div>
                    </a>
                </div>
                <div class='card-body'>
                    <h5 class='card-title'>Title: " . $value->title . "</h5>
                    <p class='card-text'>Price: " . $value->data . "₹</p>
                </div>
                <div>
                    <a class='btn btn-warning' href='/admin/edit?id=$value->_id'>Edit</a>
                    <a class='btn btn-danger' href='/admin/delete?id=$value->_id'>Delete</a>
                </div>
            </div>
        </div>";
        }
    }
    public function editAction()
    {
        $this->view->data = $this->mongo->blog->findOne(array("_id" => new MongoDB\BSON\ObjectId($_GET['id'])));
    }
    public function updateAction()
    {
        $success = $this->mongo->blog->updateOne(array("_id" => new MongoDB\BSON\ObjectId($_GET['id'])),
         array('$set' => $_POST));
        if ($success) {
            $this->response->redirect("/admin/blog");
        }
    }
    public function deleteAction()
    {
        $success = $this->mongo->blog->deleteOne(array("_id" => new MongoDB\BSON\ObjectId($_GET['id'])));
        if ($success) {
            $this->response->redirect("/admin/blog");
        }
    }
}
