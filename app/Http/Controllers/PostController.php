<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
// add new
use Illuminate\Database\QueryException;
use App\Http\Resources\PostResource;
use Carbon\Carbon;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * 暫不開
         * 回傳所有post資料
         */
        try {
            $data = Post::orderBy('id')->paginate(10);
        } catch(QueryException $e) {
            return $this->errorResponse($e);
        }
        
        return PostResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        /**
         * 偵測http的方法，是put表示要更新資料，不是就新建
         * 可以用UpdateOrCreat
         */
        
        try {
            // put方法，尋找那筆資料，若不是就新建instance
            $data = $request->isMethod('put') ? Post::findOrfail($request->id) : new Post;

            $data->message = $request->message;
            $data->updated_at = Carbon::now();
            $data->topic_id = $request->topic_id;
            $data->user_id = $request->user_id;
            $data->save();

        } catch(QueryException $e) {
            return $this->errorResponse($e);

        }
        
        return Response()->json(['success' => '成功']);;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $id)
    {
        // 回傳資料
        return new PostResource($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $id)
    {
        /**
         * 修改show_on欄位
         * show_on = 1 顯示
         * show_on = 0 不顯示
         */
        try {
            if($id->show_on == 0) { return response('已刪除', 200); }
            $id->show_on = 0;
            $id->updated_at = Carbon::now();
            $id->save();
        } catch(QueryException $e) {
            return $this->errorResponse($e);
        }
        
        return response('delete data', 200);
    }

    /**
     * Return error
     *
     * @param  QueryException $e
     * @return \Illuminate\Http\Response
     */
    public function errorResponse($e) 
    {
        return Response()->json(['error' => $e->getMessage()]);
    }
}
