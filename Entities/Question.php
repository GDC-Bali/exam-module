<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = ['id'];
    protected $table = 'ms_question';
    protected $appends = ['totalscore'];
    public $incrementing = false;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) \Ramsey\Uuid\Uuid::uuid4();
        });
    }

    public function question_group(){
        return $this->belongsToMany(QuestionGroup::class, 'ms_group_has_question', 'question_id', 'group_id');
    }
    
    public function question_option(){
        if($this->first()->randomize_option == 1){
            return $this->hasMany(QuestionOption::class,'question_id')->inRandomOrder();
        } else {
            return $this->hasMany(QuestionOption::class,'question_id');
        }
    }

    public function getTotalscoreAttribute()
    {
        return $this->question_option()->sum('option_value');
    }

    public function category(){
        return $this->hasOne(QuestionCategory::class,'id','question_category_id');
    }

    public function type(){
        return $this->hasOne(QuestionType::class,'id','question_type_id');
    }
}
