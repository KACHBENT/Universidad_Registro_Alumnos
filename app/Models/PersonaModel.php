<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonaModel extends Model
{
    protected $table            = 'tbl_rel_persona';
    protected $primaryKey       = 'personaId';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'persona_Nombre',
        'persona_ApllP',
        'persona_ApllM',
        'persona_Activo',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'persona_Nombre'  => 'required|min_length[2]|max_length[35]',
        'persona_ApllP'   => 'required|min_length[2]|max_length[35]',
        'persona_ApllM'   => 'permit_empty|max_length[35]',
        'persona_Activo'  => 'permit_empty|in_list[0,1]',
    ];

    public function getActivas(): array
    {
        return $this->where('persona_Activo', 1)->findAll();
    }
}
