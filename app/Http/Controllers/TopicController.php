<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;
// add new
use App\Http\Resources\TopicResource;
use Illuminate\Database\QueryException;
use App\Post;
use App\Http\Resources\PostResource;
use App\Http\Resources\TopicPostResource;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        /**
         * 回傳與topic相關聯的post
         */
        try {
            $data = Post::where('topic_id', $id)->orderBy('id')->paginate(5);
        } catch(QueryException $e) {
            return Response()->json(['error' => $e->getMessage()]);
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
        // 還未修正
        // 新建或更改會一同更新相對的post
        if ($request->isMethod('put')) {
            // 要再建form防止非前端新增
            $topicData = Topic::findOrFail($request->id);
            $topicData->title = $request->title;
            $topicData->updated_at = Carbon::now();
            $topicData->save();
            
            $postData = $topicData->post()->first();
            $postData->message = $request->message;
            $postData->updated_at = Carbon::now();
            $postData->save();

        } else {
            // 建topic
            try {
                $topicData = Topic::create(['user_id' => $request->user_id,
                                        'title' => $request->title, 
                                        'board_id' => $request->board_id, 
                                        ]);

                $postData = Post::create(['topic_id' => $topicData->id, 
                                        'message' => $request->message,
                                        'user_id' => $request->user_id
                                        ]);

            } catch (QueryException $e) {
                return $e->getMessage();
            }

            return new TopicResource($topicData);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        /**
         * 回傳與topic相關聯的第一個post
         */

        $data = Topic::findOrfail($id)->post->first();

        return new TopicPostResource($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $id)
    {
        /**
         * 修改show_on欄位
         * show_on = 1 顯示
         * show_on = 0 不顯示
         * 
         */
        try {
            $id->show_on = 0;
            $id->save();
        } catch(QueryException $e) {
            return Response()->json(['error' => $e->getMessage()]);
        }

    }
}
