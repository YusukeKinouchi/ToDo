<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterController extends Controller
{
    public function tweet(Request $request)
    {
        $twitter = new TwitterOAuth(
            env('TWITTER_CONSUMER_KEY'),
            env('TWITTER_CONSUMER_SECRET'),
            env('TWITTER_ACCESS_TOKEN'),
            env('TWITTER_ACCESS_SECRET')
        );

        $twitter->post("statuses/update", [
            "status" =>'twitter post test'
        ]);
    }
}