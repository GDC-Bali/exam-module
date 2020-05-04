<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $guarded = ['id'];
    protected $table = 'ms_question_option'; 
    public $incrementing = false;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) \Ramsey\Uuid\Uuid::uuid4();
        });
    }   
}
