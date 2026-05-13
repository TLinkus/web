<?php

namespace App\Controllers;

use App\Models\CompanyModel;
use App\Models\LessonModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $user = (new UserModel())->find(session('user_id'));
        $month = $this->request->getGet('month') ?: date('Y-m');
        if (! preg_match('/^\d{4}-\d{2}$/', $month)) {
            $month = date('Y-m');
        }

        $monthStart = new \DateTimeImmutable($month . '-01 00:00:00');
        $monthEnd = $monthStart->modify('last day of this month')->setTime(23, 59, 59);
        $calendarStart = $monthStart->modify('-' . ((int) $monthStart->format('N') - 1) . ' days');
        $calendarEnd = $monthEnd->modify('+' . (7 - (int) $monthEnd->format('N')) . ' days');

        $calendarLessons = (new LessonModel())->scopedFor($user)
            ->where('lessons.starts_at >=', $calendarStart->format('Y-m-d H:i:s'))
            ->where('lessons.starts_at <=', $calendarEnd->format('Y-m-d H:i:s'))
            ->orderBy('lessons.starts_at', 'ASC')
            ->findAll();

        $lessonsByDay = [];
        foreach ($calendarLessons as $lesson) {
            $day = date('Y-m-d', strtotime($lesson['starts_at']));
            $lessonsByDay[$day][] = $lesson;
        }

        $weeks = [];
        $cursor = $calendarStart;
        while ($cursor <= $calendarEnd) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $key = $cursor->format('Y-m-d');
                $week[] = [
                    'date' => $key,
                    'day' => $cursor->format('j'),
                    'isCurrentMonth' => $cursor->format('Y-m') === $monthStart->format('Y-m'),
                    'isToday' => $key === date('Y-m-d'),
                    'lessons' => $lessonsByDay[$key] ?? [],
                ];
                $cursor = $cursor->modify('+1 day');
            }
            $weeks[] = $week;
        }

        $upcoming = (new LessonModel())->scopedFor($user)
            ->where('lessons.starts_at >=', date('Y-m-d H:i:s'))
            ->orderBy('lessons.starts_at', 'ASC')
            ->findAll(5);
        $unfinished = (new LessonModel())->scopedFor($user)
            ->join('lesson_entries', 'lesson_entries.lesson_id = lessons.id', 'left')
            ->where('lessons.starts_at <', date('Y-m-d H:i:s'))
            ->groupStart()
            ->where('lesson_entries.id', null)
            ->orWhere('lesson_entries.tutor_comment', '')
            ->groupEnd()
            ->orderBy('lessons.starts_at', 'DESC')
            ->findAll(5);

        $companyUsersModel = new UserModel();
        if (session('active_company_id')) {
            $companyUsersModel->where('company_id', session('active_company_id'));
        }

        return view('dashboard/index', [
            'title' => 'Valdymo skydelis',
            'user' => $user,
            'companies' => session('role') === 'system_admin' ? (new CompanyModel())->orderBy('name')->findAll() : [],
            'companyUsers' => in_array(session('role'), ['system_admin', 'company_admin'], true) ? $companyUsersModel->orderBy('role')->paginate(20) : [],
            'calendarWeeks' => $weeks,
            'calendarTitle' => $this->monthName((int) $monthStart->format('n')) . ' ' . $monthStart->format('Y'),
            'previousMonth' => $monthStart->modify('-1 month')->format('Y-m'),
            'nextMonth' => $monthStart->modify('+1 month')->format('Y-m'),
            'upcoming' => $upcoming,
            'unfinished' => $unfinished,
        ]);
    }

    private function monthName(int $month): string
    {
        return [
            1 => 'Sausis',
            2 => 'Vasaris',
            3 => 'Kovas',
            4 => 'Balandis',
            5 => 'Gegužė',
            6 => 'Birželis',
            7 => 'Liepa',
            8 => 'Rugpjūtis',
            9 => 'Rugsėjis',
            10 => 'Spalis',
            11 => 'Lapkritis',
            12 => 'Gruodis',
        ][$month];
    }
}
