<?php

class TaskInput {
    public $titleLike = null;       // Lọc theo tên task (LIKE)
    public $status = null;           // Lọc theo trạng thái
    public $userId = null;           // Lọc theo user_id
    public $startDateMin = null;     // Lọc theo start_date (min)
    public $startDateMax = null;     // Lọc theo start_date (max)
    public $endDateMin = null;       // Lọc theo end_date (min)
    public $endDateMax = null;       // Lọc theo end_date (max)
    public $priorityMin = null;      // Lọc theo priority (min)
    public $priorityMax = null;      // Lọc theo priority (max)
    public function __construct($titleLike = null, $status = null, $userId = null, 
                                $startDateMin = null, $startDateMax = null, 
                                $endDateMin = null, $endDateMax = null,
                                $priorityMin = null, $priorityMax = null) {
        $this->titleLike = $titleLike;
        $this->status = $status;
        $this->userId = $userId;
        $this->startDateMin = $startDateMin;
        $this->startDateMax = $startDateMax;
        $this->endDateMin = $endDateMin;
        $this->endDateMax = $endDateMax;
        $this->priorityMin = $priorityMin;
        $this->priorityMax = $priorityMax;
    }
}
