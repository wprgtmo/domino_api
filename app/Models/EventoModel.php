<?php namespace App\Models;

use CodeIgniter\Model;

class EventoModel extends Model{
    protected $table            = 'evento';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre', 'comentario', 'imagen', 'estado', 'ciudad_id', 'fecha_inicio', 'fecha_cierre'];

    protected $useTimestamps    = true;
    protected $createdField     = 'creado';
    protected $updatedField     = 'actualizado';

    protected $validationRules  = [
        'nombre'        => 'required|min_length[3]|max_length[60]', //is_unique[evento.nombre]|
        'comentario'    => 'permit_empty|max_length[255]',
        // 'imagen'        => 'uploaded[imagen]|max_size[imagen, 1024]|is_image[imagen]'
    ];

    protected $skipValidation   = true;

    /*
        Metodos  relativos a las rondas
    */

    public function getRondas($evento_id = null)
    {
        $builder = $this->db->table('ronda');
        $builder->select('ronda.*');
        $builder->where('evento_id', $evento_id);
        $builder->orderBy('numero', 'ASC');
        $query = $builder->get();
        return $query->getResult ();
    }

    
    public function getRonda($evento_id, $ronda_id)
    {
        $builder = $this->db->table('ronda');
        $builder->select('ronda.*');
        $builder->where('evento_id', $evento_id);
        $builder->where('id', $ronda_id);
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

    public function getMesas($evento_id)
    {
        $builder = $this->db->table('mesa');
        $builder->select('mesa.*');
        $builder->where('evento_id', $evento_id); 
        $builder->orderBy('numero', 'ASC');
        $query = $builder->get();
        return $query->getResult ();
    }

    public function getMesa($evento_id, $mesa_id)
    {
        $builder = $this->db->table('mesa');
        $builder->select('mesa.*');
        $builder->where('evento_id', $evento_id);
        $builder->where('id', $mesa_id);
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
        $builder->orderBy('id', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }

    
    public function getPareja($pareja_id = null)
    {
        $builder = $this->db->table('pareja');
        $builder->select('pareja.*');
        $builder->where('id', $pareja_id);        
        $builder->orderBy('id', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getCantParejas($evento_id = null)
    {
        $builder = $this->db->table('pareja');
        $builder->where('evento_id', $evento_id);
        return $builder->countAllResults();
    }

    public function getParejasMesa($evento_id, $mesa_id, $ronda_id)
    {
        $builder = $this->db->table('boleta');
        $builder->select('boleta_pareja.*');
        $builder->join('boleta_pareja', 'boleta_pareja.boleta_id = boleta.id');
        $builder->where('evento_id', $evento_id);
        $builder->where('ronda_id', $ronda_id);
        $builder->where('mesa_id', $mesa_id);
        $query = $builder->get();
        return $query->getResult();
    }
    

    public function getBoletas($evento_id = null, $ronda_id = null)
    {
        $builder = $this->db->table('boleta');
        $builder->select('boleta.*');
        $builder->where('evento_id', $evento_id);
        $builder->where('ronda_id', $ronda_id);        
        $builder->orderBy('mesa_id', 'ASC');
        $query = $builder->get();
        return $query->getResult ();
    }

    public function getBoleta($evento_id = null, $ronda_id = null, $mesa_id = null)
    {
        $builder = $this->db->table('boleta');
        $builder->select('boleta.*');
        $builder->where('evento_id', $evento_id);
        $builder->where('ronda_id', $ronda_id);        
        $builder->where('mesa_id', $mesa_id);   
        $query = $builder->get();
        return $query->getResult ();
    }



    public function getBoletasPareja($boleta_id = null)
    {
        $builder = $this->db->table('boleta_pareja');
        $builder->select('boleta_pareja.*');
        $builder->where('boleta_id', $boleta_id);  
        $builder->orderBy('pareja_id', 'ASC');
        $query = $builder->get();
        return $query->getResult ();
    }
}