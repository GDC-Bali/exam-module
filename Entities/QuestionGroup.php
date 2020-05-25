<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class QuestionGroup extends Model
{
    protected $guarded = ['id'];
    protected $table = 'ms_question_group';
    public $incrementing = false;
    public $keyType = 'string';
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) \Ramsey\Uuid\Uuid::uuid4();
        });
    }

    public function category()
    {
        return $this->hasOne(GroupCategory::class,'id','category_id');
    }

    public function questions()
    {
        if($this->first()->randomize_no == 1){
            return $this->belongsToMany(Question::class, 'ms_group_has_question', 'group_id', 'question_id')->inRandomOrder();
        }
        else {        
            return $this->belongsToMany(Question::class, 'ms_group_has_question', 'group_id', 'question_id');
        }
    }

    public function questions_no()
    {
        return $this->questions()->count();
    }

    public function questions_totalvalue()
    {
        return $this->questions()->sum('');
    }

    public function reorderQuestions()
    {
        foreach($this->questions() as $key=>$q)
        {
            $q->order = $key+1;
        }
    }
}
