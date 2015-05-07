<?php

class News extends Eloquent {
    protected $table = 'news';
    protected $fillable = array('user_id', 'news');

    public static $validation = array(
        'news'  => 'required',
    );

    public function author() {
        return $this->belongsTo('User', 'user_id');
    }

    public function scopeLatest($query) {
        $query->orderBy('created_at', 'DESC')->limit(5);
    }
} 
