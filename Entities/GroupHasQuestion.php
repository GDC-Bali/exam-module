<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class GroupHasQuestion extends Model
{
    protected $fillable = [];

    protected $table = 'ms_group_has_question';
    public $timestamps = false;
    public function question(){
        return $this->hasMany(Question::class, 'question_id', 'id');
    }
}
