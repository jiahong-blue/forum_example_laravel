<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    //
    protected $table = 'topic';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title', 'user_id', 'board_id'
    ];

    
    /** 一對多
     *  一個Topic有許多Post
     * 
     */
    public function post() {
        return $this->hasMany("App\Post");
    }
 
    /** 多對一
     *  許多topic屬於一個user
     *  
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /** 多對一
     *  許多topic屬於一個board 
     */
    public function board() {
        return $this->belongsTo('App\Boards', 'boards_id', 'id');
    }
    
}
