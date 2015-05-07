<?php namespace SbShare\Presenters;

class TagPreviewPresenter extends TagPresenter {

    protected function getLinkClass() {
        return parent::getLinkClass() . ' btn-xs';
    }
} 
