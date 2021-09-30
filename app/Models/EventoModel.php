<?php namespace App\Models;

use CodeIgniter\Model;

class EventoModel extends Model{
    protected $table            = 'evento';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre', 'comentario', 'ciudad_id','cerrado', 'fecha_inicio', 'fecha_cierre'];

    protected $useTimestamps    = true;
    protected $createdField     = 'creado';
    protected $updatedField     = 'actualizado';

    protected $validationRules  = [
        'nombre'        => 'required|is_unique[evento.nombre]|min_length[3]|max_length[60]',
        'comentario'    => 'permit_empty|max_length[255]'
    ];

    protected $skipValidation   = false;

    public function getRondas($evento_id = null)
    {
        $builder = $this->db->table('ronda');
        $builder->select('ronda.*');
        $builder->where('evento_id', $evento_id);
        $query = $builder->get();
        return $query->getResult ();
    }

        
    public function getRondaActiva($evento_id = null)
    {
        $builder = $this->db->table('ronda');
        $builder->select('ronda.*');
        $builder->where('evento_id', $evento_id);
        $builder->where('cerrada', false);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getProximaRonda($evento_id = null)
    {
        $builder = $this->db->table('ronda');
        $builder->select('MAX(ronda.numero) + 1 AS proxRonda');
        $builder->where('evento_id', $evento_id);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getMesas($evento_id = null)
    {
        $builder = $this->db->table('mesa');
        $builder->select('mesa.*');
        $builder->where('evento_id', $evento_id);
        $query = $builder->get();
        return $query->getResult ();
    }

}