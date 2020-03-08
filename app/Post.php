<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = 'post';
    protected $primaryKey = 'id';

    protected $fillable = [
        'message', 'user_id', 'topic_id'
    ];

    /** 多對一
     *  許多Post屬於一個Topic
     */
    public function topic() {
        return $this->belongsTo('App\Topic');
    }

    /** 多對一
     *  許多個Post屬於一個user
     */
    public function user() {
        return $this->belongsTo('App\User');
    }
}
