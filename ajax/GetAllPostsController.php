<?php

namespace ajax;

include '../Models/CreatePostModel.php';

use \Models\CreatePostModel;

class GetAllPostsController extends CreatePostModel
{
    function getPosts()
    {
        echo json_encode(CreatePostModel::getAllPosts());
    }
}

$allPosts = new GetAllPostsController();
$allPosts->getPosts();