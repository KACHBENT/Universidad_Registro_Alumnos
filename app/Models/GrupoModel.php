<?php

namespace App\Models;

use CodeIgniter\Model;

class GrupoModel extends Model
{
    protected $table            = 'tbl_ope_grupo';
    protected $primaryKey       = 'grupoId';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'turnoId',
        'carreraId',
        'grupo_Grado',
        'grupo_Num',
        'grupo_Activo',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'turnoId'      => 'required|is_natural_no_zero',
        'carreraId'    => 'required|is_natural_no_zero',
        'grupo_Grado'  => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[11]',
        'grupo_Num'    => 'required|integer|greater_than_equal_to[1]',
        'grupo_Activo' => 'permit_empty|in_list[0,1]',
    ];

    public function getActivosConDetalle(): array
    {
        return $this->select("
                g.*,
                c.carrera_Valor,
                c.carrera_Sigla,
                t.turno_Valor,
                t.turno_Sigla,
                CONCAT(c.carrera_Sigla, (g.grupo_Grado*100 + g.grupo_Num), '-', t.turno_Sigla) AS grupo_Label
            ")
            ->from($this->table . ' g')
            ->join('tbl_cat_carrera c', 'c.carreraId = g.carreraId', 'inner')
            ->join('tbl_cat_turno t', 't.turnoId = g.turnoId', 'inner')
            ->where('g.grupo_Activo', 1)
            ->orderBy('c.carrera_Sigla', 'ASC')
            ->orderBy('g.grupo_Grado', 'ASC')
            ->orderBy('g.grupo_Num', 'ASC')
            ->findAll();
    }
}
