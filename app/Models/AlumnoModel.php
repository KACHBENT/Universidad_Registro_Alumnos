<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumnoModel extends Model
{
    protected $table            = 'tbl_ope_alumno';
    protected $primaryKey       = 'alumnoId';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'personaId',
        'grupoId',
        'alumno_Activo',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'personaId'     => 'required|is_natural_no_zero',
        'grupoId'       => 'required|is_natural_no_zero',
        'alumno_Activo' => 'permit_empty|in_list[0,1]',
    ];
    
    public function getListadoActivos(): array
    {
        return $this->select("
                alum.alumnoId AS Id_Alumno,
                CONCAT(per.persona_Nombre,' ',per.persona_ApllP,' ',IFNULL(per.persona_ApllM,'')) AS Nombre_Completo,
                CONCAT(carr.carrera_Sigla, (grup.grupo_Grado*100 + grup.grupo_Num), '-', turn.turno_Sigla) AS Grupo,
                alum.alumno_Activo AS Activo
            ")
            ->from($this->table . ' alum')
            ->join('tbl_ope_grupo grup', 'alum.grupoId = grup.grupoId', 'inner')
            ->join('tbl_cat_carrera carr', 'grup.carreraId = carr.carreraId', 'inner')
            ->join('tbl_rel_persona per', 'alum.personaId = per.personaId', 'inner')
            ->join('tbl_cat_turno turn', 'grup.turnoId = turn.turnoId', 'inner')
            ->where('alum.alumno_Activo', 1)
            ->orderBy('alum.alumnoId', 'DESC')
            ->findAll();
    }

    public function getAllEstudiantesActivos(): array
    {
        return $this->select("
                alum.alumnoId AS AlumnoId,
                CONCAT(per.persona_Nombre,' ',per.persona_ApllP,' ',IFNULL(per.persona_ApllM,'')) AS Nombre_Completo,
                carr.carrera_Valor AS Carrera_Asignado,
                turn.turno_Valor AS Turno_Asignado,
                CONCAT(carr.carrera_Sigla, (grup.grupo_Grado*100 + grup.grupo_Num), '-', turn.turno_Sigla) AS Grupo_Asignado,
                alum.alumno_Activo AS estatus_Alumno
            ")
            ->from($this->table . ' alum')
            ->join('tbl_rel_persona per', 'alum.personaId = per.personaId', 'inner')
            ->join('tbl_ope_grupo grup', 'alum.grupoId = grup.grupoId', 'inner')
            ->join('tbl_cat_carrera carr', 'grup.carreraId = carr.carreraId', 'inner')
            ->join('tbl_cat_turno turn', 'grup.turnoId = turn.turnoId', 'inner')
            ->where('alum.alumno_Activo', 1)
            ->orderBy('alum.alumnoId', 'DESC')
            ->findAll();
    }
}
