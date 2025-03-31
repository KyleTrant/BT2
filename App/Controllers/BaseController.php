<?php
namespace App\Controllers;

abstract class BaseController {
    protected $viewDir ;

    protected function view($view, $data = [], $layout = 'layouts/main') {
        extract($data);
        $viewPath = ROOT_DIR .$this->viewDir. "$view.php";
        $layoutPath = ROOT_DIR.$this->viewDir ."$layout.php";
        if (file_exists($viewPath)) {
            ob_start();
            require $viewPath;
            $content = ob_get_clean(); 
            if (file_exists($layoutPath)) {
                require $layoutPath;
            } else {
                echo $content;
            }
        } else {
           
            http_response_code(404);
            $this->view(ROOT_DIR.'/App/Views/Error/Error', ['errorCode' => 404, 'errorMessage' => "Trang không tồn tại"]);
        }
    }
}
