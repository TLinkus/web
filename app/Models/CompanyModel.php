<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'code', 'email', 'phone', 'city', 'address', 'status', 'notes'];
    protected $useTimestamps = true;
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[120]',
        'code' => 'required|alpha_numeric|min_length[4]|max_length[20]',
        'email' => 'required|valid_email|max_length[120]',
        'phone' => 'required|regex_match[/^\+?[0-9\s\-]{7,20}$/]',
        'city' => 'required|min_length[2]|max_length[80]',
        'address' => 'required|min_length[5]|max_length[160]',
        'status' => 'required|in_list[active,inactive]',
        'notes' => 'permit_empty|max_length[500]',
    ];
    protected $validationMessages = [
        'phone' => ['regex_match' => 'Telefonas turi būti sudarytas iš skaitmenų, tarpų, brūkšnių arba + ženklo.'],
    ];
}
