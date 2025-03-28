<?php
namespace App\Controllers;

class TaskController extends BaseController {
    protected $viewDir ="/App/Views/Task/";
    public function index() {
        $this->view('index', ['title' => 'Trang chủ']);
    }
}
