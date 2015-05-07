<?php namespace SbShare\Presenters;

class TagPresenter extends BasePresenter {

    protected function getTagAttribute() {
        $tag = $this->model->tag;
        $cssClass = $this->getLinkClass();
        return "<a class='{$cssClass}' href='/tag/" . urlencode($tag) . "'>" . htmlspecialchars($tag) . '</a>&nbsp;';
    }

    protected function getLinkClass() {
        return 'btn btn-default';
    }
} 
