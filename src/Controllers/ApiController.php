<?php

namespace Fighter\Controllers;

class ApiController extends Controller {

    public function index()
    {
        var_dump($this->request->post);
        return "first test";
    }
    public function getUserPostsByUserId($id,$postId){
        echo $id . '<br>'. $postId;
        return '';
    }
}