<?php

namespace App\Http\Controllers;

use App\forum;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forums = Forum::all();
        return view('forum.index', compact('forums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $tags = Tag::all();
        return view('forum.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'judul'  => 'required',
            'description' => 'required',
            'tags' => 'required',
        ]);
        $forum = new Forum;
        $forum->user_id = Auth::user()->id;
        $forum->judul = $request->judul;
        $forum->slug = $request->judul;
        $forum->description = $request->description;

        $forum->save();
        $forum->tags()->sync($request->tags);
        return back()->withInfo('Pertanyaan berhasil dibuat');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function show(forum $forum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tags = Tag::all();
        $forum = Forum::find($id);
        return view('forum.edit', compact('forum', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'judul'  => 'required',
            'description' => 'required',
            'tags' => 'required',
        ]);
        $forum = Forum::find($id);
        $forum->user_id = Auth::user()->id;
        $forum->judul = $request->judul;
        $forum->slug = $request->judul;
        $forum->description = $request->description;
        $forum->tags()->sync($request->tags);
        $forum->save();
        return back()->withInfo('Pertanyaan berhasil di Update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function destroy(forum $forum)
    {
        //
    }
}
