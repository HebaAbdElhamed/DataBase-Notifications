<?php

namespace App\Http\Controllers;



use auth;
use App\Models\User;
use App\Models\posts;
use Illuminate\Http\Request;
use App\Notifications\CreatePost;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;

class PostsController extends Controller
{
    public function create(){
        return view('posts.create');
    }

    public function store(Request $request){
        $post= posts::create([
            'title'=>$request->title,
            'body'=>$request->body,
        ]);

        $users_create = auth()->User()->name;
        $users= User::where('id','!=',auth()->User()->id)->get();
        Notification::send($users,new CreatePost($post->id,$users_create,$post->title));
        
        return redirect()->route('dashboard');
    }

    public function show($id){
        $post = posts::findorFail($id);
        $getID = DB::table('notifications')->where('data->post_id', $id)->pluck('id');
        DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
        
        return redirect()->route('dashboard');
    }

    public function markAsRead(){
        $user = User::find(auth()->User()->id);
        foreach ($user->unreadNotifications as $notification){
            $notification -> markAsRead();
        }
        
        return redirect()->back();
    }
} 