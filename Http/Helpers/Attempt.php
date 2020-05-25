<?php

namespace Modules\Exam\Http\Helpers;

use Modules\Exam\Entities\Attempt as AttemptModel;
use Modules\Exam\Entities\AttemptAnswer;
use Modules\Exam\Entities\Question;
use Modules\Exam\Entities\QuestionGroup;
use Modules\Exam\Entities\QuestionType;
use Modules\Exam\Entities\QuestionCategory;
use Modules\Exam\Http\Helpers\Soal;

class Attempt
{
    public static function prepareAttempt($examId, $userId, $paketId)
    {
        $allowed = true;
        $activeAttempt = AttemptModel::where('user_id', $userId)
                                    ->where('question_group_id', $paketId)
                                    ->where('exam_id', $examId)
                                    ->where('status', AttemptModel::STATUS_STARTED)
                                    ->orderBy('start_at', 'desc')
                                    ->first();
        $questionPackage = QuestionGroup::find($paketId);
        $attemptCount = AttemptModel::where('user_id', $userId)->where('question_group_id', $paketId)->where('exam_id', $examId)->where('status', AttemptModel::STATUS_STARTED)->count();
        //cek jika masih bisa dilakukan percobaan
        if($questionPackage->attempt_allowed != -1){
            if($attemptCount >= $questionPackage->attempt_allowed){
                $allowed = false;
            }
        }
        return (object)[
            'active' => $activeAttempt?$activeAttempt->id:null,
            'count' => $attemptCount,
            'allowed' => $allowed
        ];
    }

    public static function initAttempt($userId, $noAttempt, $examClass, $examId, $paketId, $duration, $title, $subTitle='', $validFrom, $validTo)
    {
        $attemp = new AttemptModel;
        $attemp->user_id = $userId;
        $attemp->exam_type = $examClass;
        $attemp->exam_id = $examId;
        $attemp->question_group_id = $paketId;
        $attemp->no_attempt = $noAttempt;
        $attemp->duration = $duration;
        $attemp->title = $title;
        $attemp->duration = $duration;
        $attemp->subtitle = $subTitle;
        $attemp->valid_from = $validFrom;
        $attemp->valid_to = $validTo;
        $attemp->question_total = Soal::getSoalNumber($paketId);
        $attemp->grade = 0;
        if($attemp->save()){
            return $attemp->id;
        }
        return false;
    }

    public static function startAttempt($attemptId)
    {
        return redirect(route('attempt.start', $attemptId));
    }

    public static function showAttempt($attemptId)
    {
        return redirect(route('attempt.show', $attemptId));
    }

    public static function showResult($userId, $examId)
    {
        return redirect(route('attempt.result', [$userid, $examId]));
    }

    public static function getAttempts($examId, $userId, $paketId)
    {
        return AttemptModel::where('user_id', $userId)
                            ->where('question_group_id', $paketId)
                            ->where('exam_id', $examId)
                            ->whereIn('status', [AttemptModel::STATUS_FINISHED, AttemptModel::STATUS_REVIEWED])
                            ->orderBy('finish_at', 'desc')
                            ->get();
    }

    public static function countEssayAttempt($attemptId){        
        $attemptAnswer = AttemptAnswer::where('attempt_id', $attemptId)->where('flag_marked',1)->get();
        $total = 0;
        foreach($attemptAnswer as $val){
            $total += $val->point;
        }
        AttemptModel::where('id',$attemptId)->update(['grade'=>$total]);
        return $total;
    }
}