<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarreraModel;

class CarrerasController extends BaseController
{
    protected CarreraModel $model;

    public function __construct()
    {
        $this->model = new CarreraModel();
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
        $id = (int)$row['carreraId'];
        $activo = (int)$row['carrera_Activo'];

        $edit = '<a class="btn btn-sm btn-outline-primary" href="'.site_url("categorias/carreras/edit/$id").'">Editar</a>';
        $toggle = $activo === 1
            ? '<a class="btn btn-sm btn-outline-danger" href="'.site_url("categorias/carreras/delete/$id").'" onclick="return confirm(\'¿Desactivar carrera?\')">Desactivar</a>'
            : '<a class="btn btn-sm btn-outline-success" href="'.site_url("categorias/carreras/activar/$id").'" onclick="return confirm(\'¿Activar carrera?\')">Activar</a>';

        return '<div class="d-flex gap-2 flex-wrap">'.$edit.$toggle.'</div>';
    }

    public function index()
    {
        $rows = $this->model->orderBy('carreraId', 'DESC')->findAll();

        foreach ($rows as &$r) {
            $r['Estatus']  = $this->badge((int)$r['carrera_Activo']);
            $r['Acciones'] = $this->acciones($r);
        }
        unset($r);

        return view('carreras/index', [
            'title' => 'Carreras',
            'rows'  => $rows,
        ]);
    }

    public function create()
    {
        return view('carreras/create', ['title' => 'Nueva carrera']);
    }

    public function store()
    {
        $rules = [
            'carrera_Valor' => 'required|min_length[3]|max_length[50]',
            'carrera_Sigla' => 'required|min_length[1]|max_length[12]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('toast_error', $this->validator->getErrors());
        }

        try {
            $this->model->insert([
                'carrera_Valor'  => $this->upper($this->request->getPost('carrera_Valor')),
                'carrera_Sigla'  => $this->upper($this->request->getPost('carrera_Sigla')),
                'carrera_Activo' => 1,
            ]);

            return redirect()->to(site_url('categorias/carreras'))
                ->with('toast_success', 'Carrera registrada.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('toast_error', 'Error: '.$e->getMessage());
        }
    }

    public function edit(int $id)
    {
        $row = $this->model->find($id);
        if (! $row) return redirect()->to(site_url('categorias/carreras'))->with('toast_error', 'Carrera no encontrada.');

        return view('carreras/edit', [
            'title' => 'Editar carrera',
            'row'   => $row,
        ]);
    }

    public function update(int $id)
    {
        $rules = [
            'carrera_Valor' => 'required|min_length[3]|max_length[50]',
            'carrera_Sigla' => 'required|min_length[1]|max_length[12]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('toast_error', $this->validator->getErrors());
        }

        try {
            $this->model->update($id, [
                'carrera_Valor' => $this->upper($this->request->getPost('carrera_Valor')),
                'carrera_Sigla' => $this->upper($this->request->getPost('carrera_Sigla')),
            ]);

            return redirect()->to(site_url('categorias/carreras'))
                ->with('toast_success', 'Carrera actualizada.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('toast_error', 'Error: '.$e->getMessage());
        }
    }

    public function delete(int $id)
    {
        if (! $this->model->find($id)) {
            return redirect()->to(site_url('categorias/carreras'))->with('toast_error', 'Carrera no encontrada.');
        }

        $this->model->update($id, ['carrera_Activo' => 0]);
        return redirect()->to(site_url('categorias/carreras'))->with('toast_success', 'Carrera desactivada.');
    }

    public function activar(int $id)
    {
        if (! $this->model->find($id)) {
            return redirect()->to(site_url('categorias/carreras'))->with('toast_error', 'Carrera no encontrada.');
        }

        $this->model->update($id, ['carrera_Activo' => 1]);
        return redirect()->to(site_url('categorias/carreras'))->with('toast_success', 'Carrera activada.');
    }
}
