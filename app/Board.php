<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    //
    protected $table = 'board';
    protected $primaryKey = 'id';

    /** 定義一對多關聯
     *  一個Board可以有許多個Topic
     * 
     */
    public function topic() {
        return $this->hasMany("App\Topic");
    }
}
