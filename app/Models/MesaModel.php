<?php namespace App\Models;

use CodeIgniter\Model;

class MesaModel extends Model{
    protected $table            = 'mesa';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';
    protected $allowedFields    = ['numero','evento_id'];

    // protected $useTimestamps    = true;
    // protected $createdField     = 'inicio';
    // protected $updatedField     = 'cierre';

    protected $validationRules  = [
        'numero'        => 'required|numeric'
    ];

    protected $skipValidation   = false;

}