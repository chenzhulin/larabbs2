<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use Auth;
use App\Handlers\ImageUploadHandler;
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

    public function show(Topic $topic)
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
        $this->authorize('update',$topic);
        $categories = Category::all();
        return view('topics.create_and_edit',compact('topic','categories'));
    }

    public function update(TopicRequest $request,Topic $topic)
    {
        $this->authorize('update',$topic);
        $topic->update($request->all());
        return redirect()->route('topics.show',$topic->id)->with('success','帖子修改成功！');
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy',$topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('success','帖子已成功删除！');
    }

    //图片上传
    public function uploadImage( Request $request,ImageUploadHandler $uploader)
    {
        //初始化返回数据
        $data = [
            'success'=> false,
            'msg'    => '上传失败',
            'file_path'=>'',
        ];
        //判断是否有上传文件，并复制给$file
        if ($file =  $request->upload_file){
            //保存图片到本地
            $result = $uploader->save($request->upload_file,'topics',Auth::id(),1024);
            //图片保存成功的话
            if ($result){
                $data['file_path'] = $result['path'];
                $data['msg']     = '上传成功！';
                $data['success'] = true;
            }
        }
        return $data;
    }
}
