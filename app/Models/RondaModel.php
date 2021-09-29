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

    public function getRondaActivaDelEvento($evento_id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('ronda.numero');
        $builder->join('evento', 'evento.id = ronda.evento_id');
        $builder->where('evento_id', $evento_id);
        $builder->where('cerrada', false);
        $query = $builder->get();
        return $query->getResult ();
    }

}