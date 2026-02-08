<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TurnoModel;

class TurnosController extends BaseController
{
    protected TurnoModel $model;

    public function __construct()
    {
        $this->model = new TurnoModel();
    }

    private function upper($v): string
    {
        return mb_strtoupper(trim((string)$v), 'UTF-8');
    }

    private function badge(int $activo): string
    {
        return $activo === 1
            ? '<span class="badge bg-success">Activo</span>'
            : '<span class="badge bg-danger">Inactivo</span>';
    }

    private function acciones(array $row): string
    {
        $id = (int)$row['turnoId'];
        $activo = (int)$row['turno_Activo'];

        $edit = '<a class="btn btn-sm btn-outline-primary" href="'.site_url("categorias/turnos/edit/$id").'">Editar</a>';
        $toggle = $activo === 1
            ? '<a class="btn btn-sm btn-outline-danger" href="'.site_url("categorias/turnos/delete/$id").'" onclick="return confirm(\'¿Desactivar turno?\')">Desactivar</a>'
            : '<a class="btn btn-sm btn-outline-success" href="'.site_url("categorias/turnos/activar/$id").'" onclick="return confirm(\'¿Activar turno?\')">Activar</a>';

        return '<div class="d-flex gap-2 flex-wrap">'.$edit.$toggle.'</div>';
    }

    public function index()
    {
        $rows = $this->model->orderBy('turnoId', 'DESC')->findAll();

        foreach ($rows as &$r) {
            $r['Estatus']  = $this->badge((int)$r['turno_Activo']);
            $r['Acciones'] = $this->acciones($r);
        }
        unset($r);

        return view('turnos/index', [
            'title' => 'Turnos',
            'rows'  => $rows,
        ]);
    }

    public function create()
    {
        return view('turnos/create', ['title' => 'Nuevo turno']);
    }

    public function store()
    {
        $rules = [
            'turno_Valor' => 'required|min_length[3]|max_length[15]',
            'turno_Sigla' => 'required|min_length[1]|max_length[5]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('toast_error', $this->validator->getErrors());
        }

        try {
            $this->model->insert([
                'turno_Valor'  => $this->upper($this->request->getPost('turno_Valor')),
                'turno_Sigla'  => $this->upper($this->request->getPost('turno_Sigla')),
                'turno_Activo' => 1,
            ]);

            return redirect()->to(site_url('categorias/turnos'))
                ->with('toast_success', 'Turno registrado.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('toast_error', 'Error: '.$e->getMessage());
        }
    }

    public function edit(int $id)
    {
        $row = $this->model->find($id);
        if (! $row) return redirect()->to(site_url('categorias/turnos'))->with('toast_error', 'Turno no encontrado.');

        return view('turnos/edit', [
            'title' => 'Editar turno',
            'row'   => $row,
        ]);
    }

    public function update(int $id)
    {
        $rules = [
            'turno_Valor' => 'required|min_length[3]|max_length[15]',
            'turno_Sigla' => 'required|min_length[1]|max_length[5]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('toast_error', $this->validator->getErrors());
        }

        try {
            $this->model->update($id, [
                'turno_Valor' => $this->upper($this->request->getPost('turno_Valor')),
                'turno_Sigla' => $this->upper($this->request->getPost('turno_Sigla')),
            ]);

            return redirect()->to(site_url('categorias/turnos'))
                ->with('toast_success', 'Turno actualizado.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('toast_error', 'Error: '.$e->getMessage());
        }
    }

    public function delete(int $id)
    {
        if (! $this->model->find($id)) {
            return redirect()->to(site_url('categorias/turnos'))->with('toast_error', 'Turno no encontrado.');
        }

        $this->model->update($id, ['turno_Activo' => 0]);
        return redirect()->to(site_url('categorias/turnos'))->with('toast_success', 'Turno desactivado.');
    }

    public function activar(int $id)
    {
        if (! $this->model->find($id)) {
            return redirect()->to(site_url('categorias/turnos'))->with('toast_error', 'Turno no encontrado.');
        }

        $this->model->update($id, ['turno_Activo' => 1]);
        return redirect()->to(site_url('categorias/turnos'))->with('toast_success', 'Turno activado.');
    }
}
