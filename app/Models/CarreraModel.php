<?php

namespace App\Models;

use CodeIgniter\Model;

class CarreraModel extends Model
{
    protected $table            = 'tbl_cat_carrera';
    protected $primaryKey       = 'carreraId';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'carrera_Valor',
        'carrera_Sigla',
        'carrera_Activo',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'carrera_Valor'  => 'required|min_length[3]|max_length[50]',
        'carrera_Sigla'  => 'required|min_length[1]|max_length[12]',
        'carrera_Activo' => 'permit_empty|in_list[0,1]',
    ];

    public function getActivas(): array
    {
        return $this->where('carrera_Activo', 1)->findAll();
    }
}
