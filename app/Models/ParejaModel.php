<?php namespace App\Models;

use CodeIgniter\Model;

class ParejaModel extends Model{
    protected $table            = 'pareja';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre', 'evento_id','jugador1_id', 'jugador2_id'];


    protected $validationRules  = [
        'nombre'        => 'required|max_length[60]'
    ];

    protected $skipValidation   = false;


    public function existeJugadorParejasEvento($evento_id, $nro, $jugador_id)
    {
        $builder = $this->db->table('pareja');
        $builder->where('evento_id', $evento_id);
        $builder->where('jugador'.$nro.'_id', $jugador_id);
        return $builder->countAllResults();
    }

}