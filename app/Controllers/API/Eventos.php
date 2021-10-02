<?php

namespace App\Controllers\API;

use App\Models\EventoModel;
use CodeIgniter\CLI\Console;
use CodeIgniter\RESTful\ResourceController;
use App\Controllers\API\Rondas;

class Eventos extends ResourceController
{
    private $objeto='evento';
    
    public function __construct() {
        $this->model = $this->setModel(new EventoModel());
    }

	public function index()	{
        try {
            $eventos = $this->model->findAll();
            return $this->respond( array("eventos" => $eventos) );
        } catch (\Exception $err) {
            return $this->failServerError('Exception ha ocurrido un error en el servidor:'.$err->getMessage());
        }
	}

    public function create(){
        try {
            $evento = $this->request->getJSON();
            if ($this->model->insert($evento)):
                $evento->id = $this->model->insertID;
                return $this->respondCreated($evento);
            else:
                return $this->failValidationErrors($this->model->validation->listErrors());
            endif;
        } catch (\Exception $err) {
            return $this->failServerError('Exception ha ocurrido un error en el servidor:'.$err->getMessage());
        }
    }

    public function edit($id = null){
        try {
            if($id == null)
                return $this->failValidationErrors('No se ha pasado un id de '. $this->objeto .' válido');

            $evento = $this->model->find($id);
            if($evento == null)
                return $this->failNotFound('No se ha encontrado un '. $this->objeto .' con el id: '. $id); 

            return $this->respond($evento);

        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el iguiente error en el servidor: '.$err->getMessage());
        }
    }

    public function update($id = null){
        try {
            if($id == null)
                return $this->failValidationErrors('No se ha pasado un id de '. $this->objeto .' válido');

            $eventoVerificado = $this->model->find($id);
            if($eventoVerificado == null)
                return $this->failNotFound('No se ha encontrado un '. $this->objeto .' con el id: '. $id); 

            $evento = $this->request->getJSON();
            if ($this->model->update($id, $evento)):
                $evento->id = $id;
                return $this->respondUpdated($evento);
            else:
                return $this->failValidationErrors($this->model->validation->listErrors());
            endif;



            // return $this->respond($evento);

        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el iguiente error en el servidor: '.$err->getMessage());
        }
    }

    public function delete($id = null){
        try {
            if($id == null)
                return $this->failValidationErrors('No se ha pasado un id de '. $this->objeto .' válido');

            $eventoVerificado = $this->model->find($id);
            if($eventoVerificado == null)
                return $this->failNotFound('No se ha encontrado un '. $this->objeto .' con el id: '. $id); 

            if ($this->model->delete($id)):
                return $this->respondDeleted($eventoVerificado);
            else:
                return $this->failServerError('No se ha podido eliminar el '. $this->objeto . ' con el id: '. $id);
            endif;

            // return $this->respond($evento);

        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el iguiente error en el servidor: '.$err->getMessage());
        }
    }

    public function rondas($evento_id = null){
        try {
            if ($evento_id == null) {
                return $this->failValidationErrors('No se ha pasado un id de evento válido');
            }

            $evento_buscado = $this->model->find($evento_id);
            if ($evento_buscado == null) {
                return $this->failNotFound('No se ha encontrado un evento con el id: ' . $evento_id);
            }

            $listaRondas = $this->model->getRondas($evento_id);
            return $this->respond( array("rondas" => $listaRondas) );
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: ' . $err->getMessage());
        }
    }

    public function rondaActiva($evento_id = null){
        try {
            if ($evento_id == null) {
                return $this->failValidationErrors('No se ha pasado un id de evento válido');
            }

            $evento_buscado = $this->model->find($evento_id);
            if ($evento_buscado == null) {
                return $this->failNotFound('No se ha encontrado un evento con el id: ' . $evento_id);
            }

            $rondaAct = $this->model->getRondaActiva($evento_id);
            return $this->respond( array("rondaActiva" => $rondaAct) );
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: ' . $err->getMessage());
        }
    }

    public function nuevaRonda($evento_id = null){
        try {
            if ($evento_id == null) {
                return $this->failValidationErrors('No se ha pasado un id de evento válido');
            }

            $evento_buscado = $this->model->find($evento_id);
            if ($evento_buscado == null) {
                return $this->failNotFound('No se ha encontrado un evento con el id: ' . $evento_id);
            }

            $rondaAct = $this->model->getRondaActiva($evento_id);
            return $this->respond( array("rondaActiva" => $rondaAct) );
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: ' . $err->getMessage());
        }
    }

    public function proximaRonda($evento_id = null){
        $proxRonda = $this->model->getProximaRonda($evento_id);
        return $this->respond( array("proximaRonda" => $proxRonda) );
    }

    public function mesas($evento_id = null){
        try {
            if ($evento_id == null) {
                return $this->failValidationErrors('No se ha pasado un id de evento válido');
            }

            $evento = new EventoModel();
            $evento_buscado = $evento->find($evento_id);
            if ($evento_buscado == null) {
                return $this->failNotFound('No se ha encontrado un evento con el id: ' . $evento_id);
            }

            $listaMesas = $this->model->getMesas($evento_id);
            return $this->respond( array("mesas" => $listaMesas) );
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: ' . $err->getMessage());
        }
    }
    
    public function parejas($evento_id = null){
        try {
            if ($evento_id == null) {
                return $this->failValidationErrors('No se ha pasado un id de evento válido');
            }

            $evento = new EventoModel();
            $evento_buscado = $evento->find($evento_id);
            if ($evento_buscado == null) {
                return $this->failNotFound('No se ha encontrado un evento con el id: ' . $evento_id);
            }

            $listaParejas = $this->model->getParejas($evento_id);
            return $this->respond( array("parejas" => $listaParejas) );
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: ' . $err->getMessage());
        }
    }

    public function parejasMesa($evento_id = null, $mesa_id = null, $ronda_id = null){
        try {
            if ($evento_id == null) {
                return $this->failValidationErrors('No se ha pasado un id de evento válido');
            }

            if ($mesa_id == null) {
                return $this->failValidationErrors('No se ha pasado un id de mesa válido');
            }

            if ($ronda_id == null) {
                $rondaAct= $this->model->getRondaActiva($evento_id);
                $ronda_id= $rondaAct->get(0).id;
                return $this->respond( array("rondaActiva" => $ronda_id) );
            }


            // $evento = new EventoModel();
            // $evento_buscado = $evento->find($evento_id);
            // if ($evento_buscado == null) {
            //     return $this->failNotFound('No se ha encontrado un evento con el id: ' . $evento_id);
            // }

            // $listaParejas = $this->model->getParejas($evento_id);
            // return $this->respond( array("parejas" => $listaParejas) );
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: ' . $err->getMessage());
        }
    }

}

