<?php

namespace Modules\Exam\Http\Helpers;

use Modules\Exam\Entities\Question;
use Modules\Exam\Entities\QuestionGroup;
use Modules\Exam\Entities\QuestionType;
use Modules\Exam\Entities\QuestionCategory;

class Soal
{
    public static function getSoalPackages($ownerId=null)
    {
        $query = QuestionGroup::with(['questions']);
        if($ownerId) {
            $query = $query->where('owner_id', $ownerId);   
        }
        return $query->get();
    }

    public static function getSoalNumber($paketId)
    {
        $group = QuestionGroup::find($paketId);
        return $group->questions()->count();
    }
}