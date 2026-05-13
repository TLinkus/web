<?php

namespace App\Models;

use CodeIgniter\Model;

class LessonEntryModel extends Model
{
    protected $table = 'lesson_entries';
    protected $primaryKey = 'id';
    protected $allowedFields = ['lesson_id', 'topic', 'progress', 'homework_checked', 'student_comment', 'tutor_comment', 'filled_at'];
    protected $useTimestamps = true;
    protected $validationRules = [
        'topic' => 'required|min_length[3]|max_length[160]',
        'progress' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]',
        'homework_checked' => 'required|in_list[0,1]',
        'student_comment' => 'permit_empty|max_length[500]',
        'tutor_comment' => 'required|min_length[5]|max_length[800]',
    ];
}
