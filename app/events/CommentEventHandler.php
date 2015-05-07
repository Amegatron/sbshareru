<?php

class CommentEventHandler {
    public function onCommentAdded(Comment $comment) {
        DB::table('planets')
            ->where('id', $comment->planet_id)
            ->update(array(
                'comments_count' => DB::raw('comments_count + 1'),
                'updated_at'     => new \Carbon\Carbon(),
            ));
    }

    public function subscribe($events) {
        $events->listen('comment.added', 'CommentEventHandler@onCommentAdded');
    }
} 
