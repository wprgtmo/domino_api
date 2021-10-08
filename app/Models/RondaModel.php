<?php namespace App\Models;

use CodeIgniter\Model;

class RondaModel extends Model{
    protected $table            = 'ronda';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';
    protected $allowedFields    = ['numero', 'evento_id','comentario', 'cerrada', 'dia'];

    protected $useTimestamps    = true;
    protected $createdField     = 'inicio';
    protected $updatedField     = 'cierre';

    protected $validationRules  = [
        'numero'        => 'required|numeric',
        'comentario'    => 'permit_empty|max_length[255]'
    ];

    protected $skipValidation   = false;

}