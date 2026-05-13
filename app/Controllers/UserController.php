<?php

namespace App\Controllers;

use App\Models\CompanyModel;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function index(): string
    {
        $model = new UserModel();
        if (session('role') === 'company_admin') {
            $model->where('company_id', session('company_id'));
        } elseif (session('active_company_id')) {
            $model->where('company_id', session('active_company_id'));
        }

        return view('users/index', ['title' => 'Vartotojai', 'users' => $model->orderBy('role')->paginate(20), 'pager' => $model->pager]);
    }

    public function show($id): string
    {
        return view('users/show', ['title' => 'Vartotojas', 'userItem' => (new UserModel())->find($id)]);
    }

    public function new(): string
    {
        return view('users/form', ['title' => 'Naujas vartotojas', 'userItem' => null, 'companies' => (new CompanyModel())->findAll()]);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $data['password_hash'] = password_hash($data['password'] ?? 'Pamoka123', PASSWORD_DEFAULT);
        unset($data['password']);
        $model = new UserModel();
        if (! $model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
        return redirect()->to('/users')->with('success', 'Vartotojas sukurtas.');
    }

    public function edit($id): string
    {
        return view('users/form', ['title' => 'Redaguoti vartotoją', 'userItem' => (new UserModel())->find($id), 'companies' => (new CompanyModel())->findAll()]);
    }

    public function update($id)
    {
        $model = new UserModel();
        if (! $model->update($id, $this->request->getPost())) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
        return redirect()->to('/users')->with('success', 'Vartotojas atnaujintas.');
    }

    public function delete($id)
    {
        (new UserModel())->delete($id);
        return redirect()->to('/users')->with('success', 'Vartotojas ištrintas.');
    }
}
