<?php

use Api\Handler\MiddleWare;
use Phalcon\Mvc\Controller;


class UserController extends Controller
{
    public function index()
    {    
        $name = $this->request->get('name');
        $pass = $this->request->get('password');
        $collection = $this->mongo->test->users;
        $result = $collection->findOne([ "name" =>$name,"password"=>$pass]);
        if($result){
          echo json_encode(array("Key"=>$result->token));
        }
        else{
            echo  'Wrong Credentials';
        }
    }
    public function signup(){
        
    }
   public function adminLogin(){

   }
   public function adminAuth(){
    
    $email = $this->request->getPost('email');
    $pass = $this->request->getPost('pass');
    $collection = $this->mongo->test->users;
    $result = $collection->findOne(["email"=>$email,"password"=>$pass]);
    if($result){
      if($result->role != "admin"){
        echo "Your are not the admin";
      }
      else{
        $collection = $this->mongo->test->orders;
        $orders = $collection->find();
        echo "<table><tr>
                <th>Customer name</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Status</th></tr>";
        foreach($orders as $v){
         echo "<tr><td>".$v->customerName."</td><td>".$v->productName."</td><td>".$v->quantity."</td><td>".$v->status ."</th></tr>";
        }
        echo "</table>";
      }
    }else{
      echo "Wrong Credentials";
    }

  }
    public function register(){
     
      $gettoken = new \Api\Handler\MiddleWare();
 
       $name= $this->request->get(urldecode('nameInput'));
       $email= $this->request->get(urldecode('emailInput'));
       $pass= $this->request->get(urldecode('passInput'));
       $token = $gettoken->accessToken($name);
       $collection = $this->mongo->test->users;
       $insertOneResult = $collection->insertOne([
        'name'=>$name,
        'email'=>$email,
        'password'=>$pass,
        'role'=>'customer',
        'token'=>$token,
       ]);
      if($insertOneResult){
       echo json_encode(array("Token id"=>$token));
      }
    }
    public function admin(){
      
    }
}