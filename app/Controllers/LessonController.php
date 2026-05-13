<?php

namespace App\Controllers;

use App\Models\ActionLogModel;
use App\Models\CompanyModel;
use App\Models\LessonEntryModel;
use App\Models\LessonModel;
use App\Models\UserModel;

class LessonController extends BaseController
{
    private LessonModel $lessons;

    public function __construct()
    {
        $this->lessons = new LessonModel();
    }

    public function index(): string
    {
        $user = (new UserModel())->find(session('user_id'));
        $lessons = $this->lessons->scopedFor($user)->orderBy('lessons.starts_at', 'DESC')->paginate(20);
        return view('lessons/index', ['title' => 'Pamokos', 'lessons' => $lessons, 'pager' => $this->lessons->pager]);
    }

    public function show($id): string
    {
        return view('lessons/show', [
            'title' => 'Pamoka',
            'lesson' => $this->lessons->select('lessons.*, tutors.name AS tutor_name, students.name AS student_name, companies.name AS company_name')
                ->join('users tutors', 'tutors.id = lessons.tutor_id')
                ->join('users students', 'students.id = lessons.student_id')
                ->join('companies', 'companies.id = lessons.company_id')
                ->find($id),
            'entry' => (new LessonEntryModel())->where('lesson_id', $id)->first(),
        ]);
    }

    public function new(): string
    {
        return view('lessons/form', $this->formData('Nauja pamoka', null));
    }

    public function create()
    {
        $data = $this->request->getPost();
        $data['starts_at'] = str_replace('T', ' ', $data['starts_at']);
        if (! $this->lessons->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->lessons->errors());
        }
        (new ActionLogModel())->record(__CLASS__, __FUNCTION__, 'lesson_create', 'Sukurta pamoka.');
        return redirect()->to('/lessons')->with('success', 'Pamoka sukurta.');
    }

    public function edit($id): string
    {
        return view('lessons/form', $this->formData('Redaguoti pamoką', $this->lessons->find($id)));
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $data['starts_at'] = str_replace('T', ' ', $data['starts_at']);
        if (! $this->lessons->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->lessons->errors());
        }
        (new ActionLogModel())->record(__CLASS__, __FUNCTION__, 'lesson_update', 'Atnaujinta pamoka #' . $id);
        return redirect()->to('/lessons')->with('success', 'Pamoka atnaujinta.');
    }

    public function delete($id)
    {
        $this->lessons->delete($id);
        (new ActionLogModel())->record(__CLASS__, __FUNCTION__, 'lesson_delete', 'Ištrinta pamoka #' . $id);
        return redirect()->to('/lessons')->with('success', 'Pamoka ištrinta.');
    }

    private function formData(string $title, ?array $lesson): array
    {
        $companyId = session('role') === 'system_admin' ? session('active_company_id') : session('company_id');
        $users = (new UserModel())->where('company_id', $companyId)->where('status', 'active')->findAll();

        return [
            'title' => $title,
            'lesson' => $lesson,
            'companies' => (new CompanyModel())->findAll(),
            'tutors' => array_filter($users, static fn ($u) => $u['role'] === 'tutor'),
            'students' => array_filter($users, static fn ($u) => $u['role'] === 'student'),
            'companyId' => $companyId,
        ];
    }
}
