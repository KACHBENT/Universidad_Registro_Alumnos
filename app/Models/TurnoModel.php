<?php

namespace App\Models;

use CodeIgniter\Model;

class TurnoModel extends Model
{
    protected $table            = 'tbl_cat_turno';
    protected $primaryKey       = 'turnoId';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'turno_Valor',
        'turno_Sigla',
        'turno_Activo',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'turno_Valor'  => 'required|min_length[3]|max_length[15]',
        'turno_Sigla'  => 'required|min_length[1]|max_length[5]',
        'turno_Activo' => 'permit_empty|in_list[0,1]',
    ];

    public function getActivos(): array
    {
        return $this->where('turno_Activo', 1)
            ->orderBy('turno_Valor', 'ASC')
            ->findAll();
    }
}
