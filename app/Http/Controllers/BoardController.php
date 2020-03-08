<?php

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;
// add new
use App\Http\Resources\BoardResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Topic;
use App\Http\Resources\TopicResource;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * 取得每個board的資料及相關聯的topic總數
         */
        try {
            $data = DB::table('BOARD')->select('BOARD.*', 'TOPIC.TOPIC_COUNT')
                           ->join(DB::raw('(SELECT BOARD_ID, COUNT(BOARD_ID) TOPIC_COUNT FROM TOPIC GROUP BY BOARD_ID) TOPIC'),
                              function($join) { $join->on('TOPIC.BOARD_ID', '=', 'BOARD.ID');})
                            ->get();
        } catch (QueryException $e) {
            return dd($e->getMessage());
        }

        return BoardResource::collection($data);
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
         * 目前不開
         * 整個邏輯可改用UpdateOrCreat取代 
         */

        $data = $request->isMethod('put') ? Board::findOrFail($request->id) : new Board;

        // 更改或新增
        try {
            $data->subject = $request->input('subject');
            $data->description = $request->input('description');
            $data->board_type = $request->input('board_type');
            $data->save();

        } catch (QueryException $e) {
            return dd($e->getMessage());
        }

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /**
         * 此為回傳board相關聯的topic
         * topic的資料且需要分頁，需用TopicResource整理要回傳的資料，並轉成JSON
         */
        try {
            $data = Topic::where('board_id', $id)
                  ->orderBy('id', 'desc')->paginate(5);
        } catch (QueryException $e) {
            dd($e->getMessage());
        }

        return TopicResource::collection($data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $id)
    {

        /**
         * 目前不開放
         * 此功能為修改show_on欄位為0
         * show_on = 1 顯示在頁面
         * show_on = 0 不顯示在頁面
         */
        try {
            $id->show_on = 0;
            $id->save();

        } catch (QueryException $e) {
            dd($e->getMessage());
        }
        
        return $id;
    }
}
