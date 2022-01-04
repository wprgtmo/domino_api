<?php

namespace App\Controllers\API;

use App\Models\DataModel;
use App\Models\RondaModel;
use App\Models\EventoModel;
use App\Models\BoletaModel;
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
                
                $boletaParejaModel= new BoletaParejaModel();

                $pareja_ganadora= $boletaParejaModel->find($data['pareja_ganadora']);

                $boletaParejaModel->update($data['pareja_ganadora'], ['tantos' => $pareja_ganadora['tantos'] + $data['puntos']]);

                //Verificar si con esos tantos gana el juego para cerrar la boleta y poner esa pareja como ganadora
                //TODO: Cambiar el valor 199 por un valor tomado de los datos del evento
                if (($pareja_ganadora['tantos'] + $data['puntos'])>199){                     
                    $boletaParejaModel->update($data['pareja_ganadora'], ['ganador' => '1', 'tantos' => 200]);
                    
                    $boletaModel= new BoletaModel();              
                    $boletaModel->update($data['boleta_id'], ['estado' => 'F']);
                    
                    $boleta= $boletaModel->find($data['boleta_id']);
                    //Verificar si es la última boleta para cerrar la ronda e iniciar otra.
                    if ($boletaModel->esUltimaBoletaRonda($boleta['ronda_id'])){

                        // Se cierra la ronda actual
                        
                        $rondaModel= new RondaModel();              
                        $rondaModel->update($boleta['ronda_id'], ['estado' => 'F']);

                        
                        // Se agrega la próxima ronda en estado Creada
                        $this->nuevaRonda($boleta['evento_id']);

                    }     
                }
                
                return $this->respondCreated(array('Data' => $data));
            } else{
                return $this->failValidationErrors($this->model->validation->listErrors());
            };
        } catch (\Exception $err) {
            return $this->failServerError('Exception ha ocurrido un error en el servidor:'.$err->getMessage());
        }
    }

    private function nuevaRonda($evento_id)
    {
        $rondaModelo= new RondaModel();
        $eventoMoldelo= new EventoModel();
        $nro_ronda= $eventoMoldelo->getProximaRonda($evento_id);
        $rondaAdd=['id'=>0, 'numero' => $nro_ronda, 'evento_id' => $evento_id, 'dia'=>1, 'cerrada'=>false, 'comentario'=>'Ronda_'.$nro_ronda];
        if ($rondaModelo->insert($rondaAdd)) {
            $rondaAdd['id'] = $rondaModelo->insertID;
            $this->AddBoletas($evento_id, $rondaAdd['id']);
            // return $this->respond(array('nuevaRonda' => $rondaAdd, 'boletas'=> $this->model->getBoletas($evento_id, $rondaAdd['id'])));
        }
    }

    private function AddBoletas($evento_id, $ronda_id)
    {
        $boletaModelo= new BoletaModel();
        $eventoMoldelo= new EventoModel();
        $mesas_evento= $eventoMoldelo->getMesas($evento_id);
        $parejas= $eventoMoldelo->getParejas($evento_id);

        for ($i=0; $i < count($mesas_evento)  ; $i++) {
            $boletaAdd=[
                'id'=>0,
                'evento_id' => $evento_id,
                'mesa_id' => $mesas_evento[$i]->id,
                'ronda_id' => $ronda_id,
                'es_valida'=> true
            ];
            if ($boletaModelo->insert($boletaAdd)) {
                $boletaAdd['id'] = $boletaModelo->insertID;
                $this->AddBoletaParejas($boletaAdd['id'], $parejas[2*$i]->id);
                $this->AddBoletaParejas($boletaAdd['id'], $parejas[2*$i + 1]->id);
            }
        }
    }

    private function AddBoletaParejas($boleta_id, $pareja_id)
    {
        $boletaParejaModelo= new BoletaParejaModel();
        $boletaParejasAdd=[
            'id'=>0,
            'boleta_id' => $boleta_id,
            'pareja_id' => $pareja_id,
            'salidor' => false,
            'tantos' => 0,
            'resultado' => 0,
            'ganador' => false
        ];
        $boletaParejaModelo->insert($boletaParejasAdd);
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
