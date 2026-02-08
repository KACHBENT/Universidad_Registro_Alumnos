<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AlumnoModel;
use App\Models\PersonaModel;
use App\Models\GrupoModel;

class AlumnoController extends BaseController
{
    protected AlumnoModel $alumnoModel;
    protected PersonaModel $personaModel;
    protected GrupoModel $grupoModel;

    public function __construct()
    {
        $this->alumnoModel  = new AlumnoModel();
        $this->personaModel = new PersonaModel();
        $this->grupoModel   = new GrupoModel();
    }

    private function upper($value): ?string
    {
        $value = trim((string) $value);
        if ($value === '') return null;
        return mb_strtoupper($value, 'UTF-8');
    }

    private function badgeEstatus(int $activo): string
    {
        return $activo === 1
            ? '<span class="badge bg-success">Activo</span>'
            : '<span class="badge bg-danger">Inactivo</span>';
    }

    private function accionesHtml(array $row): string
    {
        $id = (int) ($row['AlumnoId'] ?? 0);
        $activo = (int) ($row['estatus_Alumno'] ?? 0);

        $btnEdit = '<a class="btn btn-sm btn-outline-primary" href="' . site_url('alumnos/edit/' . $id) . '">Editar</a>';

        if ($activo === 1) {
            $btnToggle = '<a class="btn btn-sm btn-outline-danger" href="' . site_url('alumnos/delete/' . $id) . '"
                onclick="return confirm(\'¿Desactivar alumno?\')">Desactivar</a>';
        } else {
            $btnToggle = '<a class="btn btn-sm btn-outline-success" href="' . site_url('alumnos/activar/' . $id) . '"
                onclick="return confirm(\'¿Activar alumno?\')">Activar</a>';
        }

        return '<div class="d-flex gap-2 flex-wrap">' . $btnEdit . $btnToggle . '</div>';
    }

