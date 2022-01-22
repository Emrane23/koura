<?php

namespace App\Http\Controllers;
use App\Image;
use App\Stade;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class StadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        $stade = Stade::where('type',$type)->with('images')->get();
        return response()->json($stade, 200);
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
        $input['nom_proprietaire']=User::where('id',$request->proprietaire_id)->value('nom');
        $input['prenom_proprietaire']=User::where('id',$request->proprietaire_id)->value('prenom');

        $stade = Stade::create($input);

        if($request->hasFile("images")){
            $files=$request->file("images");
            foreach($files as $file){
                $imageName=time().'_'.$file->getClientOriginalName();
                $request['stade_id']=$stade->id;
                $request['image']=$imageName;
                $file->move(\public_path("storage\stades"),$imageName);
                Image::create($request->all());

            }

        }
        
        return response()->json($stade, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stade = Stade::with('images')->find($id);

        if (empty($stade)) {

            return response()->json(["error" => "not found! "], 400);
        }

        return response()->json($stade, 200);
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
        $stade=Stade::with('images')->find($id);
        
        if (empty($stade)) {

            return response()->json(["error" => "not found! "], 400);
        }
        $stade->fill($request->all());
        $stade->save();
        $items = $request['images'];
        $stade->images()->delete();
        if($request->hasFile("images")){
            $files=$request->file("images");
            foreach($files as $file){
                $imageName=time().'_'.$file->getClientOriginalName();
                $request['stade_id']=$stade->id;
                $request['image']=$imageName;
                $file->move(\public_path("storage\stades"),$imageName);
                Image::create($request->all());

            }
        }
        return response()->json($stade, 200);

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

            return response()->json(["error" => "not found! "], 400);
        }
        $stade->delete();
        return response()->json(["message" => "Record deleted "],200);
    }



    public function liste_stades_prop($propid)
    {
        $stade=Stade::where('proprietaire_id',$propid)->get();
        return response()->json($stade, 200);
    }
}
