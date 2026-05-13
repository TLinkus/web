<?php

namespace App\Controllers;

use App\Models\ActionLogModel;

class LogController extends BaseController
{
    public function index(): string
    {
        $model = new ActionLogModel();
        return view('logs/index', ['title' => 'Veiksmų žurnalas', 'logs' => $model->orderBy('created_at', 'DESC')->paginate(20), 'pager' => $model->pager]);
    }
}
