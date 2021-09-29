<?php namespace App\Models;

use CodeIgniter\Model;

class DataModel extends Model{
    protected $table            = 'data';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';
    protected $allowedFields    = [ 'pareja_ganadora', 'puntos'];
}