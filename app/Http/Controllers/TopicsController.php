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

    public function index()
    {
        return view('topics.index');
    }
    public function show()
    {
        return view('topics.show');
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
