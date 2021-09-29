<?php namespace App\Models;

use CodeIgniter\Model;

class BoletaParejaModel extends Model{
    protected $table            = 'boleta_pareja';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';
    protected $allowedFields    = ['boleta_id', 'pareja_id', 'salidor', 'tantos', 'resultado', 'ganador'];

    protected $useTimestamps    = true;
    protected $createdField     = 'inicio';
    protected $updatedField     = 'duracion';

}