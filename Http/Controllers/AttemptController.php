<?php

namespace Modules\Exam\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Exam\Entities\QuestionGroup;
use Modules\Exam\Entities\Question;
use Modules\Exam\Entities\QuestionOption;
use Modules\Exam\Entities\Attempt;
use Modules\Exam\Entities\AttemptAnswer;
use Modules\Exam\Entities\GroupHasQuestion;
use Validator;
use Auth;
use DB;
use Session;
use Carbon\Carbon;
use DataTables;

use Modules\Exam\Http\Helpers\Attempt as AttemptHelper;


class AttemptController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        // $groups= QuestionGroup::with('category:id,type')->withCount('questions')->get();
        $group = QuestionGroup::all();
        $attempt = Attempt::all();
        return view('exam::attempt.index', compact('attempt','group'));
    }

    public function detail($id)
    {
        $group = QuestionGroup::with('category', 'questions', 'questions.type')->where('id', $id)->first();
        return view('exam::attempt.detail', compact('group'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('exam::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $group = QuestionGroup::where('id', $request->question_group_id)->withCount('questions')->first();
        $new_attempt = Attempt::create([
            'user_id' => 1,
            'question_group_id' => $request->question_group_id,
            'no_attempt' => 1,
            'date' => Carbon::now(),
            'start_time' => Carbon::now(),
            'finish_time' => Carbon::now(),
            'status' => 1,
            'question_total' => $group->questions_count,
            'grade' => 0
        ]);
        return response()->json([
            'attempt_id' => $new_attempt->id
        ]);
    }

    public function saveAnswer(Request $request){
        if($request->ajax()){
            foreach($request['answers'] as $answer){
                $question = Question::find($answer['question_id']);
                switch($question->question_type_id){
                    case 1:
                        $option = QuestionOption::where('id', $answer['question_option_id'])->first(['option_text', 'option_value']);
                        AttemptAnswer::updateOrCreate([
                            'attempt_id' => $request['attempt_id'],
                            'question_id' => $answer['question_id'],
                        ], [
                            'question_option_id' => $answer['question_option_id'],
                            'answer' =>  $option->option_text,
                            'point' => $option->option_value,
                            'flag_marked' => 1
                        ]);
                    break;
                    case 2: 
                        AttemptAnswer::updateOrCreate([
                            'attempt_id' => $request['attempt_id'],
                            'question_id' => $answer['question_id'],
                        ], [
                            'question_option_id' => 0,
                            'answer' =>  $answer['answer_text'],
                            'point' => 0,
                            'flag_marked' => 0
                        ]);
                    break;
                    default:
                        $option = QuestionOption::where('id', $answer['question_option_id'])->first(['option_text', 'option_value']);
                        AttemptAnswer::updateOrCreate([
                            'attempt_id' => $request['attempt_id'],
                            'question_id' => $answer['question_id'],
                        ], [
                            'question_option_id' => $answer['question_option_id'],
                            'answer' =>  $option->option_text,
                            'point' => $option->option_value
                        ]);
                    break;
                }
                
            }
            return response()->json('answer successfully saved');
        }
    }

    public function history()
    {
        // $group = QuestionGroup::with('category', 'questions', 'questions.type')->where('id', $id)->first();
        $data['attempt'] = (object) ['title' => 'Test', 'subtitle' => ''];
        return view('exam::attempt.history', $data);
    }

    public function start($id)
    {
        // dd(Carbon::localeHasDiffSyntax('id_ID'));
        config(['app.locale' => 'id_ID']);
        Carbon::setLocale('id_ID');
        $attempt = Attempt::find($id);
        $from = $to = null;
        if($attempt->valid_from && $attempt->valid_from != ''){
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $attempt->valid_from)->isoFormat("dddd, MMMM Do YYYY [pukul] H:mm");
        }
        if($attempt->valid_to && $attempt->valid_to != ''){
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $attempt->valid_to)->isoFormat("dddd, MMMM Do YYYY [pukul] H:mm");
        }
        $title = $attempt->title;
        $subtitle = $attempt->subtitle;
        $group = QuestionGroup::with('category', 'questions', 'questions.type')->where('id', $attempt->question_group_id)->first();
        return view('exam::attempt.detail', compact('group', 'attempt', 'title', 'subtitle', 'from', 'to'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $attempt = Attempt::find($id);
        if($attempt->status == Attempt::STATUS_INITIALIZED || $attempt->status == Attempt::STATUS_STARTED){
            if($attempt->status == Attempt::STATUS_INITIALIZED){
                $attempt->status = Attempt::STATUS_STARTED;
                $attempt->save();
            }
            $group = QuestionGroup::with('questions.type', 'questions.question_option')->where('id', $attempt->question_group_id)->first();
            $request->session()->put("questions", $group->questions);
            $request->session()->put("per_page", $group->question_per_page);
            $request->session()->put("attempt_id", $id);
            $questions = $group->questions()->paginate(1);
            $totalquestions = $group->questions()->count();
            return view('exam::attempt.show', compact('id', 'questions', 'totalquestions', 'group', 'attempt'));
        } else {
            return redirect(route('attempt.result', $attempt->id));
        }
    }

    public function endAttempt(Request $request)
    {
        DB::beginTransaction();
        try{
            $attempt = Attempt::find($request->id);
            //hitung nilai
            $totalPoint = 0;
            foreach($attempt->answer as $answer){
                $totalPoint += $answer->point;
            }
            $attempt->finish_at = date('Y-m-d H:i:s');
            if($attempt->group->questions->first()->type->type == 1){
                $attempt->status = Attempt::STATUS_REVIEWED;
            } else {
                $attempt->status = Attempt::STATUS_FINISHED;
            }
            if($attempt->group->grade_formula == 1)
                $attempt->grade = $totalPoint/$attempt->question_total;
            else if($attempt->group->grade_formula == 2)
                $attempt->grade = $totalPoint;

                dd($totalPoint, $attempt->question_total, $attempt->group->grade_formula, $attempt->grade);
            $attempt->save();
            DB::commit();
            return response()->json([
                'message'   => 'Ujian telah diakhiri',
                'status'    => true
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message'   => $th->getMessage(),
                'status'    => false
            ], 400);
        }

    }

    public function getData(Request $request, $number)
    {
        $finish = false;
        $attempt_id = $request->session()->get("attempt_id");
        $attempt_answers = AttemptAnswer::where('attempt_id', $attempt_id)->get()->keyBy('question_id');
        $per_page = $request->session()->get("per_page");
        $current_page = ( ($number - ($number%$per_page) ) / $per_page) + ($number%$per_page);
        $questions = collect($request->session()->get("questions"))->chunk($per_page);
        foreach ($questions as $key => $question) {
            if($key+1 == $current_page){
                $q = $question;
            }
        }
        $totalquestions = count($request->session()->get("questions"));
        if($current_page > $totalquestions){
            $finish = true;
            $q = null;
        }
        return response()->json([
            "questions" => $q,
            "finish" => $finish,
            "all_questions" => collect($request->session()->get("questions"))->pluck('id'),
            "total_questions" => $totalquestions,
            "total_answers" => count($attempt_answers),
            "current_page" => $current_page,
            "per_page" => $per_page,
            "answers" => $attempt_answers
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('exam::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function result($id){
        $type = Attempt::with('group.questions.type')->find($id);
        $type = $type->group->questions[0]->type->type;
        $attempt = Attempt::with(['group','answer.option'])->find($id);
        $hasil['benar'] = 0;
        if($type == 'Essay'){            
            foreach($attempt->answer as $answer){            
                if($answer->flag_marked == 1)
                    $hasil['benar']++;
            }            
        }else{            
            foreach($attempt->answer as $answer){            
                if($answer->point > 0)
                    $hasil['benar']++;
            }            
        }
        $hasil['salah'] = count($attempt->answer) - $hasil['benar'];

        if($attempt->start_at == null || $attempt->finish_at == null){
            $hasil['waktu'] = '--:--:--';
        }else{
            $hasil['waktu'] = Carbon::parse($attempt->finish_at)->diffInSeconds(Carbon::parse($attempt->start_at));
            $hasil['waktu'] = gmdate('H:i:s', $hasil['waktu']);
        }
        return view('exam::attempt.result', compact(['attempt','hasil','type']));
    }

    public function review($id){
        $type = Attempt::with('group.questions.type')->find($id);
        $type = $type->group->questions[0]->type->type;
        $attempt = Attempt::with(['group','answer.option'])->find($id);
        $group = GroupHasQuestion::where('group_id', $attempt->question_group_id)->first();
        $question = Question::with('type')->find($group->question_id);
        $group = QuestionGroup::with('questions')->find($attempt->question_group_id);
        $hasil['belum_dijawab'] = $attempt->question_total - count($attempt->answer);
        $hasil['benar'] = 0;
        if($type == 'Essay'){ 
            foreach($attempt->answer as $answer){            
                if($answer->flag_marked == 1)
                    $hasil['benar']++;
            }
        }else{            
            foreach($attempt->answer as $answer){            
                if($answer->point > 0)
                    $hasil['benar']++;
            }            
        }
        $hasil['salah'] = count($attempt->answer) - $hasil['benar'];
        $ans = GroupHasQuestion::addSelect(['point' => AttemptAnswer::select('point')
            ->whereColumn('attempt_id', 'ms_attempt.id')
            ->whereColumn('question_id','ms_group_has_question.question_id')
        ])->addSelect(['flag_marked' => AttemptAnswer::select('flag_marked')
            ->whereColumn('attempt_id', 'ms_attempt.id')
            ->whereColumn('question_id','ms_group_has_question.question_id')
        ])
        ->leftjoin('ms_attempt','ms_group_has_question.group_id','ms_attempt.question_group_id')                
        ->where('ms_attempt.id',$id)
        ->orderBy('order','ASC')        
        ->get();
        
        if($type == 'Essay'){ 
            foreach($ans as $key => $val){
                if($val->point == null)
                    $hasil['no'][$key+1] = 0;
                else{            
                    if($val->flag_marked == 1)
                        $hasil['no'][$key+1] = 1;
                    else if($val->flag_marked == 0)
                        $hasil['no'][$key+1] = -1;
                }
            }
        }else{
            foreach($ans as $key => $val){
                if($val->point == null)
                    $hasil['no'][$key+1] = 0;
                else{            
                    if($val->point > 0)
                        $hasil['no'][$key+1] = 1;
                    else if($val->point == 0)
                        $hasil['no'][$key+1] = -1;
                    else
                        $hasil['no'][$key+1] = 0;
                }
            }
        }
        return view('exam::attempt.review', compact(['attempt','question','group','hasil','type']));
    }

    public function getDatatable(Request $request){
        $filter_keyword = $request->get('keyword', '');
        $filter_paket = $request->get('paket', null);
        $filter_status = $request->get('status', null);

        $query = Attempt::select('ms_attempt.*','ms_question_group.group_name as group_name')
        ->leftJoin('ms_question_group','ms_question_group.id','question_group_id')
        ->orderBy('created_at','DESC');
        if($filter_paket != '')
            $query = $query->where('ms_attempt.question_group_id', $filter_paket);
        if($filter_status != '')
            $query = $query->where('status', $filter_status);
        if($filter_keyword != '')
            $query = $query->where('title', 'LIKE','%'.$filter_keyword.'%');


        $status = ['Initialized','Started','Finished','Canceled'];

        return DataTables::of($query)
        ->editColumn('status', function($data) use ($status){            
            return $status[$data->status];
        })
        ->addColumn('checkbox', function($data) {
            return "<input type='checkbox' name='colom[]' value='".$data->id."'>";
        })
        ->addIndexColumn()
        ->rawColumns(['checkbox'])
        ->make(true);
    }

    public function getReview($number, $id){
        if($number > Attempt::find($id)->question_total)
            $number = 1;

        $question = Question::with('question_option','type')
        ->leftjoin('ms_group_has_question','ms_group_has_question.question_id','ms_question.id')
        ->leftjoin('ms_attempt','ms_group_has_question.group_id','ms_attempt.question_group_id')
        ->where('ms_attempt.id',$id)
        ->where('ms_group_has_question.order',$number)
        ->select('ms_question.*')
        ->first();
        
        $ans = AttemptAnswer::where('question_id',$question->id)->where('attempt_id', $id)->first();        
        return response()->json([
            'status' => true,
            'data' => $question,
            'index' => $number,
            'option' => $question->question_option,
            'ans' => $ans,
        ]);
    }

    public function saveEssay($id, Request $request){
        try {
            AttemptAnswer::where('id', $id)->update(['point'=>$request->point,'flag_marked'=>1]);
            $attempt_answers = AttemptAnswer::find($id);
            $attempt = Attempt::with(['group','answer.option'])->find($attempt_answers->attempt_id);
            $hasil['benar'] = 0;
            foreach($attempt->answer as $answer){            
                if($answer->flag_marked == 1)
                    $hasil['benar']++;
            }
            $hasil['nilai'] = AttemptHelper::countEssayAttempt($attempt->id);
            $hasil['salah'] = count($attempt->answer) - $hasil['benar'];
            return response()->json(['status' => true,'hasil'=>$hasil]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false,'message' => $th->getMessage()]);
        }

    }

    public function finalisasiEssay($id){
        try {
            $count = AttemptAnswer::where('attempt_id', $id)->where('flag_marked', 0)->count();
            if($count > 0){
                return response()->json(['status' => false,'message'=> 'Belum semua jawaban dinilai !']);
            }else{
                Attempt::where('id', $id)->update(['status'=>3]);
                return response()->json(['status' => true]);
            }            
        } catch (\Throwable $th) {
            return response()->json(['status' => false]);
        }        
    }
}
