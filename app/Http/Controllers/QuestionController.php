<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    use GeneralTrait;
    /**
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
           
            $questions=Question::all();
            $data=array();
            $data['questions']=QuestionResource::collection($questions);
           return  $this-> apiResponse($data,true,'all questions are here ',200);
          
           }
          catch (\Exception $ex){
            return $this->apiResponse([], false,$ex->getMessage() ,500);
           }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|string',
             'category_id'=>  'required|numeric',
             'logo2'=>'required|image'
            ]
        );
                if($validator->fails()){
                    return $this-> apiResponse([], false,$validator->errors(),422);
        }
      try {
       
          $uuid = Str::uuid()->toString();
           $data= $validator->validated();
          $data['uuid']=$uuid;
          if($request->hasFile('logo2'))
          {
           $file=$request->file('logo2');
           $path=$this-> uploadOne($file, 'colleges');
        
        $data['logo']=$path;

          }
          $college=College::create($data);
          $msg='college is created successfully';
          $data2=array();
          $data2['college']=new CollegeResource($college);
         return  $this-> apiResponse($data2,true, $msg,201);
       
        }
        catch (\Exception $ex)
        {
            return $this->apiResponse([], false,$ex->getMessage() ,500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        try{
          
            $question=Question::where('uuid',$uuid)->first();
           $data['question']=new QuestionResource($question);
            return  $this-> apiResponse($data,true,'question is here',200);
        }
        catch (\Exception $ex)
        {
            return $this->apiResponse([], false,$ex->getMessage() ,500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}
