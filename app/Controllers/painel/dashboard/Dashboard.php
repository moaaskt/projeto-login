<?php

namespace App\Controllers\painel\dashboard;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        $data['email'] = $session->get('email');
        return view('painel/dashboard/index', $data);
    }

    public function perfil()
    {
        return view('painel/perfil/index');
    }

    public function faturas()
    {
        return view('painel/faturas/index');
    }
}