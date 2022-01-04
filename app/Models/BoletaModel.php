<?php namespace App\Models;

use CodeIgniter\Model;

class BoletaModel extends Model{
    protected $table            = 'boleta';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';
    protected $allowedFields    = ['evento_id', 'ronda_id', 'mesa_id', 'estado', 'es_valida'];

    // protected $useTimestamps    = true;
    // protected $createdField     = 'fecha_registro';

    public function esUltimaBoletaRonda($ronda_id)
    {
        $builder = $this->db->table('boleta');
        $builder->where('estado', 'F');
        $builder->where('ronda_id', $ronda_id);        
        $cant =  $builder->countAllResults();

        $builder = $this->db->table('boleta');
        $builder->where('ronda_id', $ronda_id);
        $cantRondas =  $builder->countAllResults();

        return ($cantRondas - $cant) == 0;
    }

}