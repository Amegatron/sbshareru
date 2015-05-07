<?php

class PreviewController extends BaseController {

    public function make() {
        $text = Input::get('text');
        $text = \SbShare\Presenters\BasePresenter::parseCommonMarkup($text, $mentions, $authors);
        return array(
            'preview'   => $text,
        );
    }
} 
