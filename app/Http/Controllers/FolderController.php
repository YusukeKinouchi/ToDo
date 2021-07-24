<?php

namespace App\Http\Controllers;

requiire_once('constant.php');

use App\Models\Folder;
use Illuminate\Http\Request;
use App\Http\Requests\CreateFolder;
use Illuminate\Support\Facades\Auth;
use Abraham\TwitterOAuth\TwitterOAuth;

class FolderController extends Controller
{
    public function create(CreateFolder $request)
    {
        $folder = new Folder();
        $folder->title = $request->title;
        Auth::user()->folders()->save($folder);

        $twitter = new TwitterOAuth(
            TWITTER_CONSUMER_KEY,
            TWITTER_CONSUMER_SECRET,
            TWITTER_ACCESS_TOKEN,
            TWITTER_ACCESS_SECRET
        );

        $twitter->post("statuses/update", [
            "status" =>'twitter post test'
        ]);

        return redirect()->route('tasks.index',[
            'folder' => $folder->id,
        ]);
    }

    public function showCreateForm(){
        return view('folders/create');
    }
}