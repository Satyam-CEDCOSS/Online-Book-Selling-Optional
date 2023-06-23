<?php

use Phalcon\Mvc\Controller;


class IndexController extends Controller
{
    public function indexAction()
    {
        $data = $this->mongo->blog->find();
        foreach ($data as $value) {
            $this->view->blog .= "<div class='col-lg-4 col-md-12 mb-4'>
            <div class='card'>
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
            </div>
        </div>";
        }
    }
    public function loginAction()
    {
        $data = $this->mongo->blog->find();
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
                    <a class='btn btn-primary' href='/index/order?id=$value[_id]'>Buy Now</a>
                </div>
            </div>
        </div>";
        }
    }
    public function orderAction()
    {
        $data = $this->mongo->blog->findOne(array("_id" => new MongoDB\BSON\ObjectId($_GET['id'])));
        $arr = [
            "owner_id"=>$data->user,
            "purchaser_id"=>$this->session->get('id'),
            "title"=>$data->title,
            "price"=>$data->data,
            "image"=>$data->image,
        ];
        $success = $this->mongo->order->insertOne($arr);
        if ($success) {
            $this->response->redirect("/index/login");
        }
    }
}
