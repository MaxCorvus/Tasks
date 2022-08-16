<?php

namespace Repositories;
use DbConnection\Db;
use Models\Post;
use PDO;
class PostRepository
{
public $posts;
public $db;

public function __construct() {
    $this->db = new Db();
}

public function list() {
    return $this->db->select("SELECT * FROM post ORDER BY id desc");
}
public function save(Post $post ) {
    $this->db->insert('post',
        [
        'name' => "$post->name",
        'text' => "$post->text",
        'created_at' => "$post->createdAt",
        'rate' => $post->rate,
        'rate_count' => $post->rateCount
    ]
    );
}
    public function getPost(int $post_id) {
        $postData = $this->db->select("SELECT * FROM post WHERE id=$post_id");

        return new Post(
            $postData[0]['name'],
            $postData[0]['text'],
            $postData[0]['rate'],
            $postData[0]['rate_count'],
            $postData[0]['created_at'],
            $postData[0]['id']);
    }
    public function update(Post $post) {
    $this->db->update('post', [
        'name' => "$post->name",
        'text' => "$post->text",
        'created_at' => "$post->createdAt",
        'rate' => $post->rate,
        'rate_count' => $post->rateCount
    ],
    "id=$post->id");
    }

}