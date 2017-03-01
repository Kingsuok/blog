<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Exception;

class IndexController extends CommonController
{
    public function index()
    {
        return view('admin.index');
    }

    public function info()
    {
        return view('admin.info');
    }

    public function pass()
    {    // Input 检测是不是post的request
        if ($input = Input::all()){
            //验证表单数据 和 password验证和提交数据库
            $rules = [
                //格式：表单项name=>验证规则（required必填，between：个数要求， confirmed：两项内容一致）
                //特别注意：confirmed要求，表单中两项name要求： 第一个 x， 第二个：x_confirmation
                'password_o'=>'required',
                'password'=>'required|between:6,20|confirmed',
            ];
            $msg = [
                //格式： 表单项name.验证规则=>提示信息, 如果没有添加对应规则的rule，laravel也会有默认错误信息
                'password_o.required'=>'Old password should not be empty!',
                'password.required'=>'New password should not be empty!',
                //'password.between'=>'New password should not be 6~20 digits!',
            ];
            //make方法中第一个参数：要验证的数据，第二：验证规则，第三：错误信息，错误信息都存放在$validator-errors()
            $validator = Validator::make($input,$rules,$msg);
            if ($validator->passes()){//验证是否通过
                $oldPass = trim($input['password_o']);
                $userName = session('user')->user_name;
                $user = User::where('user_name',$userName)->get();
                $userPass = Crypt::decrypt($user[0]->user_pass);
                if ($oldPass != $userPass){
                    return back()->with('errors','The old password is wrong!');
                }else{
                    $newPass = trim($input['password']);
                    $user[0]->user_pass = Crypt::encrypt($newPass);
                    try{
                        $user[0]->update();
                        return back()->with('errors','Password is changed');
                    }catch (Exception $e){
                        return back()->with('errors','Unknown error!');
                    }

                }

            }else{
                //dd($validator-errors()->all());// 所有的错误信息
                return back()->withErrors($validator);
            }

        }else{
            return view('admin.pass');
        }

    }
}

