<?php namespace App\Models;

use CodeIgniter\Model;

class DataModel extends Model{
    protected $table            = 'data';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';
    protected $allowedFields    = ['numero', 'boleta_id', 'pareja_ganadora', 'puntos', 'duracion'];
}