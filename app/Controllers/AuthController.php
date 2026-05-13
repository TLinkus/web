<?php

namespace App\Controllers;

use App\Models\ActionLogModel;
use App\Models\CompanyModel;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login(): string
    {
        return view('auth/login', ['title' => 'Prisijungimas']);
    }

    public function attemptLogin()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = (new UserModel())->byEmail($this->request->getPost('email'));
        if (! $user || ! password_verify($this->request->getPost('password'), $user['password_hash']) || $user['status'] !== 'active') {
            (new ActionLogModel())->record(__CLASS__, __FUNCTION__, 'login_failed', 'Nepavykęs prisijungimas: ' . $this->request->getPost('email'));
            return redirect()->back()->withInput()->with('error', 'Neteisingi prisijungimo duomenys arba vartotojas neaktyvus.');
        }

        session()->set([
            'user_id' => (int) $user['id'],
            'company_id' => $user['company_id'] ? (int) $user['company_id'] : null,
            'role' => $user['role'],
            'name' => $user['name'],
            'active_company_id' => $user['role'] === 'system_admin' ? null : $user['company_id'],
        ]);

        (new ActionLogModel())->record(__CLASS__, __FUNCTION__, 'login_success', 'Vartotojas prisijungė.', (int) $user['id']);
        return redirect()->to('/dashboard');
    }

    public function register(): string
    {
        return view('auth/register', ['title' => 'Registracija', 'companies' => (new CompanyModel())->where('status', 'active')->findAll()]);
    }

    public function storeRegister()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[120]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]|regex_match[/^(?=.*[A-Za-z])(?=.*\d).+$/]',
            'password_confirm' => 'required|matches[password]',
            'company_id' => 'required|is_natural_no_zero',
            'role' => 'required|in_list[tutor,student]',
            'phone' => 'permit_empty|regex_match[/^\+?[0-9\s\-]{7,20}$/]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $userModel->insert([
            'company_id' => $this->request->getPost('company_id'),
            'name' => trim($this->request->getPost('name')),
            'email' => mb_strtolower($this->request->getPost('email')),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'phone' => $this->request->getPost('phone'),
            'status' => 'active',
        ]);

        (new ActionLogModel())->record(__CLASS__, __FUNCTION__, 'register', 'Užregistruotas naujas vartotojas.');
        return redirect()->to('/login')->with('success', 'Registracija sėkminga. Galite prisijungti.');
    }

    public function logout()
    {
        (new ActionLogModel())->record(__CLASS__, __FUNCTION__, 'logout', 'Vartotojas atsijungė.');
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Sėkmingai atsijungėte.');
    }
}
