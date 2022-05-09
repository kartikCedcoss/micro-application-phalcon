<?php

use Phalcon\Mvc\Controller;
use Firebase\JWT\JWT;
class OrderController extends Controller
{
    public function index()
    {  
    }
    public function create($productName,$quantity,$token){
        
        $getcustomer = new \Api\Handler\MiddleWare();
        $customerName = $getcustomer->getCustomer($token);
        $orderid=uniqid("ordr");
        $collection = $this->mongo->test->orders;
        $insertOneResult = $collection->insertOne([
         'id'=>$orderid,
         'customerName'=>$customerName,
         'productName'=>$productName,
         'quantity'=>$quantity,
         'status'=>'paid',
        ]);
        if($insertOneResult){
           echo "your order id is:- ".$orderid;
        }
    }
    public function update($id,$status){
    $collection = $this->mongo->test->orders;
    $result = $collection->updateOne(["id"=>$id],['$set'=>["status"=>$status]]);
    if($result){
        echo "product Updated";
    }
    }
}