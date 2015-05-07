<?php namespace SbShare\Presenters;

class NewsPresenter extends BasePresenter {

    protected function getNewsAttribute() {
        return static::parseCommonMarkup($this->model->news);
    }

    protected function getAuthorAttribute() {
        return $this->model->author->username;
    }
} 
