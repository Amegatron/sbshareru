<?php

class TagsController extends BaseController {

    public function getIndex() {
        $tags = Tag::orderBy('tag')->get();

        return View::make('tags/index', array(
            'tags'  => \SbShare\Presenters\TagPresenter::instances($tags),
        ));
    }

    public function getSuggest() {
        $term = Input::get('term');
        $tags = Tag::where('tag', 'LIKE', $term . '%')->get();

        $tagsArray = array();

        foreach($tags as $tag) {
            $tagsArray[] = $tag->tag;
        }

        return $tagsArray;
    }

    public function getView($tag) {
        $tagModel = Tag::whereTag($tag)->first();

        if (!$tagModel) {
            App::abort(404);
        }

        $planets = $tagModel->planets()->paginate(9);

        return View::make('tags/view', array(
            'tag'       => $tag,
            'planets'   => \SbShare\Presenters\PlanetSummaryPresenter::instances($planets),
        ));
    }
}
