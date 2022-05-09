<?php

namespace Api\Handler;


class Product{
    function find($select="",$where="",$limit=10,$page=1){
        $products = array(
            "select"=>$select,"where"=>$where,"limit"=>$limit,"page"=>$page
        );

        return json_encode($products);
    }
    function get($select="",$where="",$limit=10,$page=1){
        $products = array(
            "select"=>$select,"wheres"=>$where,"limits"=>$limit,"pages"=>$page
        );

        return json_encode($products);
    }
}