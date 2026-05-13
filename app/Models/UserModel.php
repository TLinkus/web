<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['company_id', 'name', 'email', 'password_hash', 'role', 'phone', 'status'];
    protected $useTimestamps = true;
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[120]',
        'email' => 'required|valid_email|max_length[120]',
        'role' => 'required|in_list[system_admin,company_admin,tutor,student]',
        'phone' => 'permit_empty|regex_match[/^\+?[0-9\s\-]{7,20}$/]',
        'status' => 'required|in_list[active,inactive]',
    ];

    public function byEmail(string $email): ?array
    {
        return $this->where('email', mb_strtolower($email))->first();
    }
}
