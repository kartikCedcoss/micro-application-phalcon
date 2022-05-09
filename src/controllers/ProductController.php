<?php

use Phalcon\Mvc\Controller;
use Firebase\JWT\JWT;
class ProductController extends Controller
{
    public function index()
    {    
        $a=[];
        $collection = $this->mongo->test->products;
        $result = $collection->find();
        foreach($result as $v){
            array_push($a,$v);
        }
        echo json_encode($a);
    }


    public function search($product) {
        $product= urldecode($product);
        $product = explode(" ",$product);
        $flag = 0;
        for($i=1;$i<=sizeof($product);$i++){
            $flag=$flag+1;   
        }
        $a=[];
        $collection = $this->mongo->test->products;
        $result = $collection->find(["name"=>new \MongoDB\BSON\Regex($product[0],"i")]);
        foreach($result as $v){
            array_push($a,$v);
        }
        if($flag == 2&&$product[1]!=""){
        $result1 = $collection->find(["name"=>new \MongoDB\BSON\Regex($product[1],"i")]);
        foreach($result1 as $v1){
            array_push($a,$v1);
        }
        }
        $result2=$collection->find(["variations"=>new \MongoDB\BSON\Regex($product[0],"i")]);
        foreach($result2 as $v2){
            array_push($a,$v2);
        }
        if($flag == 2&&$product[1]!=""){
            $result3 = $collection->find(["variations"=>new \MongoDB\BSON\Regex($product[1],"i")]);
            foreach($result3 as $v3){
                array_push($a,$v3);
            }
        
    }
        echo json_encode($a);
    }
 
    public function page($perPage,$page){
         $perPage = intval($perPage);
         $page = intval($page)-1;  
         $page=$perPage*$page;   
        $a=[];
        $query=[];
        $collection = $this->mongo->test->products;
        $result = $collection->find($query,["limit"=>$perPage,"skip"=>$page]);
        foreach($result as $v){
            array_push($a,$v);
        }
        echo json_encode($a);
    }

}