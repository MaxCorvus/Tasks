<?php

namespace Models;
use DateTime;
class Comment
{

    public int $id;
    public int $post_id;
    public string $name;
    public string $text;
    public string $createdAt;

    public function __construct(int $post_id, string $name, string $text)
    {
        $this->post_id = $post_id;
        $this->name = $name;
        $this->text = $text;
        $this->createdAt = (new DateTime())->format("Y-m-d");
    }


}