<?php namespace App\Models;

use CodeIgniter\Model;

class BoletaModel extends Model{
    protected $table            = 'boleta';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';
    protected $allowedFields    = ['evento_id', 'ronda_id', 'mesa_id', 'es_valida', 'fecha_registro'];

    // protected $useTimestamps    = true;
    // protected $createdField     = 'fecha_registro';

}