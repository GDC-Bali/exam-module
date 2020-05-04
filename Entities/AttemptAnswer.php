<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class AttemptAnswer extends Model
{
    protected $guarded = ['id'];
    protected $table = 'ms_attempt_answer';
    public $incrementing = false;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) \Ramsey\Uuid\Uuid::uuid4();
        });
    }

    public function attempt()
    {
        return $this->belongsTo(Attempt::class, 'attempt_id');
    }

    public function question()
    {
        return $this->hasOne(Question::class, 'id','question_id');
    }   

    public function option()
    {
        return $this->hasOne(QuestionOption::class, 'id','question_option_id');
    }
}
