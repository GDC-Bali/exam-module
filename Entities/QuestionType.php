<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    protected $guarded = ['id'];
    protected $table = 'ms_question_type';
}
