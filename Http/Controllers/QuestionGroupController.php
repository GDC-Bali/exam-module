<?php

namespace Modules\Exam\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use DataTables;
use Validator;
use DB;
use Auth;

use Modules\Exam\Entities\Question;
use Modules\Exam\Entities\QuestionGroup;
use Modules\Exam\Entities\GroupCategory;
use Modules\Exam\Entities\GroupHasQuestion;

class QuestionGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['categories'] = GroupCategory::orderBy('type')->get();
        return view('exam::question-group.list.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $category = GroupCategory::orderBy('type')->get();
        return view('exam::question-group.list.create', compact(['category']));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), array(
            "group_name"          => 'required',
            "code"                => 'required',
            "category_id"         => 'required',
            "question_per_page"   => 'required',
            "grade_formula"       => 'required',
            // "randomize_no"        => 'required',
            // "availability"           => 'required',
        ));

        if ($validator->fails()) {
            return response()->json([
                'message'   => $validator->errors(),
                'status'    => false
            ], 400);
        }        
        try {
            $data = $request->except('_token');

            if(!isset($data['randomize_no'])){
                $data['randomize_no'] = 0;
            }else if($data['randomize_no'] == 'on')
                $data['randomize_no'] = 1;

            if(!isset($data['availability'])){
                $data['availability'] = 0;
            }else if($data['availability'] == 'on')
                $data['availability'] = 1;
            if(Auth::check())
                $data['created_by'] = $data['updated_by'] = $data['owner_id'] = Auth::user()->id;
            else
                $data['created_by'] = $data['updated_by'] = $data['owner_id'] = 1;

            QuestionGroup::create($data);
            return ['status' => true];
        } catch (\Throwable $th) {
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
        $category = GroupCategory::orderBy('type')->get();
        $data = QuestionGroup::find($id);
        return view('exam::question-group.list.edit', compact(['category','data']));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->input(), array(
            "group_name"          => 'required',
            "desc"                => 'required',
            "code"                => 'required',
            "category_id"         => 'required',
            "question_per_page"   => 'required',
            "grade_formula"       => 'required',
            // "randomize_no"        => 'required',
            // "availability"           => 'required',
        ));

        if ($validator->fails()) {
            return response()->json([
                'message'   => $validator->errors(),
                'status'    => false
            ], 400);
        }        
        try {
            $data = $request->except('_token','_method');

            if(!isset($data['randomize_no'])){
                $data['randomize_no'] = 0;
            }else if($data['randomize_no'] == 'on')
                $data['randomize_no'] = 1;

            if(!isset($data['availability'])){
                $data['availability'] = 0;
            }else if($data['availability'] == 'on')
                $data['availability'] = 1;            
            if(Auth::check())
                $data['updated_by'] = $data['owner_id'] = Auth::user()->id;
            else
                $data['updated_by'] = $data['owner_id'] = 1;

            QuestionGroup::where('id', $id)->update($data);
            return ['status' => true];
        } catch (\Throwable $th) {
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
        try {
            DB::beginTransaction();
            foreach($request->id as $id){
                GroupHasQuestion::where('group_id',$id)->delete();
                QuestionGroup::destroy($id);
            }
            DB::commit();
            return ['status' => true];
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }        
    }

    public function ordering($group_id){
        $data = GroupHasQuestion::where('group_id',$group_id)->orderBy('order','ASC')->get();
        foreach($data as $key => $item){
            GroupHasQuestion::where('group_id',$item->group_id)->where('question_id', $item->question_id)->update(['order'=>($key+1)]);
        }
    }

    public function addQuestionFromBank(Request $request)
    {        
        try {            
            $group = QuestionGroup::find($request->paket_id);
            $order = GroupHasQuestion::where('group_id',$request->paket_id)->count();
            $group->questions()->attach($request->soals,['order'=>($order+1)]);
            Self::ordering($request->paket_id);
            // $questionCount = $group->questions()->count();
            // $order = $questionCount+1;
            // foreach($request->soals as $soal){
            //     $group->questions()->attach($soal, ['order'=> $order]);
            //     $order++;
            // }
            return ['status' => true];
        } catch (\Throwable $th) {
            return response()->json([
                'message'   => $th->getMessage(),
                'status'    => false
            ], 400);
        }  
    }

    public function detachQuestion(Request $request)
    {
        try {
            $group = QuestionGroup::find($request->id);
            $group->questions()->detach($request->soal);
            Self::ordering($request->id);
            return ['status' => true];
        } catch (\Throwable $th) {
            return response()->json([
                'message'   => $th->getMessage(),
                'status'    => false
            ], 400);
        }
    }

    public function getData(Request $request){
        $filter_keyword = $request->get('keyword', '');
        $filter_kategori = $request->get('kategori', null);

        $query = QuestionGroup::with(['category'])
                                ->where(DB::raw("CONCAT(`group_name`, ' ', `desc`, ' ', `code`)"), 'LIKE', "%".$filter_keyword."%")
                                ->orderBy('group_name');
        if($filter_kategori){
            $query = $query->where('category_id', $filter_kategori);
        }       
        return DataTables::of($query)        
        ->addColumn('checkbox', function($data) {
            return "<input type='checkbox' name='colom[]' value='".$data->id."'>";
        })
        ->addColumn('total', function($data){
            return GroupHasQuestion::where('group_id', $data->id)->count('group_id');
        })
        ->addIndexColumn()
        ->rawColumns(['checkbox'])
        ->make(true);
    }

    public function reorder(Request $request){
        DB::beginTransaction();
        try {
            $id = [];
            for($i=0;$i<count($request->new_pos);$i++){
                $ids = GroupHasQuestion::where('group_id', $request->group_id)->where('order', $request->old_pos[$i])->first()->question_id;
                array_push($id, $ids);
            }
            for($i=0;$i<count($request->new_pos);$i++){
                GroupHasQuestion::where('group_id', $request->group_id)->where('question_id',$id[$i])->update(['order'=>$request->new_pos[$i]]);
            }                        
            DB::commit();
            return ['status'=> true];
        } catch (\Throwable $th) {
            DB::rollback();
            var_dump($th->getMessage());
            return ['status'=> false];
        }        
    }
}
