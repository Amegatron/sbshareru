<?php

class IndexController extends BaseController {
    public function getIndex() {
        $planets = Planet::orderBy('created_at', 'DESC')->with('tags')->limit(6)->get();
        $latestComments = Comment::orderBy('created_at', 'DESC')->limit(5)->get();

        $totalPlanets = Cache::rememberForever(Planet::$counterCacheKey, function() {
            return Planet::count();
        });

        $lastUpdate = Cache::rememberForever(Planet::$lastUpdateCacheKey, function() {
            $planets = Planet::orderBy('created_at', 'DESC')->limit(1)->get();
            $planet = $planets[0];
            return $planet->created_at;
        });

        $latestNews = News::latest()->get();

        return View::make('index', array(
            'planets'       => \SbShare\Presenters\PlanetSummaryPresenter::instances($planets),
            'comments'      => \SbShare\Presenters\CommentPresenter::instances($latestComments),
            'counter'       => $totalPlanets,
            'lastUpdate'    => $lastUpdate,
            'news'          => \SbShare\Presenters\NewsPresenter::instances($latestNews),
        ));
    }

    public function getTestMail() {
        Mail::queue('emails/test', array(), function($message) {
            $message->to('amego2006@gmail.com')
                ->subject('Test mail from SBShare.ru');
        });

        return 'Mail was queued.';
    }
}
