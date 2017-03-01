<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    public function upload()
    {
       $file = Input::file('Filedata');
       if ($file->isValid()){
           // check the file is valid or not
           //$readPath = $file->getRealPath();// absolute path of the temporary file
           $suffix = $file->getClientOriginalExtension(); // get the suffix of the file
           $newName = date('YmdHis').mt_rand(100,1000).'.'.$suffix;//201702201350178.png
           $path = $file->move( base_path().'/uploads',$newName);// move temporary file and rename name, base_path(), current path
           $filePath = 'uploads/'.$newName;
           $data = [
               'status'=>1,
               'msg'=>'upload success',
               'filePath'=>$filePath
           ];
       }else{
           $data = [
               'status'=>0,
               'msg'=>'upload fail'
           ];
       }
        return $data; // json type return
    }
}
