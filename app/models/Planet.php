<?php

class Planet extends Eloquent {
    protected $table = 'planets';
    // protected $guarded = array();
    protected $fillable = array(
        'sector',
        'level',
        'star',
        'system',
        'planet',
        'biome',
        'x',
        'y',
        'version',
        'os',
        'comment',
        'user_id',
        'remote_addr',
    );

    public static $validation = array(
        'sector'    => 'in:alpha,beta,gamma,delta,x',
        'level'     => 'required|integer|min:1|max:10',
        'star'      => 'required',
        'system'    => 'required',
        'planet'    => 'required',
        'biome'     => 'in:arid,asteroid,desert,forest,grasslands,jungle,magma,moon,savannah,snow,tentacle,tundra,volcano',
        'x'         => 'required|integer',
        'y'         => 'required|integer',
        'version'   => 'in:enraged_koala',
        'os'        => 'in:windows,linux,mac',
        'comment'   => 'required',
    );

    public static $sectors = array(
        'alpha' => 'Alpha',
        'beta'  => 'Beta',
        'gamma' => 'Gamma',
        'delta' => 'Delta',
        'x'     => 'X',
    );

    public static $bioms = array(
        'arid'          => 'Arid',
        'asteroid'      => 'Asteroid Fields',
        'desert'        => 'Desert',
        'forest'        => 'Forest',
        'grasslands'    => 'Grasslands',
        'jungle'        => 'Jungle',
        'magma'         => 'Magma',
        'moon'          => 'Moon',
        'savannah'      => 'Savannah',
        'snow'          => 'Snow',
        'tentacle'      => 'Tentacle',
        'tundra'        => 'Tundra',
        'volcano'       => 'Volcano',
    );

    public static $versions = array(
        'enraged_koala' => 'Enraged Koala',
    );

    public static $oses = array(
        'windows'   => 'Windows',
        'linux'     => 'Linux',
        'max'       => 'Max OS',
    );

    public  static $counterCacheKey = 'planets_counter';

    public static $lastUpdateCacheKey = 'last_update';

    public function author() {
        return $this->belongsTo('User', 'user_id');
    }

    public function comments() {
        return $this->hasMany('Comment', 'planet_id');
    }

    public function scropOfAuthor($author_id) {
        return $this->where('author_id', '=', $author_id);
    }

    public function delete() {
        // Delete all planet's tags links
        // $this->tags->sync(array());
        DB::table('planet_tag')
            ->where('planet_id', '=', $this->id)
            ->delete();

        // $this->comments()->delete();
        Comment::where('planet_id', '=', $this->id)->delete();

        parent::delete();
    }

    public function tags() {
        return $this->belongsToMany("Tag")->orderBy("tag");
    }
}
