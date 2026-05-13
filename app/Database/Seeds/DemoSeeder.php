<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $companies = [
            ['name' => 'Vilniaus Korepetitoriai', 'code' => 'VK001', 'email' => 'info@vilniaus-korepetitoriai.lt', 'phone' => '+370 600 00001', 'city' => 'Vilnius', 'address' => 'Gedimino pr. 1', 'status' => 'active', 'notes' => 'Pagrindinė demonstracinė įmonė.', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kauno Mokymosi Centras', 'code' => 'KMC02', 'email' => 'info@kaunomc.lt', 'phone' => '+370 600 00002', 'city' => 'Kaunas', 'address' => 'Laisvės al. 10', 'status' => 'active', 'notes' => 'Antra demonstracinė įmonė.', 'created_at' => $now, 'updated_at' => $now],
        ];
        $this->db->table('companies')->insertBatch($companies);

        $password = password_hash('Pamoka123', PASSWORD_DEFAULT);
        $users = [[
            'company_id' => null,
            'name' => 'Sistemos Administratorius',
            'email' => 'sysadmin@example.test',
            'password_hash' => $password,
            'role' => 'system_admin',
            'phone' => '+370 600 10000',
            'status' => 'active',
            'created_at' => $now,
            'updated_at' => $now,
        ]];

        for ($i = 1; $i <= 99; $i++) {
            $companyId = $i % 2 === 0 ? 1 : 2;
            $role = $i <= 4 ? 'company_admin' : ($i % 3 === 0 ? 'tutor' : 'student');
            $roleNames = [
                'company_admin' => 'Įmonės administratorius',
                'tutor' => 'Korepetitorius',
                'student' => 'Mokinys',
            ];

            $users[] = [
                'company_id' => $companyId,
                'name' => $roleNames[$role] . ' ' . $i,
                'email' => 'user' . $i . '@example.test',
                'password_hash' => $password,
                'role' => $role,
                'phone' => '+370 600 ' . str_pad((string) $i, 5, '0', STR_PAD_LEFT),
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        $this->db->table('users')->insertBatch($users);

        $subjects = ['Matematika', 'Lietuvių kalba', 'Anglų kalba', 'Fizika', 'Chemija'];
        $tutors = $this->db->table('users')->select('id, company_id')->where('role', 'tutor')->get()->getResultArray();
        $students = $this->db->table('users')->select('id, company_id')->where('role', 'student')->get()->getResultArray();
        $lessons = [];

        for ($i = 1; $i <= 10000; $i++) {
            $tutor = $tutors[$i % count($tutors)];
            $sameCompanyStudents = array_values(array_filter($students, static fn ($s) => (int) $s['company_id'] === (int) $tutor['company_id']));
            $student = $sameCompanyStudents[$i % count($sameCompanyStudents)];
            $starts = date('Y-m-d H:i:s', strtotime(($i - 5000) . ' hours'));
            $lessons[] = [
                'company_id' => $tutor['company_id'],
                'tutor_id' => $tutor['id'],
                'student_id' => $student['id'],
                'subject' => $subjects[$i % count($subjects)],
                'starts_at' => $starts,
                'duration_minutes' => [45, 60, 90][$i % 3],
                'location' => $i % 2 === 0 ? 'Nuotoliniu būdu' : 'Kabinetas ' . (($i % 12) + 1),
                'status' => strtotime($starts) < time() ? 'completed' : 'planned',
                'price' => 20 + ($i % 30),
                'homework' => 'Pakartoti pamokos medžiagą #' . $i,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            if (count($lessons) === 500) {
                $this->db->table('lessons')->insertBatch($lessons);
                $lessons = [];
            }
        }
        if ($lessons) {
            $this->db->table('lessons')->insertBatch($lessons);
        }

        $this->db->table('action_logs')->insert([
            'user_id' => 1,
            'class_name' => __CLASS__,
            'method_name' => __FUNCTION__,
            'action' => 'seed',
            'message' => 'Sukurti demonstraciniai duomenys: 100 vartotojų ir 10000 pamokų.',
            'created_at' => $now,
        ]);
    }
}
