<?php

namespace Repositories;

use DbConnection\Db;
use Models\Comment;

class CommentRepository
{
    public $db;

    public function __construct() {
    $this->db = new Db();
    }

    public function getComments():array
    {
        return $this->db->select("SELECT * FROM comment");

//       return $this->db->select("SELECT * FROM comment WHERE post_id = $id");
    }
    public function save(Comment $comment) {
        $this->db->insert('comment',
            [
                "name" => $comment->name,
                "text" => $comment->text,
                "created_at" => $comment->createdAt,
                "post_id" => $comment->post_id
            ]
        );
    }
}