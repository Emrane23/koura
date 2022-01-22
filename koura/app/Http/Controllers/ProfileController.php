<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile()
    {
        $id=Auth::user()->id ;
        $profile=User::find($id);
        return response()->json($profile,201);
    }
    

    public function updateprofile(Request $request)
    {
        $user_id = Auth::user()->id;
       $user = user::findOrFail($user_id);

       $user->name     = $request->input('name');
       $user->lastname = $request->input('lastname');
       $user->email    = $request->input('email');
       $user->phone    = $request->input('phone');
       $user->email    = $request->input('email');
       $user->propos    = $request->input('propos');
       if($request->hasfile('image'))
       {
           $destination = 'profile/' .$user->image_path;
           if(File::exists($destination)){
               File::delete($destination);
           }
           $file = $request->file('image');
           $extension = $file->getClientOriginalExtension();
           $filename = time() . '.' . $extension;
           $file->move('profile/',$filename);
           $user->image_path = $filename;
       }
       $user->update();
       
       return response()->json($user,201);


    }

    public function change_password (Request $request,  $user_id)   
    
    {

        
        $user = user::findOrFail($user_id);
        if (empty($user)) {

            return response()->json(["error" => "not found! "], 400);
        }
        if ($user) {
 
         if (Hash::check($request['oldpassword'], $user->password))
         {
           $user->password = Hash::make($request['password']);
   
           $user->save();
   
           
           return response()->json(["message" => "Votre mot de passe a été mis à jour "],200);
             
           }
             else
             {
                return response()->json(["message" =>'Votre ancient mot de passe est incorrect!'],401);
               
             }
         }

    }
}
