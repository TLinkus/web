<?php

namespace App\Models;

use CodeIgniter\Model;

class LessonModel extends Model
{
    protected $table = 'lessons';
    protected $primaryKey = 'id';
    protected $allowedFields = ['company_id', 'tutor_id', 'student_id', 'subject', 'starts_at', 'duration_minutes', 'location', 'status', 'price', 'homework'];
    protected $useTimestamps = true;
    protected $validationRules = [
        'company_id' => 'required|is_natural_no_zero',
        'tutor_id' => 'required|is_natural_no_zero',
        'student_id' => 'required|is_natural_no_zero',
        'subject' => 'required|min_length[2]|max_length[80]',
        'starts_at' => 'required|valid_date[Y-m-d H:i]',
        'duration_minutes' => 'required|integer|greater_than_equal_to[30]|less_than_equal_to[240]',
        'location' => 'required|min_length[3]|max_length[120]',
        'status' => 'required|in_list[planned,completed,cancelled]',
        'price' => 'required|decimal|greater_than_equal_to[0]',
        'homework' => 'permit_empty|max_length[500]',
    ];

    public function scopedFor(array $user)
    {
        $builder = $this->select('lessons.*, tutors.name AS tutor_name, students.name AS student_name, companies.name AS company_name')
            ->join('users tutors', 'tutors.id = lessons.tutor_id')
            ->join('users students', 'students.id = lessons.student_id')
            ->join('companies', 'companies.id = lessons.company_id');

        if ($user['role'] === 'company_admin') {
            $builder->where('lessons.company_id', $user['company_id']);
        } elseif ($user['role'] === 'tutor') {
            $builder->where('lessons.tutor_id', $user['id']);
        } elseif ($user['role'] === 'student') {
            $builder->where('lessons.student_id', $user['id']);
        } elseif (session('active_company_id')) {
            $builder->where('lessons.company_id', session('active_company_id'));
        }

        return $builder;
    }
}
