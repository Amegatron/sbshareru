<?php

class PlanetsController extends BaseController {

    public function __construct() {
        // $this->beforeFilter('auth', array('only'  => array('getAdd', 'postAdd')));
    }

    public function getIndex() {
        $planets = Planet::orderBy('created_at', 'DESC')->with('tags');

        // Search
        if (Input::has('sector') && Input::get('sector') != 'any') {
            $planets->where('sector', '=', Input::get('sector'));
        }

        if (Input::has('level') && Input::get('level')) {
            $planets->where('level', '=', Input::get('level'));
        }

        if (Input::has('biome') && Input::get('biome') != 'any') {
            $planets->where('biome', '=', Input::get('biome'));
        }

        if (Input::has('version') && Input::get('version') != 'any') {
            $planets->where('version', '=', Input::get('version'));
        }

        if (Input::has('os') && Input::get('os') != 'any') {
            $planets->where('os', '=', Input::get('os'));
        }

        // Paginate
        $planets = $planets->paginate(Config::get('app.plantsPerPage'));
        $planets = \SbShare\Presenters\PlanetSummaryPresenter::instances($planets);

        if (Input::has('search')) {
            $params = Input::all();
            unset($params['page']);
            $planets->appends($params);
        }

        return View::make('planets/index', array(
            'planets'   => $planets,
        ));
    }

    public function getAdd() {
        return View::make('planets/add');
    }

    public function postAdd() {
        $rules = Planet::$validation;

        if (!Auth::check()) {
            $rules['captcha']   = array('required', 'captcha');
        }

        $validation = Validator::make(Input::all(), $rules);

        if ($validation->fails()) {
            return Redirect::to('planets/add')->withErrors($validation)->withInput();
        }

        $data = Input::all();
        unset($data['captcha']);
        if (Auth::check()) {
            $data['user_id'] = Auth::user()->id;
        } else {
            $data['remote_addr'] = $_SERVER['REMOTE_ADDR'];
        }
        $planet = Planet::create($data);

        $tags = Input::get('tags');
        if ($tags) {
            $tags = Tag::add($tags);
            $planet->tags()->sync(array_keys($tags));
        }

        Event::fire('planet.added', array($planet));

        return Redirect::to(action('PlanetsController@getView', array($planet->id)));
    }

    public function getView($planetId) {
        $planet = Planet::find($planetId);

        if (!$planet) {
            App::abort(404);
        }

        if (false === strpos($_SERVER['HTTP_USER_AGENT'], 'bot')) {
            $planet->views = $planet->views + 1;
            $planet->save();
        }

        $relatedPlantes = Planet::where('star', '=', $planet->star)
            ->where('version', '=', $planet->version)
            ->where('id', '!=', $planet->id)
            ->get();

        return View::make('planets/view', array(
            'planet'            => new \SbShare\Presenters\PlanetPresenter($planet),
            'relatedPlanets'    => $relatedPlantes,
        ));
    }

    public function getEdit($planetId) {
        $planet = Planet::find($planetId);

        if (!$planet) {
            App::abort(404);
        }

        if (Auth::user()->id == $planet->user_id || Auth::user()->isAdmin) {
            return View::make('planets/edit', array(
                'planet'    => $planet,
            ));
        } else {
            App::abort(403, 'Forbidden');
        }
    }

    public function postEdit($planetId) {
        $rules = Planet::$validation;

        $validation = Validator::make(Input::all(), $rules);

        if ($validation->fails()) {
            return Redirect::to('planets/edit')->withErrors($validation)->withInput();
        }

        $planet = Planet::find($planetId);

        if (!$planet) {
            App::abort(404);
        }

        if (Auth::user()->id == $planet->user_id || Auth::user()->isAdmin) {
            $planet->fill(Input::all());
            $planet->save();

            $tags = Input::get('tags');
            if ($tags) {
                $tags = Tag::add($tags);
                $planet->tags()->sync(array_keys($tags));
            }

            return Redirect::to(action('PlanetsController@getView', array($planetId)));
        } else {
            App::abort(403, 'Forbidden');
        }
    }

    public function getDelete($planetId) {
        $planet = Planet::find($planetId);

        if (!$planet) {
            App::abort(404);
        }

        if (Auth::user()->id == $planet->user_id || Auth::user()->isAdmin) {
            $planet->delete();
            Event::fire('planet.deleted');

            return Redirect::to('/');
        } else {
            App::abort(403, "Forbidden");
        }
    }
}
