<?php

namespace App\Controllers\API;

use App\Models\EventoModel;
use App\Models\RondaModel;
use CodeIgniter\CLI\Console;
use CodeIgniter\RESTful\ResourceController;

class Rondas extends ResourceController
{
    private $nombreObjeto = 'ronda';
    public function __construct()
    {
        $this->model = $this->setModel(new RondaModel());
    }

    public function index()
    {
        try {
            $objetos = $this->model->findAll();
            return $this->respond($objetos);
        } catch (\Exception $err) {
            return $this->failServerError('Exception ha ocurrido un error en el servidor:' . $err->getMessage());
        }
    }

    public function create()
    {
        try {
            $objeto = $this->request->getJSON();
            if ($this->model->insert($objeto)) :
                $objeto->id = $this->model->insertID;
            return $this->respondCreated($objeto); else :
                return $this->failValidationErrors($this->model->validation->listErrors());
            endif;
        } catch (\Exception $err) {
            return $this->failServerError('Exception ha ocurrido un error en el servidor:' . $err->getMessage());
        }
    }

    public function edit($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationErrors('No se ha pasado un id de ' . $this->nombreObjeto . ' válido');
            }

            $objeto = $this->model->find($id);
            if ($objeto == null) {
                return $this->failNotFound('No se ha encontrado un ' . $this->nombreObjeto . ' con el id: ' . $id);
            }

            return $this->respond($objeto);
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: ' . $err->getMessage());
        }
    }

    public function update($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationErrors('No se ha pasado un id de ' . $this->nombreObjeto . ' válido');
            }

            $objetoVerificado = $this->model->find($id);
            if ($objetoVerificado == null) {
                return $this->failNotFound('No se ha encontrado un ' . $this->nombreObjeto . ' con el id: ' . $id);
            }

            $objeto = $this->request->getJSON();
            if ($this->model->update($id, $objeto)) :
                $objeto->id = $id;
            return $this->respondUpdated($objeto); else :
                return $this->failValidationErrors($this->model->validation->listErrors());
            endif;



            // return $this->respond($evento);
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el iguiente error en el servidor: ' . $err->getMessage());
        }
    }

    public function delete($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationErrors('No se ha pasado un id de ' . $this->nombreObjeto . ' válido');
            }

            $objetoVerificado = $this->model->find($id);
            if ($objetoVerificado == null) {
                return $this->failNotFound('No se ha encontrado un ' . $this->nombreObjeto . ' con el id: ' . $id);
            }

            if ($this->model->delete($id)) :
                return $this->respondDeleted($objetoVerificado); else :
                return $this->failServerError('No se ha podido eliminar el ' . $this->nombreObjeto . ' con el id: ' . $id);
            endif;



            // return $this->respond($evento);
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el iguiente error en el servidor: ' . $err->getMessage());
        }
    }

    public function rondaActivaEvento($evento_id = null)
    {
        try {
            if ($evento_id == null) {
                return $this->failValidationErrors('No se ha pasado un id de evento válido');
            }

            $evento = new EventoModel();
            $evento_buscado = $evento->find($evento_id);
            if ($evento_buscado == null) {
                return $this->failNotFound('No se ha encontrado un evento con el id: ' . $evento_id);
            }

            $ronda_activa = $this->model->getRondaActivaDelEvento($evento_id);
            return $this->respond($ronda_activa);
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: ' . $err->getMessage());
        }
    }

    
}
