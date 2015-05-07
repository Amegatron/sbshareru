<?php

class CommentsController extends BaseController {

    public function __construct() {
        // $this->beforeFilter('auth');
    }

    public function postAdd() {
        $rules = Comment::$validation;

        if (!Auth::check()) {
            $rules['captcha'] = array('required', 'captcha');
        }

        $validation = Validator::make(Input::all(), $rules);

        if ($validation->fails()) {
            return Redirect::to('planets/view/' . Input::get('planet_id'))
                ->withErrors($validation)
                ->withInput();
        }

        $data = Input::all();
        unset($data['captcha']);
        if (Auth::check()) {
            $data['user_id'] = Auth::user()->id;
        }
        $comment = Comment::create($data);
        if ($comment) {
            Event::fire('comment.added', array($comment));
        }
        return Redirect::to('planets/view/' . $data['planet_id']);
    }
}
