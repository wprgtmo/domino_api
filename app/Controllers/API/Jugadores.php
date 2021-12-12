<?php

namespace App\Controllers\API;

use App\Models\JugadorModel;
use CodeIgniter\CLI\Console;
use CodeIgniter\Debug\Toolbar\Collectors\Logs;
use CodeIgniter\RESTful\ResourceController;

class Jugadores extends ResourceController
{
    private $nombreObjeto='jugador';
    public function __construct() {
        $this->model = $this->setModel(new JugadorModel());
    }

	public function index()
	{
        try {
            $objetos = $this->model->findAll();
            return $this->respond(array("jugadores" => $objetos) );
        } catch (\Exception $err) {
            return $this->failServerError('Exception ha ocurrido un error en el servidor:'.$err->getMessage());
        }
	}

    // public function create(){
    //     try {
    //         $objeto = $this->request->getJSON();
    //         if ($this->model->insert($objeto)):
    //             $objeto->id = $this->model->insertID;
    //             return $this->respondCreated($objeto);
    //         else:
    //             return $this->failValidationErrors($this->model->validation->listErrors());
    //         endif;
    //     } catch (\Exception $err) {
    //         return $this->failServerError('Exception ha ocurrido un error en el servidor:'.$err->getMessage());
    //     }
    // }

    public function create()
    {
        try {
            $jugador = [
                'nombre'            => $this->request->getVar('nombre',         FILTER_SANITIZE_STRING),
                'telefono'          => $this->request->getVar('telefono',       FILTER_SANITIZE_STRING),
                'sexo'              => $this->request->getVar('sexo',           FILTER_SANITIZE_STRING),
                'correo'            => $this->request->getVar('correo',         FILTER_SANITIZE_STRING),
                'nro_identidad'     => $this->request->getVar('nro_identidad',  FILTER_SANITIZE_STRING),
                'alias'             => $this->request->getVar('alias',          FILTER_SANITIZE_STRING),
                'fecha_nacimiento'  => $this->request->getVar('fecha_nacimiento'),
                'ocupacion'         => $this->request->getVar('ocupacion',      FILTER_SANITIZE_STRING),
                'comentario'        => $this->request->getVar('comentario',     FILTER_SANITIZE_STRING),
                'nivel'             => $this->request->getVar('nivel',          FILTER_SANITIZE_STRING),
                'elo'               => $this->request->getVar('elo',            FILTER_SANITIZE_STRING),
                'ranking'           => $this->request->getVar('ranking',        FILTER_SANITIZE_STRING),
                'tipo'              => $this->request->getVar('tipo',           FILTER_SANITIZE_STRING),
                // 'ciudad_id'         => $this->request->getVar('ciudad_id',      FILTER_SANITIZE_STRING),
            ];   
            
            
            
            // Si subió una imagen
            $file = $this->request->getFile('foto');
            if ($file) {
                $file->move('./public/assets/img/jugadores');
                $jugador["foto"]= '/public/assets/img/jugadores/'. $file->getName();
                // echo var_dump($evento);
            }
            // $evento = $this->request->getJSON();
            $jugador["ciudad_id"]= 1; // Estado: Gtmo

            if ($this->model->insert($jugador)) {
                $jugador["id"] = $this->model->insertID;
                return $this->respondCreated($jugador);
            } else {
                return $this->failValidationErrors($this->model->validation->listErrors());
            }
        } catch (\Exception $err) {
            return $this->failServerError('Exception ha ocurrido un error en el servidor:'.$err->getMessage());
        }
    }

    public function edit($id = null)
    {
        try {
            if($id == null)
                return $this->failValidationErrors('No se ha pasado un id de '. $this->nombreObjeto .' válido');

            $objeto = $this->model->find($id);
            if($objeto == null)
                return $this->failNotFound('No se ha encontrado un '. $this->nombreObjeto .' con el id: '. $id); 

            return $this->respond($objeto);

        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: '.$err->getMessage());
        }
    }

    public function update($id = null)
    {
        try {
            if($id == null)
                return $this->failValidationErrors('No se ha pasado un id de '. $this->nombreObjeto .' válido');

            $objetoVerificado = $this->model->find($id);
            if($objetoVerificado == null)
                return $this->failNotFound('No se ha encontrado un '. $this->nombreObjeto .' con el id: '. $id); 

            $objeto = $this->request->getJSON();
            if ($this->model->update($id, $objeto)):
                $objeto->id = $id;
                return $this->respondUpdated($objeto);
            else:
                return $this->failValidationErrors($this->model->validation->listErrors());
            endif;



            // return $this->respond($evento);

        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el iguiente error en el servidor: '.$err->getMessage());
        }
    }

    public function delete($id = null)
    {
        try {
            if($id == null)
                return $this->failValidationErrors('No se ha pasado un id de '. $this->nombreObjeto .' válido');

            $objetoVerificado = $this->model->find($id);
            if($objetoVerificado == null)
                return $this->failNotFound('No se ha encontrado un '. $this->nombreObjeto .' con el id: '. $id); 

            if ($this->model->delete($id)):
                return $this->respondDeleted($objetoVerificado);
            else:
                return $this->failServerError('No se ha podido eliminar el '. $this->nombreObjeto . ' con el id: '. $id);
            endif;



            // return $this->respond($evento);

        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el iguiente error en el servidor: '.$err->getMessage());
        }
    }

    public function Jugador($id = null)
	{
        try {
            if($id == null)
                return $this->failValidationErrors('No se ha pasado un id de '. $this->nombreObjeto .' válido');

            $objeto = $this->model->find($id);
            if($objeto == null)
                return $this->failNotFound('No se ha encontrado un '. $this->nombreObjeto .' con el id: '. $id); 

            return $this->respond($objeto);

        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: '.$err->getMessage());
        }
	}

}
