<?php 
namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController{
    protected $viewDir ="/App/Views/User/";
    public function index(){
        $this->view('index');
    }
    public function Login(){
        if($_SERVER['REQUEST_METHOD'] =='POST'){
            $email = $_POST['gmail']??"";
            $password = $_POST['password']??"";
           $user = UserModel::findUser($email);
            if($user && password_verify($password,$user->password)){
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->name;
            
            header("Location: /Tasks");
            exit;
            }
            else {
                $this->view('index', ['error' => 'Email hoặc mật khẩu không chính xác']);
            }
        }
        else {
              $this->view('index');
        }
    }

    public function Resgister(){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return $this->view('Auth/Register');
        }

    }

    public function Logout(){

    }

}