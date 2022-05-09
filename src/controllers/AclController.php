<?php

use Phalcon\Mvc\Controller;
use Phalcon\Acl\Adapter\Memory;

class AclController extends Controller
{
    public function index()
    {    
        $aclFile = './security/acl.cache';
        if(true !== is_file($aclFile)){
 
            $acl = new Memory();
 
            $acl->addRole('admin');
            $acl->addRole('customer');
            $acl->addComponent('product',[
                'index',
                'search',
                'page',
            ]);
              $acl->allow('admin','*','*');
             $acl->allow('customer','product','*');
 
        file_put_contents(
        $aclFile,
        serialize($acl)
    );
 }
      else{
       $acl= unserialize(
           file_get_contents($aclFile)
       );
       }
            
    
    }}