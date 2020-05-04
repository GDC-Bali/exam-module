<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attempt extends Model
{
    const STATUS_INITIALIZED = 0;
    const STATUS_STARTED = 1;
    const STATUS_FINISHED = 2;
    const STATUS_REVIEWED = 3;
    const STATUS_CANCELED = 4;
    const STATUSES = [
        self::STATUS_INITIALIZED => 'Initialized',
        self::STATUS_STARTED => 'Started',
        self::STATUS_FINISHED => 'Finished',
        self::STATUS_REVIEWED => 'Reviewed',
        self::STATUS_CANCELED => 'Canceled'
    ];
    protected $guarded = ['id'];
    protected $table = 'ms_attempt';
    public $incrementing = false;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) \Ramsey\Uuid\Uuid::uuid4();
            $model->start_at = date('Y-m-d H:i:s');
            $model->status = self::STATUS_INITIALIZED;
        });
    }

    public function group()
    {
        return $this->hasOne(QuestionGroup::class,'id' ,'question_group_id');
    }

    public function answer()
    {
        return $this->hasMany(AttemptAnswer::class,'attempt_id');
    }   
    
    public function getWaktu()
    {
        config(['app.locale' => 'id_ID']);
        Carbon::setLocale('id_ID');
        $start = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->start_at);
        $finish = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->finish_at);
        if($start->diffInHours($finish)>0){
            $diff = $start ->diff($finish)->format('%h jam %i menit');
        } else {
            $diff = $start ->diff($finish)->format('%i menit');
        }
        return $diff;
    }

    public function totalAnswered()
    {
        return $this->answer()->count();
    }

    public function totalAnsweredPercentage()
    {
        return ($this->answer()->count()/$this->question_total)*100;
    }
}
