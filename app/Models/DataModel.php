<?php namespace App\Models;

use CodeIgniter\Model;

class DataModel extends Model{
    protected $table            = 'data';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';
    protected $allowedFields    = ['numero', 'boleta_id', 'pareja_ganadora', 'puntos', 'duracion'];



    public function getTotalTantos($boleta_id, $pareja_ganadora)
    {
        $builder = $this->db->table('data');
        $builder->select('SUM(data.puntos) AS TotalPuntos');
        $builder->where('boleta_id', $boleta_id);
        $builder->where('pareja_ganadora', $pareja_ganadora);
        $query = $builder->get();
        $tantos = $query->getResult();
        return $tantos[0]->TotalPuntos;
    }
}