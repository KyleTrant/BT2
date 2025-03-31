<?php 
namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController{
    protected $viewDir ="/App/Views/User/";
    public function index(){
        if (isset($_SESSION['user_id'])) {
            header("Location: /Tasks");
            exit;
        }
        $this->view('index');
    }
    public function Login(){
        if($_SERVER['REQUEST_METHOD'] =='POST'){
            $gmail = $_POST['gmail']??"";
            $password = $_POST['password']??"";
            $user = UserModel::findUser($gmail);
           
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

    public function Register(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $gmail = $_POST['gmail']??"";
            $password = $_POST['password']??"";
            $name = $_POST['name']??"";
            if (UserModel::findUser($gmail)) {
                $this->view('register', ['error' => 'Email đã tồn tại']);
                return;
            }
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $data = [
                'name' => $name,
                'gmail' => $gmail,
                'password' => $hashedPassword
            ];
            UserModel::create($data);
            $this->view('index', ['success' => 'Đăng ký thành công! Hãy đăng nhập.']);
        }
        else if($_SERVER['REQUEST_METHOD'] === 'GET'){
            if (isset($_SESSION['user_id'])) {
                header("Location: /Tasks");
                exit;
            }
            $this->view('register');
        }
       else  $this->view('register');
      
    }

    public function Logout(){
        if (session_status() === PHP_SESSION_NONE) {
           return;
        }
        session_destroy();
        $this->view('index');
    }

}