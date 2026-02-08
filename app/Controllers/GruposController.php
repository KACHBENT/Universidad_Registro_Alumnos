<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GrupoModel;
use App\Models\TurnoModel;
use App\Models\CarreraModel;

class GruposController extends BaseController
{
    protected GrupoModel $grupoModel;
    protected TurnoModel $turnoModel;
    protected CarreraModel $carreraModel;

    public function __construct()
    {
        $this->grupoModel   = new GrupoModel();
        $this->turnoModel   = new TurnoModel();
        $this->carreraModel = new CarreraModel();
    }

    private function badge(int $activo): string
    {
        return $activo === 1
            ? '<span class="badge bg-success">Activo</span>'
            : '<span class="badge bg-danger">Inactivo</span>';
    }

    private function acciones(array $row): string
    {
        $id = (int)$row['grupoId'];
        $activo = (int)$row['grupo_Activo'];

        $edit = '<a class="btn btn-sm btn-outline-primary" href="'.site_url("operaciones/grupos/edit/$id").'">Editar</a>';
        $toggle = $activo === 1
            ? '<a class="btn btn-sm btn-outline-danger" href="'.site_url("operaciones/grupos/delete/$id").'" onclick="return confirm(\'¿Desactivar grupo?\')">Desactivar</a>'
            : '<a class="btn btn-sm btn-outline-success" href="'.site_url("operaciones/grupos/activar/$id").'" onclick="return confirm(\'¿Activar grupo?\')">Activar</a>';

        return '<div class="d-flex gap-2 flex-wrap">'.$edit.$toggle.'</div>';
    }

    public function index()
    {
        $rows = $this->grupoModel
            ->select("
                g.grupoId,
                g.turnoId,
                g.carreraId,
                g.grupo_Grado,
                g.grupo_Num,
                g.grupo_Activo,
                c.carrera_Valor,
                c.carrera_Sigla,
                t.turno_Valor,
                t.turno_Sigla,
                CONCAT(c.carrera_Sigla, (g.grupo_Grado*100 + g.grupo_Num), '-', t.turno_Sigla) AS grupo_Label
            ")
            ->from('tbl_ope_grupo g')
            ->join('tbl_cat_carrera c', 'c.carreraId = g.carreraId', 'inner')
            ->join('tbl_cat_turno t', 't.turnoId = g.turnoId', 'inner')
            ->orderBy('g.grupoId', 'DESC')
            ->findAll();

        foreach ($rows as &$r) {
            $r['Estatus']  = $this->badge((int)$r['grupo_Activo']);
            $r['Acciones'] = $this->acciones($r);
        }
        unset($r);

        return view('grupos/index', [
            'title' => 'Grupos',
            'rows'  => $rows,
        ]);
    }

    public function create()
    {
        return view('grupos/create', [
            'title'    => 'Nuevo grupo',
            'turnos'   => $this->turnoModel->where('turno_Activo', 1)->orderBy('turno_Valor', 'ASC')->findAll(),
            'carreras' => $this->carreraModel->where('carrera_Activo', 1)->orderBy('carrera_Valor', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'turnoId'     => 'required|is_natural_no_zero',
            'carreraId'   => 'required|is_natural_no_zero',
            'grupo_Grado' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[11]',
            'grupo_Num'   => 'required|integer|greater_than_equal_to[1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('toast_error', $this->validator->getErrors());
        }

        try {
            $this->grupoModel->insert([
                'turnoId'      => (int)$this->request->getPost('turnoId'),
                'carreraId'    => (int)$this->request->getPost('carreraId'),
                'grupo_Grado'  => (int)$this->request->getPost('grupo_Grado'),
                'grupo_Num'    => (int)$this->request->getPost('grupo_Num'),
                'grupo_Activo' => 1,
            ]);

            return redirect()->to(site_url('operaciones/grupos'))
                ->with('toast_success', 'Grupo registrado.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('toast_error', 'Error: '.$e->getMessage());
        }
    }

    public function edit(int $id)
    {
        $row = $this->grupoModel->find($id);
        if (! $row) return redirect()->to(site_url('operaciones/grupos'))->with('toast_error', 'Grupo no encontrado.');

        return view('grupos/edit', [
            'title'    => 'Editar grupo',
            'row'      => $row,
            'turnos'   => $this->turnoModel->where('turno_Activo', 1)->orderBy('turno_Valor', 'ASC')->findAll(),
            'carreras' => $this->carreraModel->where('carrera_Activo', 1)->orderBy('carrera_Valor', 'ASC')->findAll(),
        ]);
    }

    public function update(int $id)
    {
        $rules = [
            'turnoId'     => 'required|is_natural_no_zero',
            'carreraId'   => 'required|is_natural_no_zero',
            'grupo_Grado' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[11]',
            'grupo_Num'   => 'required|integer|greater_than_equal_to[1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('toast_error', $this->validator->getErrors());
        }

        if (! $this->grupoModel->find($id)) {
            return redirect()->to(site_url('operaciones/grupos'))->with('toast_error', 'Grupo no encontrado.');
        }

        try {
            $this->grupoModel->update($id, [
                'turnoId'     => (int)$this->request->getPost('turnoId'),
                'carreraId'   => (int)$this->request->getPost('carreraId'),
                'grupo_Grado' => (int)$this->request->getPost('grupo_Grado'),
                'grupo_Num'   => (int)$this->request->getPost('grupo_Num'),
            ]);

            return redirect()->to(site_url('operaciones/grupos'))
                ->with('toast_success', 'Grupo actualizado.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('toast_error', 'Error: '.$e->getMessage());
        }
    }

    public function delete(int $id)
    {
        if (! $this->grupoModel->find($id)) {
            return redirect()->to(site_url('operaciones/grupos'))->with('toast_error', 'Grupo no encontrado.');
        }

        $this->grupoModel->update($id, ['grupo_Activo' => 0]);
        return redirect()->to(site_url('operaciones/grupos'))->with('toast_success', 'Grupo desactivado.');
    }

    public function activar(int $id)
    {
        if (! $this->grupoModel->find($id)) {
            return redirect()->to(site_url('operaciones/grupos'))->with('toast_error', 'Grupo no encontrado.');
        }

        $this->grupoModel->update($id, ['grupo_Activo' => 1]);
        return redirect()->to(site_url('operaciones/grupos'))->with('toast_success', 'Grupo activado.');
    }
}
