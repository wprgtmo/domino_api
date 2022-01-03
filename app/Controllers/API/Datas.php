<?php

namespace App\Controllers\API;

use App\Models\DataModel;
use App\Models\BoletaParejaModel;
use CodeIgniter\CLI\Console;
use CodeIgniter\Debug\Toolbar\Collectors\Logs;
use CodeIgniter\RESTful\ResourceController;

class Datas extends ResourceController
{
    private $nombreObjeto='data';
    public function __construct() {
        $this->model = $this->setModel(new DataModel());
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
            // $objeto = $this->request->getJSON();
            $data = [
                'numero'        => $this->request->getVar('numero'),
                'boleta_id'    => $this->request->getVar('boleta_id'),
                'pareja_ganadora'  => $this->request->getVar('pareja_ganadora'),
                'puntos'  => $this->request->getVar('puntos'),
                'duracion'  => $this->request->getVar('duracion'),
            ];  
            if ($this->model->insert($data)) {
                $data['id'] = $this->model->insertID;
                //Verificar si con esos tantos gana el juego
                
                $totalTantos = $this->model->getTotalTantos($data['boleta_id'], $data['pareja_ganadora']);
                if ($totalTantos>199){ //Cerrar la boleta y poner esa pareja como ganadora
                    
                    $boletaParejaModel= new BoletaParejaModel();
                    $dataActualizar = [
                        'tantos'     => $totalTantos,
                        'ganador'    => '1',
                    ];  
                    $boletaParejaModel->update($data['pareja_ganadora'], $dataActualizar);

                }

                




                return $this->respondCreated(array('Data' => $data));
            } else{
                return $this->failValidationErrors($this->model->validation->listErrors());
            };
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

}
