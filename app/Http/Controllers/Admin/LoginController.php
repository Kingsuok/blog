<?php

namespace App\Http\Controllers\Admin;
//use App\Http\Controllers\Admin\CommonController;
use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

include_once 'resources\org\code\Code.class.php';

class LoginController extends CommonController
{
    public function login()
    {
        if ($input = Input::all()){
            // 验证码
            $code = $this->getCode();
            if (strtolower($code) != strtolower($input['code'])){
                return back()->with('msg','Captcha is wrong!');
            }
            $userName = trim($input['user_name']);
            $userPass = trim($input['user_pass']);
            $user = User::where('user_name',$userName)->get();
            if (!$user){
                return back()->with('msg','userName or password is wrong!');
            }else{
                $password = Crypt::decrypt($user[0]->user_pass);
                if ($userPass != $password){
                    return back()->with('msg','userName or password is wrong!');
                }
            }
            session(['user'=>$user[0]]);
            return redirect('admin');
        }else{

            return view('admin.login');
        }

    }

    public function quit()
    {
        session(['user'=>null]);
        return redirect('admin/login');
    }
    public function code()
    {
        $code = new \Code();
        $code->make();
    }

    private function getCode()
    {
        $code = new \Code();
        return $code->get();
    }

    /*public function crypt()
    {
        $str = '123';
        $strEncrypt = Crypt::encrypt($str);
        $strDecrypt = Crypt::decrypt($strEncrypt);
        echo $strEncrypt;
        echo "<br>";
        echo $strDecrypt;
    }*/
}

