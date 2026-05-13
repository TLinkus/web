<?php

namespace App\Models;

use CodeIgniter\Model;

class ActionLogModel extends Model
{
    protected $table = 'action_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'class_name', 'method_name', 'action', 'message', 'created_at'];
    protected $useTimestamps = false;

    public function record(string $class, string $method, string $action, string $message, ?int $userId = null): void
    {
        $this->insert([
            'user_id' => $userId ?? session('user_id'),
            'class_name' => $class,
            'method_name' => $method,
            'action' => $action,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
