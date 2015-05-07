<?php

class Tag extends Eloquent {
    protected $fillable = array("tag");

    public $timestamps = false;

    public static function add($tags = array()) {
        // Prepare $tags array
        $tags = array_map("trim", array_map("strtolower", $tags));

        // Find which tags already exist in DB
        $existingTags = self::select('id', 'tag')->whereIn("tag", $tags)->get();
        //die(dd(DB::getQueryLog()));

        // Prepare $existingTags for further use
        $tagsArray = array();
        foreach($existingTags as $tag) {
            $tagsArray[$tag->id] = $tag->tag;
        }

        // Calculate difference between existing tags and supplied $tags
        $tagsDiff = array_diff($tags, $tagsArray);

        // Add non-existing tags, also adding them to $tagsArray
        foreach($tagsDiff as $tag) {
            $tagEloquent = self::create(array("tag" => $tag));
            $tagsArray[$tagEloquent->id] = $tag;
        }

        // return resulting tag list
        return $tagsArray;
    }

    public function planets() {
        return $this->belongsToMany("Planet")->orderBy('created_at', 'DESC');
    }
}
