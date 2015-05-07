<?php namespace SbShare\Presenters;

class CommentPresenter extends BasePresenter {

    protected function getCommentAttribute() {
        $comment = $this->model->comment;
        $comment = self::parseCommonMarkup($comment);
        return $comment;
    }

    protected function getPlanetAttribute() {
        $planet = $this->model->planet;
        return new PlanetPresenter($planet);
    }

    protected function getAuthorAttribute() {
        $author = $this->model->author;
        if ($author) {
            $username = $author->username;
        } else {
            $username = 'Аноним';
        }

        return $username;
    }
} 
