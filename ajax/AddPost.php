<?php
include '../Models/CreatePostModel.php';
use \Models\CreatePostModel;

class AddPostController extends CreatePostModel{
    function getData(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['name']) && isset($_POST['context'])) {
                $name = htmlentities(trim($_POST['name']));
                $context = htmlentities(trim($_POST['context']));
                $error = '';
                if (strlen($name) < 3)
                    $error = 'Enter name more than 3 charters';
                else if (strlen($context) < 3)
                    $error = 'Enter post more than 3 charters';
                if($error != ''){
                    echo $error;
                    exit();
                }else{
                    $cpm = new CreatePostModel;
                    $cpm->createPost($name,$context);
                }
                echo true;
            }
        }
    }
}
$addPost = new AddPostController();
$addPost->getData();