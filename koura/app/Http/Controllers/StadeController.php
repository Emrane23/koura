<?php

namespace App\Http\Controllers;
use App\Stade;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class StadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stade=Stade::all();
        return response()->json($stade,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
       
    //     if($request->image != '')
    //    {

    //        $filename = time() . '.jpg';
    //        file_put_contents('storage\stades\\'.$filename,base64_decode($request->image));
    //        $input['image'] = $filename;
    //    }
       
        $stade=Stade::create($input);
        return response()->json($stade,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stade = Stade::find($id);

        if (empty($stade)) {

           return response()->json(["error" => "not found! "],400);

        }

        return response()->json($stade,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stade = Stade::find($id);

        if (empty($stade)) {

           return response()->json(["error" => "not found! "],400);

        }
        $stade->delete();
    }
}
