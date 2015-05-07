<?php

class Comment extends Eloquent {

    public static $validation = array(
        'comment'   => 'required',
        'planet_id' => 'exists:planets,id'
    );

    protected $table = 'comments';
    protected $guarded = array();

    public function author() {
        return $this->belongsTo('User', 'user_id');
    }

    public function planet() {
        return $this->belongsTo('Planet');
    }
}
