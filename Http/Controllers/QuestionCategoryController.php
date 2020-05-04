<?php

namespace Modules\Exam\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use DataTables;
use Validator;
use DB;
use Auth;

use Modules\Exam\Entities\QuestionCategory;

class QuestionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('exam::question-category.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('exam::question-category.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), array(
            "type"        => 'required',
        ));

        if ($validator->fails()) {
            return response()->json([
                'message'   => $validator->errors(),
                'status'    => false
            ], 400);
        }
        try {
            $data = $request->except('_token');            
            $data['created_by'] = $data['updated_by'] = 1;            
            QuestionCategory::create($data);
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
        $data = QuestionCategory::find($id);
        return view('exam::question-category.edit', compact(['data']));
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
            "type"        => 'required',                        
        ));

        if ($validator->fails()) {
            return response()->json([
                'message'   => $validator->errors(),
                'status'    => false
            ], 400);
        }
        try {
            $data = $request->except('_token', '_method');
            $data['updated_by'] = 1;
            QuestionCategory::where('id', $id)->update($data);
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
            foreach($request->id as $id){
                QuestionCategory::destroy($id);
            }
            return ['status' => true];
        } catch (\Throwable $th) {
            throw $th;
        }        
    }

    public function getData(){
        $query = QuestionCategory::all();
        return DataTables::of($query)        
        ->addColumn('checkbox', function($data) {
            return "<input type='checkbox' name='colom[]' value='".$data->id."'>";
        })        
        ->addIndexColumn()
        ->rawColumns(['checkbox'])
        ->make(true);
    }
}
