<?php

use Phalcon\Mvc\Controller;


class OrderController extends Controller
{
    public function indexAction()
    {
        $data = $this->mongo->order->find(array("owner_id" => new MongoDB\BSON\ObjectId($this->session->get("id"))));
        // print_r($this->session->get("id"));die;
        foreach ($data as $value) {
            // echo "<pre>";
            // print_r($value);die;
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
                    <p class='card-text'>Price: ".$value->price."₹</p>
                </div>
            </div>
        </div>";
        }
    }
}