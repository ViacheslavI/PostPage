<?php


namespace Models;

require_once '../core/sql_conn.php';

use \core\sql_conn;
use PDO;


class CreatePostModel extends sql_conn
{

    function createPost($name, $context)
    {
        $sql = 'INSERT INTO `posts`(author,context,date) VALUES(?,?,?)';
        $query = sql_conn::conn()->prepare($sql);
        $query->execute([$name, $context, time()]);
    }

    function getAllPosts()
    {
        $sql = 'SELECT * FROM posts';
        $query = sql_conn::conn()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function createComment($name, $context){

        $sql = 'INSERT INTO `comments`(name,content,date) VALUES(?,?,?)';
        $query = sql_conn::conn()->prepare($sql);
       $res= $query->execute([$name, $context, time()]);
       return true;
    }

}