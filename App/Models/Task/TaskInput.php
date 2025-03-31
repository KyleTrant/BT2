<?php
namespace App\Models\Task;
class TaskInput {
    public $titleLike = null;       
    public $status = null;           
    public $userId = null;           
    public $startDateMin = null;     
    public $startDateMax = null;     
    public $endDateMin = null;       
    public $endDateMax = null;     
    public function __construct($titleLike = null, $status = null, $userId = null, 
                                $startDateMin = null, $startDateMax = null, 
                                $endDateMin = null, $endDateMax = null) {
        $this->titleLike = $titleLike;
        $this->status = $status;
        $this->userId = $userId;
        $this->startDateMin = $startDateMin;
        $this->startDateMax = $startDateMax;
        $this->endDateMin = $endDateMin;
        $this->endDateMax = $endDateMax;
}
}