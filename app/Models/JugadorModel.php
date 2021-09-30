<?php namespace App\Models;

use CodeIgniter\Model;

class JugadorModel extends Model{
    protected $table            = 'jugador';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre', 'telefono', 'sexo', 'correo', 'nro_identidad', 'fecha_nacimiento', 'alias', 
                                    'ocupacion', 'comentario', 'nivel', 'elo', 'ranking', 'tipo', 'ciudad_id'];
    protected $validationRules  = [
        'nombre'        => 'required|min_length[3]|max_length[120]',
        'telefono'      => 'permit_empty|min_length[8]|max_length[8]',
        'sexo'          => 'required|min_length[1]|max_length[1]',
        'correo'        => 'required|valid_email',
        'comentario'    => 'permit_empty|max_length[255]'
    ];

    protected $validationMessages  = [
        'nombre'        => [
            'is_unique'        => 'Ya el jugador existe',
            'min_length'    => 'El nombre del jugador debe contener al menos 3 caracteres'
        ]
    ];

    protected $skipValidation   = true;

}