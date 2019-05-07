<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request,Topic $topic)
    {
        $topics = $topic->withOrder($request->order)->paginate(20);
        return view('topics.index',compact('topics'));
    }
    public function show(Topic $topic)
    {
        return view('topics.show',compact('topic'));
    }
    public function create()
    {
        return view('topics.create_and_edit');
    }

    public function store()
    {
        return redirect()->route('topics.show');
    }

    public function edit(Topic $topic)
    {
        return view('topics.create_and_edit');
    }

    public function update(Topic $topic)
    {
        return redirect()->route('topics.show');
    }

    public function destroy(Topic $topic)
    {
        return redirect()->route('topics.index');
    }
}
