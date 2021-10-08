<?php namespace App\Models;

use CodeIgniter\Model;

class EventoModel extends Model{
    protected $table            = 'evento';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre', 'comentario', 'ciudad_id', 'fecha_inicio', 'fecha_cierre'];

    protected $useTimestamps    = true;
    protected $createdField     = 'creado';
    protected $updatedField     = 'actualizado';

    protected $validationRules  = [
        'nombre'        => 'required|is_unique[evento.nombre]|min_length[3]|max_length[60]',
        'comentario'    => 'permit_empty|max_length[255]'
    ];

    protected $skipValidation   = false;

    /*
        Metodos  relativos a las rondas
    */

    public function getRondas($evento_id = null)
    {
        $builder = $this->db->table('ronda');
        $builder->select('ronda.*');
        $builder->where('evento_id', $evento_id);
        $query = $builder->get();
        return $query->getResult ();
    }

    public function getCantRondas($evento_id = null)
    {
        $builder = $this->db->table('ronda');
        $builder->where('evento_id', $evento_id);
        return $builder->countAllResults();
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
        if ($this->getCantRondas($evento_id)==0)
            return 1;
        else {
            $builder = $this->db->table('ronda');
            $builder->select('MAX(ronda.numero) + 1 AS proxRonda');
            $builder->where('evento_id', $evento_id);
            $query = $builder->get();
            $num = $query->getResult();
            return $num[0]->proxRonda;
        }
    }

    /*
        Metodos  relativos a las rondas
    */

    public function getMesas($evento_id = null)
    {
        $builder = $this->db->table('mesa');
        $builder->select('mesa.*');
        $builder->where('evento_id', $evento_id);
        $query = $builder->get();
        return $query->getResult ();
    }

    public function getCantMesas($evento_id = null)
    {
        $builder = $this->db->table('mesa');
        $builder->where('evento_id', $evento_id);
        return $builder->countAllResults();
    }

    public function getParejas($evento_id = null)
    {
        $builder = $this->db->table('pareja');
        $builder->select('pareja.*');
        $builder->where('evento_id', $evento_id);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getCantParejas($evento_id = null)
    {
        $builder = $this->db->table('pareja');
        $builder->where('evento_id', $evento_id);
        return $builder->countAllResults();
    }

    public function getParejasMesa($evento_id, $mesa_id, $ronda_id = null)
    {
        $builder = $this->db->table('pareja');
        $builder->select('pareja.*');
        $builder->where('evento_id', $evento_id);
        $query = $builder->get();
        return $query->getResult ();
    }

    public function getBoletas($evento_id = null, $ronda_id = null)
    {
        $builder = $this->db->table('boleta');
        $builder->select('boleta.*');
        $builder->where('evento_id', $evento_id);
        $builder->where('ronda_id', $ronda_id);
        $query = $builder->get();
        return $query->getResult ();
    }
}