<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use Auth;
class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    public function index(Request $request,Topic $topic)
    {
        $topics = $topic->withOrder($request->order)->paginate(20);
        return view('topics.index',compact('topics'));
    }
    public function create(Topic $topic)
    {
        $categories = Category::all();
        return view('topics.create_and_edit',compact('topic','categories'));
    }

    public function show(Request $request,Topic $topic)
    {
        return view('topics.show',compact('topic'));
    }


    public function store( TopicRequest $topicRequest,Topic $topic)
    {
        $topic->fill($topicRequest->all());
        $topic->user_id = Auth::id();
        $topic->save();
        return redirect()->route('topics.show',$topic->id)->with('success','帖子创建成功！');
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