    // =========================
    // INDEX
    // =========================
    public function index()
    {
        $rows = $this->alumnoModel
            ->select("
                alum.alumnoId AS AlumnoId,
                CONCAT(per.persona_Nombre,' ',per.persona_ApllP,' ',IFNULL(per.persona_ApllM,'')) AS Nombre_Completo,
                carr.carrera_Valor AS Carrera_Asignado,
                turn.turno_Valor AS Turno_Asignado,
                CONCAT(carr.carrera_Sigla, (grup.grupo_Grado*100 + grup.grupo_Num), '-', turn.turno_Sigla) AS Grupo_Asignado,
                alum.alumno_Activo AS estatus_Alumno
            ")
            ->from('tbl_ope_alumno alum')
            ->join('tbl_rel_persona per', 'alum.personaId = per.personaId', 'inner')
            ->join('tbl_ope_grupo grup', 'alum.grupoId = grup.grupoId', 'inner')
            ->join('tbl_cat_carrera carr', 'grup.carreraId = carr.carreraId', 'inner')
            ->join('tbl_cat_turno turn', 'grup.turnoId = turn.turnoId', 'inner')
            ->orderBy('alum.alumnoId', 'DESC')
            ->findAll();

        foreach ($rows as &$r) {
            $r['Estatus']  = $this->badgeEstatus((int) $r['estatus_Alumno']);
            $r['Acciones'] = $this->accionesHtml($r);
        }
        unset($r);

        return view('alumnos/index', [
            'title' => 'Alumnos',
            'rows'  => $rows,
        ]);
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        return view('alumnos/create', [
            'title'  => 'Registrar alumno',
            'grupos' => $this->grupoModel->getActivosConDetalle(),
        ]);
    }

    // =========================
    // STORE
    // =========================
    public function store()
    {
        $rules = [
            'persona_Nombre' => 'required|min_length[2]|max_length[35]',
            'persona_ApllP'  => 'required|min_length[2]|max_length[35]',
            'persona_ApllM'  => 'permit_empty|max_length[35]',
            'grupoId'        => 'required|is_natural_no_zero',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('toast_error', $this->validator->getErrors());
        }

        $grupoId = (int) $this->request->getPost('grupoId');

        $grupo = $this->grupoModel->where('grupoId', $grupoId)->where('grupo_Activo', 1)->first();
        if (! $grupo) {
            return redirect()->back()
                ->withInput()
                ->with('toast_error', ['grupoId' => 'El grupo seleccionado no existe o está inactivo.']);
        }

        $db = db_connect();
        $db->transBegin();

        try {
            $this->personaModel->insert([
                'persona_Nombre' => $this->upper($this->request->getPost('persona_Nombre')),
                'persona_ApllP'  => $this->upper($this->request->getPost('persona_ApllP')),
                'persona_ApllM'  => $this->upper($this->request->getPost('persona_ApllM')),
                'persona_Activo' => 1,
            ]);

            $personaId = (int) $this->personaModel->getInsertID();
            if ($personaId <= 0) throw new \RuntimeException('No se pudo generar personaId.');

            $this->alumnoModel->insert([
                'personaId'     => $personaId,
                'grupoId'       => $grupoId,
                'alumno_Activo' => 1,
            ]);

            $alumnoId = (int) $this->alumnoModel->getInsertID();
            if ($alumnoId <= 0) throw new \RuntimeException('No se pudo generar alumnoId.');

            if ($db->transStatus() === false) throw new \RuntimeException('Falló la transacción.');

            $db->transCommit();

            return redirect()->to(site_url('alumnos'))
                ->with('toast_success', " Alumno registrado correctamente (ID: {$alumnoId}).");

        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()
                ->withInput()
                ->with('toast_error', 'Error al registrar: ' . $e->getMessage());
        }
    }

    // =========================
    // EDIT
    // =========================
    public function edit(int $id)
    {
        $alumno = $this->alumnoModel
            ->select("
                alum.alumnoId,
                alum.personaId,
                alum.grupoId,
                alum.alumno_Activo,
                per.persona_Nombre,
                per.persona_ApllP,
                per.persona_ApllM
            ")
            ->from('tbl_ope_alumno alum')
            ->join('tbl_rel_persona per', 'alum.personaId = per.personaId', 'inner')
            ->where('alum.alumnoId', $id)
            ->first();

        if (! $alumno) {
            return redirect()->to(site_url('alumnos'))
                ->with('toast_error', 'Alumno no encontrado.');
        }

        return view('alumnos/edit', [
            'title'  => 'Editar alumno',
            'alumno' => $alumno,
            'grupos' => $this->grupoModel->getActivosConDetalle(),
        ]);
    }

    // =========================
    // UPDATE
    // =========================
    public function update(int $id)
    {
        $rules = [
            'persona_Nombre' => 'required|min_length[2]|max_length[35]',
            'persona_ApllP'  => 'required|min_length[2]|max_length[35]',
            'persona_ApllM'  => 'permit_empty|max_length[35]',
            'grupoId'        => 'required|is_natural_no_zero',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('toast_error', $this->validator->getErrors());
        }

        $alumno = $this->alumnoModel->find($id);
        if (! $alumno) {
            return redirect()->to(site_url('alumnos'))
                ->with('toast_error', 'Alumno no encontrado.');
        }

        $grupoId = (int) $this->request->getPost('grupoId');
        $grupo = $this->grupoModel->where('grupoId', $grupoId)->where('grupo_Activo', 1)->first();
        if (! $grupo) {
            return redirect()->back()
                ->withInput()
                ->with('toast_error', ['grupoId' => 'El grupo seleccionado no existe o está inactivo.']);
        }

        $db = db_connect();
        $db->transBegin();

        try {
            $this->personaModel->update((int) $alumno['personaId'], [
                'persona_Nombre' => $this->upper($this->request->getPost('persona_Nombre')),
                'persona_ApllP'  => $this->upper($this->request->getPost('persona_ApllP')),
                'persona_ApllM'  => $this->upper($this->request->getPost('persona_ApllM')),
            ]);

            $this->alumnoModel->update($id, [
                'grupoId' => $grupoId,
            ]);

            if ($db->transStatus() === false) throw new \RuntimeException('Falló la transacción.');

            $db->transCommit();

            return redirect()->to(site_url('alumnos'))
                ->with('toast_success', " Alumno actualizado correctamente (ID: {$id}).");

        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()
                ->withInput()
                ->with('toast_error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    // =========================
    // DELETE (desactivar)
    // =========================
    public function delete(int $id)
    {
        $alumno = $this->alumnoModel->find($id);
        if (! $alumno) {
            return redirect()->to(site_url('alumnos'))->with('toast_error', 'Alumno no encontrado.');
        }

        $this->alumnoModel->update($id, ['alumno_Activo' => 0]);

        return redirect()->to(site_url('alumnos'))->with('toast_success', 'Alumno desactivado.');
    }

    // =========================
    // ACTIVAR
    // =========================
    public function activar(int $id)
    {
        $alumno = $this->alumnoModel->find($id);
        if (! $alumno) {
            return redirect()->to(site_url('alumnos'))->with('toast_error', 'Alumno no encontrado.');
        }

        $this->alumnoModel->update($id, ['alumno_Activo' => 1]);

        return redirect()->to(site_url('alumnos'))->with('toast_success', 'Alumno activado.');
    }
}
