<?php

namespace App\Controllers\API;

use App\Models\EventoModel;
use App\Models\ParejaModel;
use App\Models\JugadorModel;
use CodeIgniter\CLI\Console;
use CodeIgniter\RESTful\ResourceController;

class Parejas extends ResourceController
{
    private $nombreObjeto='pareja';

    public function __construct() {
        $this->model = $this->setModel(new ParejaModel());
    }

	public function index()
	{
        try {
            $objetos = $this->model->findAll();
            return $this->respond($objetos);
        } catch (\Exception $err) {
            return $this->failServerError('Exception ha ocurrido un error en el servidor:'.$err->getMessage());
        }
	}

    public function create(){
        try {
            $pareja = [
                'nombre'        => $this->request->getVar('nombre'),
                'evento_id'     => $this->request->getVar('evento_id'),
                'jugador1_id'   => $this->request->getVar('jugador1_id'),
                'jugador2_id'   => $this->request->getVar('jugador2_id'),
            ];   
            if ($this->model->insert($pareja)):
                $pareja['id'] = $this->model->insertID;
                return $this->respondCreated($pareja);
            else:
                return $this->failValidationErrors($this->model->validation->listErrors());
            endif;
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
   
	public function getPareja($id)
	{
        try {
            if($id == null)
                return $this->failValidationErrors('No se ha pasado un id de '. $this->nombreObjeto .' válido');
            $pareja = $this->model->find($id);
            if($pareja == null)
                return $this->failNotFound('No se ha encontrado un '. $this->nombreObjeto .' con el id: '. $id); 
            
            $JugadorModel = new JugadorModel();
            $jugador1 = $JugadorModel->getJugador($pareja["jugador1_id"]);
            $pareja["jugador1"] = $jugador1;                
            unset($pareja->jugador1_id);
            
            $jugador2 = $JugadorModel->getJugador($pareja["jugador2_id"]);
            $pareja["jugador2"] = $jugador2;
            unset($pareja->jugador2_id);

                
            
            return $this->respond(array("pareja" => $pareja));
        } catch (\Exception $err) {
            return $this->failServerError('Exception ha ocurrido un error en el servidor:'.$err->getMessage());
        }
	}


}
