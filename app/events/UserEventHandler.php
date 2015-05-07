<?php

class UserEventHandler {

    public function onUserActivated($user) {
        $users = Cache::get(User::CACHE_LIST_KEY);
        if ($users) {
            $users[] = $user->username;
            Cache::forever(User::CACHE_LIST_KEY, $users);
        }
    }

    public function onUsersMentioned($users) {
        // TODO: implement user notifacation on mention
    }

    public function subscribe($events) {
        $events->listen('user.activated', __CLASS__ . '@onUserActivated');
        $events->listen('user.mentioned', __CLASS__ . '@onUsersMentioned');
    }
} 
