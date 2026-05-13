<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class TutorSystem extends BaseConfig
{
    public string $language = 'lt';
    public int $perPage = 20;
    public int $seedUsers = 100;
    public int $seedLessons = 10000;
    public array $roles = ['system_admin', 'company_admin', 'tutor', 'student'];
}
