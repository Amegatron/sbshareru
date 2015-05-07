<?php namespace SbShare\Presenters;


class PlanetSummaryPresenter extends PlanetPresenter {

    protected function getCommentAttribute() {
        $regexp = "/\[\/?.*?\]/is";
        $comment = htmlspecialchars($this->model->comment);
        $comment = preg_replace($regexp, "", $comment);
        $comment = \Str::words($comment, 40);
        $comment = self::parseEmojies($comment);
        $comment = self::parseMentions($comment);
        return $comment;
    }

    protected function getAuthorAttribute() {
        $author = $this->model->author;
        if ($author) {
            return $author->username;
        } else {
            return 'Аноним';
        }
    }
}
