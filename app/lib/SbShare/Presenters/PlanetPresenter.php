<?php namespace SbShare\Presenters;

class PlanetPresenter extends BasePresenter {

    protected function getCommentAttribute() {
        $comment = $this->model->comment;
        $comment = \BBCoder::convert($comment);
        $comment = self::parseEmojies($comment);

        return $comment;
    }

    protected function getTagsAttribute() {
        $tags = $this->model->tags;
        return TagPreviewPresenter::instances($tags);
    }

    protected function getCommentsAttribute() {
        $comments = $this->model->comments;
        return CommentPresenter::instances($comments);
    }

    protected function getAuthorAttribute() {
        $author = $this->model->author;
        if ($author) {
            $username = $author->username;
        } else {
            $username = 'Аноним';
            if (\Auth::check() && \Auth::user()->isAdmin && $this->model->remote_addr) {
                $username .= ' (IP: ' . $this->model->remote_addr . ')';
            }
        }

        return $username;
    }
}
