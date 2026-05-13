<?php

namespace App\Controllers;

use App\Models\ActionLogModel;
use App\Models\CompanyModel;

class CompanyController extends BaseController
{
    private CompanyModel $companies;

    public function __construct()
    {
        $this->companies = new CompanyModel();
    }

    public function index(): string
    {
        return view('companies/index', ['title' => 'Įmonės', 'companies' => $this->companies->orderBy('name')->paginate(20), 'pager' => $this->companies->pager]);
    }

    public function show($id): string
    {
        return view('companies/show', ['title' => 'Įmonė', 'company' => $this->companies->find($id)]);
    }

    public function new(): string
    {
        return view('companies/form', ['title' => 'Nauja įmonė', 'company' => null]);
    }

    public function create()
    {
        if (! $this->companies->insert($this->request->getPost())) {
            return redirect()->back()->withInput()->with('errors', $this->companies->errors());
        }
        (new ActionLogModel())->record(__CLASS__, __FUNCTION__, 'company_create', 'Sukurta įmonė.');
        return redirect()->to('/companies')->with('success', 'Įmonė sukurta.');
    }

    public function edit($id): string
    {
        return view('companies/form', ['title' => 'Redaguoti įmonę', 'company' => $this->companies->find($id)]);
    }

    public function update($id)
    {
        if (! $this->companies->update($id, $this->request->getPost())) {
            return redirect()->back()->withInput()->with('errors', $this->companies->errors());
        }
        (new ActionLogModel())->record(__CLASS__, __FUNCTION__, 'company_update', 'Atnaujinta įmonė #' . $id);
        return redirect()->to('/companies')->with('success', 'Įmonė atnaujinta.');
    }

    public function delete($id)
    {
        $this->companies->delete($id);
        (new ActionLogModel())->record(__CLASS__, __FUNCTION__, 'company_delete', 'Ištrinta įmonė #' . $id);
        return redirect()->to('/companies')->with('success', 'Įmonė ištrinta.');
    }

    public function switch($id)
    {
        session()->set('active_company_id', (int) $id);
        (new ActionLogModel())->record(__CLASS__, __FUNCTION__, 'company_switch', 'Sistemos administratorius pasirinko įmonę #' . $id);
        return redirect()->to('/dashboard')->with('success', 'Įmonė pasirinkta.');
    }
}
