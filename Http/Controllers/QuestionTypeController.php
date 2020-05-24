<?php

namespace Modules\Exam\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use DataTables;
use Validator;

use Modules\Exam\Entities\QuestionType;

class QuestionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('exam::question-type.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('exam::question-type.create');    
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->except('_token');
            QuestionType::create($data);
            return redirect()->route('exam.question-type.index');
        } catch (\Throwable $th) {
            throw $th;
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
        $data = QuestionType::find($id);
        return view('exam::question-type.edit', compact(['data']));
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
            QuestionType::where('id', $id)->update($data);
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
                QuestionType::destroy($id);
            }
            return ['status' => true];
        } catch (\Throwable $th) {
            throw $th;
        }        
    }

    public function getData(){
        $query = QuestionType::all();
        return DataTables::of($query)        
        ->addColumn('checkbox', function($data) {
            return "<input type='checkbox' name='colom[]' value='".$data->id."'>";
        })
        ->addIndexColumn()
        ->rawColumns(['checkbox'])
        ->make(true);
    }
}
