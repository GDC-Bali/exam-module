<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class GroupCategory extends Model
{
    protected $guarded = ['id'];
    protected $table = 'ms_group_category';
    public $incrementing = false;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) \Ramsey\Uuid\Uuid::uuid4();
        });
    }
}
