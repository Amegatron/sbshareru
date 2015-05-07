<?php

class PlanetEventHandler {
    public function onPlanetAdded($planet) {
        // Update planets counter
        if (Cache::has(Planet::$counterCacheKey)) {
            $counter = Cache::get(Planet::$counterCacheKey);
        } else {
            $counter = Planet::count();
        }

        $counter++;
        Cache::forever(Planet::$counterCacheKey, $counter);

        // Update last update info
        Cache::forever(Planet::$lastUpdateCacheKey, $planet->created_at);

        // Send notification to admin
        if (Config::get('app.notifyAdminAboutNewPlanets')) {
            try {
                Mail::queue(
                    'emails/newplanet',
                    array(
                        'planet'    => $planet,
                        'user'      => Auth::user(),
                    ),
                    function($message) {
                        $message->to(Config::get('app.notifyAdminEmail'))->subject('Добавлена новая планета');
                    }
                );
            } catch (Exception $e) {

            }
        }
    }

    public function onPlanetDeleted() {
        if (Cache::has(Planet::$counterCacheKey)) {
            $counter = Cache::get(Planet::$counterCacheKey);
        } else {
            $counter = Planet::count();
        }

        $counter--;
        Cache::forever(Planet::$counterCacheKey, $counter);
    }

    public function subscribe($events) {
        $events->listen('planet.added', __CLASS__ . '@onPlanetAdded');
        $events->listen('planet.deleted', __CLASS__ . '@onPlanetDeleted');
    }
} 
