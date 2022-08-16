<?php

namespace Routes;
use Models\Comment;
use Repositories\CommentRepository;
use Repositories\PostRepository;
use Models\Post;
class Controller
{
    private $commentRepository;
    private $postRepository;
    public function __construct()
    {
        $this->commentRepository = new CommentRepository();
        $this->postRepository = new PostRepository();
    }

    public function getPosts()
    {
        $posts = $this->postRepository->list();
        $comments = $this->commentRepository->getComments();
        foreach ($posts as &$post) {
            $post['comments'] = [];
            foreach ($comments as $comment) {

                if ( $post['id'] == $comment['post_id']) {
                    array_push($post['comments'], $comment);
                }
            }
        }
        return $posts;
//        OR
//        foreach ($posts as &$post) {
//            $post['comments'] = $this->commentRepository->getComments($post['id']);
//        }
//        return $posts;
    }

    public function addPost()
    {

        $post = new Post($_POST['name'], $_POST['text']);
        $this->postRepository->save($post);
    }

    public function addComment()
    {
        $comment = new Comment($_POST['post_id'], $_POST['name'], $_POST['text']);
        $this->commentRepository->save($comment);
    }
    public function addRate() {
        $post = $this->postRepository->getPost($_POST['post_id']);
        $post->calcRate($_POST['value']);
        $this->postRepository->update($post);
    }
}