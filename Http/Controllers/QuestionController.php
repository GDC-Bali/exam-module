<?php

namespace Modules\Exam\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

use DataTables;
use Validator;
use DB;
use Auth;

use Carbon\Carbon;

use Modules\Exam\Entities\Question;
use Modules\Exam\Entities\QuestionType;
use Modules\Exam\Entities\QuestionGroup;
use Modules\Exam\Entities\GroupHasQuestion;
use Modules\Exam\Entities\QuestionOption;
use Modules\Exam\Entities\QuestionCategory;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $tipe = QuestionType::all();
        $category = QuestionCategory::orderBy('type')->get();
        return view('exam::questions.index',compact(['tipe','category']));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $tipe = QuestionType::all();
        $category = QuestionCategory::orderBy('type')->get();
        return view('exam::questions.create', compact(['tipe','category']));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {      
        $messages = [
            'code.required' => 'Kode soal tidak boleh kosong',
            'question_type_id.required' => 'Tipe pertanyaan belum dipilih',
            'question_category_id.required' => 'Kategori soal belum dipilih',
            'question_text.required' => 'Pertanyaan tidak boleh kosong',
            'feedback.required' => 'Harap mengisi pembahasan soal, jika tidak ada bisa diisi dengan "-"',
        ];  
        $validator = Validator::make($request->input(), array(
            "code"                => 'required',
            "question_type_id"    => 'required',
            "question_category_id"=> 'required',
            "question_text"       => 'required',
            "feedback"            => 'required',
        ), $messages);
        $sum = array_sum($request->option_value);
        if ($validator->fails()) {
            return response()->json([
                'message'   => $validator->errors(),
                'status'    => false
            ], 400);
        }else if($sum == 0){
            $data['message'] = 'Minimal 1 nilai bobot pada jawaban harus lebih dari 0';
            return response()->json([
                'message'   => $data,
                'status'    => false
            ], 400);            
        }
        
        try {
            DB::beginTransaction();

            $data = $request->except('_token','option_value','option_text','radio');

            if($data['competencies'] == null){
                $data['competencies'] = '';
            }

            if(!isset($data['randomize_option'])){
                $data['randomize_option'] = 0;
            }else if($data['randomize_option'] == 'on')
                $data['randomize_option'] = 1;

            if(!isset($data['single_answer'])){
                $data['single_answer'] = 0;
            }else if($data['single_answer'] == 'on')
                $data['single_answer'] = 1;

            if(!isset($data['allow_blank'])){
                $data['allow_blank'] = 0;
            }else if($data['allow_blank'] == 'on')
                $data['allow_blank'] = 1;

            if($request->question_type_id == 1){
                $data['allow_blank'] = 0;
            }else if($request->question_type_id == 2){
                $data['randomize_option'] = 0;
                $data['single_answer'] = 0;
            }
                
            if(Auth::check())
                $data['created_by'] = $data['updated_by'] = $data['owner_id'] = Auth::user()->id;
            else
                $data['created_by'] = $data['updated_by'] = $data['owner_id'] = 1;
            $question = Question::create($data);
            
            if($request->question_type_id == 1){
                $allOption = [];
                foreach ($request->option_text as $key => $value) {        
                    $option['id'] = (string) \Ramsey\Uuid\Uuid::uuid4();        
                    $option['question_id'] = $question->id;
                    $option['option_text'] = $request->option_text[$key];
                    $option['option_value'] = $request->option_value[$key];
                    $option['created_at'] = $option['updated_at'] = Carbon::now();                
                    array_push($allOption, $option);
                }
                QuestionOption::insert($allOption);
            }

            $part = parse_url(request()->headers->get('referer'));
            if(isset($part['query'])){
                parse_str($part['query'], $query);
                
                $group = QuestionGroup::find($query['group_id']);
                $order = GroupHasQuestion::where('group_id',$query['group_id'])->count();
                $group->questions()->attach($question->id,['order' => ($order+1)]);

                DB::commit();
                return ['status' => true,'message' => 'success', 'type'=> $query['group_id']];
            }else{
                DB::commit();
                return ['status' => true,'message' => 'success', 'type' => 0];
            }            
            
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message'   => $th->getMessage(),
                'status'    => false
            ], 400);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('exam::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $tipe = QuestionType::all();
        $category = QuestionCategory::orderBy('type')->get();
        $data = Question::with(['question_option'])->find($id);        
        return view('exam::questions.edit', compact(['tipe','category','data']));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'code.required' => 'Kode soal tidak boleh kosong',
            'question_type_id.required' => 'Tipe pertanyaan belum dipilih',
            'question_category_id.required' => 'Kategori soal belum dipilih',
            'question_text.required' => 'Pertanyaan tidak boleh kosong',
            'feedback.required' => 'Harap mengisi pembahasan soal, jika tidak ada bisa diisi dengan "-"',
        ];
        $validator = Validator::make($request->input(), array(
            "code"                => 'required',
            "question_type_id"    => 'required',
            "question_category_id"=> 'required',
            "question_text"       => 'required',
            "feedback"            => 'required',
        ), $messages);

        if ($validator->fails()) {
            return response()->json([
                'message'   => $validator->errors(),
                'status'    => false
            ], 400);
        }
        
        try {
            DB::beginTransaction();

            $data = $request->except('_token','option_value','option_text','radio','_method');

            if($data['competencies'] == null){
                $data['competencies'] = '';
            }

            if(!isset($data['randomize_option'])){
                $data['randomize_option'] = 0;
            }else if($data['randomize_option'] == 'on')
                $data['randomize_option'] = 1;

            if(!isset($data['single_answer'])){
                $data['single_answer'] = 0;
            }else if($data['single_answer'] == 'on')
                $data['single_answer'] = 1;

            if(!isset($data['allow_blank'])){
                $data['allow_blank'] = 0;
            }else if($data['allow_blank'] == 'on')
                $data['allow_blank'] = 1;

            if($request->question_type_id == 1){
                $data['allow_blank'] = 0;
            }else if($request->question_type_id == 2){
                $data['randomize_option'] = 0;
                $data['single_answer'] = 0;
            }
                
            if(Auth::check())
                $data['updated_by'] = $data['owner_id'] = Auth::user()->id;
            else
                $data['updated_by'] = $data['owner_id'] = 1;
            $question = Question::where('id',$id)->update($data);
            $created_at = Question::find($id)->created_at;
            QuestionOption::where('question_id',$id)->delete();
            if($request->question_type_id == 1){
                $allOption = [];
                foreach ($request->option_text as $key => $value) {     
                    $option['id'] = (string) \Ramsey\Uuid\Uuid::uuid4();
                    $option['question_id'] = $id;
                    $option['option_text'] = $request->option_text[$key];
                    $option['option_value'] = $request->option_value[$key];
                    $option['created_at'] = $created_at;
                    $option['updated_at'] = Carbon::now();
                    array_push($allOption, $option);
                }
                QuestionOption::insert($allOption);
            }            

            DB::commit();

            return ['status' => true,'message' => 'success'];
            
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message'   => $th->getMessage(),
                'status'    => false
            ], 400);
        }
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

    public function multiple_delete(request $request){        
        DB::beginTransaction();
        try {
            foreach($request->id as $id){
                QuestionOption::where('question_id', $id)->delete();
                Question::destroy($id);
            }
            DB::commit();
            return ['status' => true];
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }        
    }

    public function getData(Request $request){
        //filter
        $filter_keyword = $request->get('keyword', '');
        $filter_kategori = $request->get('kategori', null);
        $filter_tipe = $request->get('tipe', null);
        
        // $query = Question::with(['category','type'])
        // ->whereHas('category',function($query) use ($filter_kategori){
        //     if($filter_kategori != '')
        //         $query->where('id', $filter_kategori);
        // })
        // ->whereHas('type',function($query) use ($filter_tipe){
        //     if($filter_tipe != '')
        //         $query->where('id', $filter_tipe);
        // });

        $query = Question::select('ms_question.*','ms_question_category.type as category','ms_question_type.type as type')
        ->leftJoin('ms_question_category','ms_question_category.id','question_category_id')
        ->leftJoin('ms_question_type','ms_question_type.id','question_type_id')
        ->orderBy('code');
        if($filter_tipe != '')
            $query = $query->where('ms_question_type.id', $filter_tipe);
        if($filter_kategori != '')
            $query = $query->where('ms_question_category.id', $filter_kategori);
        if($filter_keyword != '')
            $query = $query->where('code', 'LIKE','%'.$filter_keyword.'%');
        
        return DataTables::of($query)        
        ->addColumn('checkbox', function($data) {
            return "<input type='checkbox' name='colom[]' class='select-bank-soal' value='".$data->id."'>";
        })
        ->addColumn('action', function($data) {
            return "<button type='button' title='Preview' class='btn btn-xs btn-info btn-preview' data-id='".$data->id."'><i class='fas fa-eye'></i> Preview</button>";
        })
        ->addIndexColumn()
        ->rawColumns(['checkbox','action'])
        ->make(true);
    }

    public function getDataByGroup($id, $owner=null){
        $query = Question::join('ms_group_has_question', function($join) use($id){
            $join->on('ms_group_has_question.question_id', '=', 'ms_question.id');
            $join->where('ms_group_has_question.group_id', $id);
        })
        ->join('ms_question_type','ms_question_type.id','=','ms_question.question_type_id')
        ->join('ms_question_category','ms_question_category.id','=','ms_question.question_category_id')
        ->addSelect([
            'ms_question.id as id',
            'ms_question.code as code',
            'ms_question_type.type as type',
            'ms_question_category.type as category',
        ])->orderBy('order','ASC');
        return DataTables::of($query)        
        ->addColumn('checkbox', function($data) {
            return "<input type='checkbox' name='colom[]' value='".$data->id."'>";        
        })
        ->addColumn('action', function($data) {
            return "<button type='button' title='Preview' class='btn btn-sm btn-info btn-preview' data-id='".$data->id."'><i class='fas fa-eye'></i></button>&nbsp;<button class='btn btn-danger btn-sm btn-detach-soal' data-id='".$data->id."'><i class='fas fa-trash'></i></button>";        
        })
        ->addIndexColumn()
        ->rawColumns(['checkbox', 'action'])
        ->make(true);
    }

    public function getDataBank(Request $request){
        //filter
        $filter_keyword = $request->get('keyword', '');
        $filter_kategori = $request->get('kategori', null);
        $filter_tipe = $request->get('tipe', null);
        
        $questionsExcluded = null;
        if(!empty($request->paket_id)){
            $questionsExcluded = DB::table('ms_group_has_question')->where('group_id', $request->paket_id)->get()->pluck('question_id')->toArray();
        }
        if($questionsExcluded){
            $query = Question::with('type', 'category')->whereNotIn('id', $questionsExcluded)->orderBy('code')->get();
        } else {
            $query = Question::with('type', 'category')->orderBy('code')->get();
        }
        return DataTables::of($query)        
        ->addColumn('checkbox', function($data) {
            return "<input type='checkbox' name='colom[]' class='select-bank-soal' value='".$data->id."'>";
        })        
        ->addIndexColumn()
        ->rawColumns(['checkbox'])
        ->make(true);
    }

    public function getDetailQuestion($id){        
        try {
            $data = Question::with(['question_option'])->find($id);
            return ['status' => true, 'data'=> $data];
        } catch (\Throwable $th) {    
            return response()->json([
                'message'   => $th->getMessage(),
                'status'    => false
            ], 400);
        }   
    }

    public function image_upload(Request $request){
        try {
            if($request->hasFile('upload')){
                $file = $request->file('upload');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = $filename.'_'.Carbon::now()->format('dmYHis').'.'.$file->getClientOriginalExtension();
    
                $destination = 'public/exam/images';
    
                if (!file_exists(storage_path($destination))) {
                    Storage::makeDirectory($destination);
                }
    
                $file->storeAs($destination, $filename);
    
                $ckeditor = $request->input('CKEditorFuncNum');
                $url = asset('storage/exam/images').'/'.$filename;
                $msg = 'Image uploaded successfully';
    
                $response = "<script>window.parent.CKEDITOR.tools.callFunction($ckeditor, '$url', '$msg')</script>";
    
                @header('Content-type: text/html; charset=utf-8');

                return $response;
            }
        } catch (\Throwable $th) {
            return response()->json(['message'=> $th->getMessage()]);
        }
    }

    public function image_upload_drop(Request $request){
        try {
            if($request->hasFile('upload')){
                $file = $request->file('upload');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = $filename.'_'.Carbon::now()->format('dmYHis').'.'.$file->getClientOriginalExtension();
    
                $destination = 'public/exam/images';
    
                if (!file_exists(storage_path($destination))) {
                    Storage::makeDirectory($destination);
                }
    
                $file->storeAs($destination, $filename);
    
                $ckeditor = $request->input('CKEditorFuncNum');
                $url = asset('storage/exam/images').'/'.$filename;
                $msg = 'Image uploaded successfully';
    
                $response = "<script>window.parent.CKEDITOR.tools.callFunction($ckeditor, '$url', '$msg')</script>";
    
                @header('Content-type: text/html; charset=utf-8');

                return response()->json(['uploaded' => 1, 'fileName' => $filename, 'url' => $url]);                
            }
        } catch (\Throwable $th) {
            return response()->json(['message'=> $th->getMessage()]);
        }
    }
}