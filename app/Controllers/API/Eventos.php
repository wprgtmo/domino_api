<?php

namespace App\Controllers\API;

use App\Models\EventoModel;
use App\Models\MesaModel;
use App\Models\RondaModel;
use App\Models\BoletaModel;
use App\Models\BoletaParejaModel;
use CodeIgniter\CLI\Console;
use CodeIgniter\RESTful\ResourceController;
use App\Controllers\API\Rondas;

class Eventos extends ResourceController
{
    private $objeto='evento';
    
    public function __construct()
    {
        $this->model = $this->setModel(new EventoModel());
    }

    public function index($estado = null)
    {
        try {
            if ($estado == null) { // Devulve todos los eventos
                $eventos = $this->model->findAll();
            } else { // Devulve los eventos según el estado especificado
                $eventos = $this->model->where('estado', $estado)->findAll();
            }
            return $this->respond(array("eventos" => $eventos));
        } catch (\Exception $err) {
            return $this->failServerError('Exception ha ocurrido un error en el servidor:'.$err->getMessage());
        }
    }

    public function create()
    {
        try {
            $evento = $this->request->getJSON();
            $evento->estado= 'C'; // Estado: CREADO
            if ($this->model->insert($evento)):
                $evento->id = $this->model->insertID;
            return $this->respondCreated($evento); else:
                return $this->failValidationErrors($this->model->validation->listErrors());
            endif;
        } catch (\Exception $err) {
            return $this->failServerError('Exception ha ocurrido un error en el servidor:'.$err->getMessage());
        }
    }

    public function edit($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationErrors('No se ha pasado un id de '. $this->objeto .' válido');
            }

            $evento = $this->model->find($id);
            if ($evento == null) {
                return $this->failNotFound('No se ha encontrado un '. $this->objeto .' con el id: '. $id);
            }

            return $this->respond($evento);
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el iguiente error en el servidor: '.$err->getMessage());
        }
    }

    public function update($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationErrors('No se ha pasado un id de '. $this->objeto .' válido');
            }

            $eventoVerificado = $this->model->find($id);
            if ($eventoVerificado == null) {
                return $this->failNotFound('No se ha encontrado un '. $this->objeto .' con el id: '. $id);
            }

            $evento = $this->request->getJSON();
            if ($this->model->update($id, $evento)):
                $evento->id = $id;
            return $this->respondUpdated($evento); else:
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
            if ($id == null) {
                return $this->failValidationErrors('No se ha pasado un id de '. $this->objeto .' válido');
            }

            $eventoVerificado = $this->model->find($id);
            if ($eventoVerificado == null) {
                return $this->failNotFound('No se ha encontrado un '. $this->objeto .' con el id: '. $id);
            }

            if ($this->model->delete($id)):
                return $this->respondDeleted($eventoVerificado); else:
                return $this->failServerError('No se ha podido eliminar el '. $this->objeto . ' con el id: '. $id);
            endif;

            // return $this->respond($evento);
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el iguiente error en el servidor: '.$err->getMessage());
        }
    }

    public function iniciar($evento_id = null)
    {
        try {
            $evento = $this->request->getJSON();
                        
            if ($evento == null) {
                return $this->failValidationErrors('No se ha pasado un id de evento válido');
            }
            $evento_id = $evento->evento_id;
            $eventoIniciar = $this->model->find($evento_id);
            if ($eventoIniciar == null) {
                return $this->failNotFound('No se ha encontrado un '. $this->objeto .' con el id: '. $evento_id);
            }
            // Se toma el evento y se cambia el estado de CREADO a INICIADO

            if ($eventoIniciar["estado"]=='C'): // Estado: C (CREADO)
                $eventoIniciar["estado"]='I'; // Estado: I (INICIADO)
                
            // Se toma la cantidad de parejas y se divide por 2 para determinar la cantidad de mesas
            $cant_parejas= $this->model->getCantParejas($evento_id);
            $cant_mesas= intdiv($cant_parejas, 2);
            $mesa_modelo= new MesaModel();
            // Se agrega una mesa por cada par de parejas definidas en el evento
            for ($i=1; $i < $cant_mesas + 1; $i++) {
                $mesaAdd=['id'=>0, 'numero' => $i, 'evento_id' => $evento_id, 'bonificacion'=>0];
                $mesa_modelo->insert($mesaAdd);
            }
            return $this->respond(array("iniciar" => 'ok')); else:
                return $this->failServerError('El evento no se encuentra en el estado Creado y no se puede Iniciar');
            endif;

            // return $this->respond($evento);
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el iguiente error en el servidor: '.$err->getMessage());
        }
    }

    public function rondaNueva()
    {
        try {
            $evento = $this->request->getJSON();
                        
            if ($evento == null) {
                return $this->failValidationErrors('No se ha pasado un id de evento válido');
            }
            $evento_id = $evento->evento_id;
            $evento_buscado = $this->model->find($evento_id);
            if ($evento_buscado == null) {
                return $this->failNotFound('No se ha encontrado un evento con el id: ' . $evento_id);
            }


            $rondaMoldelo= new RondaModel();
            $nro_ronda= $this->model->getProximaRonda($evento_id);
            $rondaAdd=['id'=>0, 'numero' => $nro_ronda, 'evento_id' => $evento_id, 'dia'=>1, 'cerrada'=>false, 'comentario'=>'Ronda'.$nro_ronda];
            if ($rondaMoldelo->insert($rondaAdd)) {
                $rondaAdd['id'] = $rondaMoldelo->insertID;
                $this->AddBoletas($evento_id, $rondaAdd['id']);

                return $this->respond(array('nuevaRonda' => $rondaAdd, 'boletas'=> $this->model->getBoletas($evento_id, $rondaAdd['id'])));
            }
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: ' . $err->getMessage());
        }
    }

    private function AddBoletas($evento_id, $ronda_id)
    {
        $boletaModelo= new BoletaModel();
        $mesas_evento= $this->model->getMesas($evento_id);
        $parejas= $this->model->getParejas($evento_id);

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
                $this->AddBoletaParejas($boletaAdd['id'], $parejas[$i]->id);
                $this->AddBoletaParejas($boletaAdd['id'], $parejas[$i + 1]->id);
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

    public function rondas()
    {
        try {
            $evento = $this->request->getJSON();
                        
            if ($evento == null) {
                return $this->failValidationErrors('No se ha pasado un id de evento válido');
            }
            $evento_id = $evento->evento_id;
            $evento_buscado = $this->model->find($evento_id);
            if ($evento_buscado == null) {
                return $this->failNotFound('No se ha encontrado un evento con el id: '. $evento_id);
            }

            $listaRondas = $this->model->getRondas($evento_id);
            return $this->respond(array("rondas" => $listaRondas));
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: ' . $err->getMessage());
        }
    }
    
    
    public function rondaActiva($evento_id = null)
    {
        try {
            if ($evento_id == null) {
                return $this->failValidationErrors('No se ha pasado un id de evento válido');
            }

            $evento_buscado = $this->model->find($evento_id);
            if ($evento_buscado == null) {
                return $this->failNotFound('No se ha encontrado un evento con el id: ' . $evento_id);
            }

            $rondaAct = $this->model->getRondaActiva($evento_id);
            return $this->respond(array("rondaActiva" => $rondaAct));
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: ' . $err->getMessage());
        }
    }

    public function proximaRonda($evento_id = null)
    {
        return $this->respond($this->model->getProximaRonda($evento_id)) ;
    }
    
    public function cantRondas($evento_id = null)
    {
        return $this->respond($this->model->getCantRondas($evento_id)) ;
    }
    

    // public function mesas($evento_id = null)
    // {
    //     try {
    //         if ($evento_id == null) {
    //             return $this->failValidationErrors('No se ha pasado un id de evento válido');
    //         }

    //         $evento = new EventoModel();
    //         $evento_buscado = $evento->find($evento_id);
    //         if ($evento_buscado == null) {
    //             return $this->failNotFound('No se ha encontrado un evento con el id: ' . $evento_id);
    //         }

    //         $listaMesas = $this->model->getMesas($evento_id);
    //         return $this->respond(array("mesas" => $listaMesas));
    //     } catch (\Exception $err) {
    //         return $this->failServerError('Ha ocurrido el siguiente error en el servidor: ' . $err->getMessage());
    //     }
    // }

    public function mesas()
    {
        try {
            $evento = $this->request->getJSON();
                        
            if ($evento == null) {
                return $this->failValidationErrors('No se ha pasado un id de evento válido');
            }
            $evento_id = $evento->evento_id;
            $evento_buscado = $this->model->find($evento_id);
            if ($evento_buscado == null) {
                return $this->failNotFound('No se ha encontrado un evento con el id: '. $evento_id);
            }

            $listaMesas = $this->model->getMesas($evento_id);
            return $this->respond(array("mesas" => $listaMesas));
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: ' . $err->getMessage());
        }
    }
    
    
    public function boletas()
    {
        try {
            $request = $this->request->getJSON();
                        
            if ($request == null) {
                return $this->failValidationErrors('No se ha pasado un id de evento válido');
            }
            $evento_id = $request->evento_id;
            $evento_buscado = $this->model->find($evento_id);
            if ($evento_buscado == null) {
                return $this->failNotFound('No se ha encontrado un evento con el id: '. $evento_id);
            }

            // Verifico que la ronda solicitada de ese evento exista y sea válida
            // De no pasar un numero de ronda se toma la ronda activa
            $ronda_id = $request->ronda_id;
            if ($ronda_id == null) {
                $rondaAct= $this->model->getRondaActiva($evento_id);
                if (count($rondaAct) == 0) {
                    return $this->failNotFound('El evento aún no posee ninguna ronda.');
                } else {
                    $ronda_id= $rondaAct[0]->id;
                }
            } else {
                $ronda_buscada = $this->model->getRonda($evento_id, $ronda_id);
                if ($ronda_buscada == null) {
                    return $this->failNotFound('No se ha encontrado la ronda '. $ronda_id . ' en el evento con el id: ' . $evento_id);
                }
            }

            $listaBoletas = $this->model->getBoletas($evento_id, $ronda_id);
            return $this->respond(array("boletas" => $listaBoletas));
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: ' . $err->getMessage());
        }
    }

    public function parejas()
    {
        try {
            $request = $this->request->getJSON();
                        
            if ($request == null) {
                return $this->failValidationErrors('No se ha pasado un id de evento válido');
            }
            $evento_id = $request->evento_id;
            $evento_buscado = $this->model->find($evento_id);
            if ($evento_buscado == null) {
                return $this->failNotFound('No se ha encontrado un evento con el id: '. $evento_id);
            }

            $evento_buscado = $this->model->find($evento_id);
            if ($evento_buscado == null) {
                return $this->failNotFound('No se ha encontrado un evento con el id: ' . $evento_id);
            }
            $listaParejas = $this->model->getParejas($evento_id);
            for ($i=0; $i < count($listaParejas); $i++) { 
                $jugador1 = $this->model->getJugador($listaParejas[$i]->jugador1_id);
                $listaParejas[$i]->jugador1 = $jugador1;                
                unset($listaParejas[$i]->jugador1_id);
                
                $jugador2 = $this->model->getJugador($listaParejas[$i]->jugador2_id);
                $listaParejas[$i]->jugador2 = $jugador2;
                unset($listaParejas[$i]->jugador2_id);
            }
            // echo var_dump($jugadores);
            return $this->respond(array("parejas" => $listaParejas));
            // return $this->respond(array("parejas" => $listaParejas, "jugadores"=> $jugadores));
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: ' . $err->getMessage());
        }
    }

    public function parejasMesa($evento_id = null, $mesa_id = null, $ronda_id = null)
    {
        try {
            $evento = new EventoModel();
            // Verifico que el evento solicitado exista y sea válido
            if ($evento_id == null) {
                return $this->failValidationErrors('No se ha pasado un id de evento válido');
            } else {
                $evento_buscado = $evento->find($evento_id);
                if ($evento_buscado == null) {
                    return $this->failNotFound('No se ha encontrado un evento con el id: ' . $evento_id);
                }
            }

            // Verifico que la mesa solicitada de ese evento exista y sea válida
            if ($mesa_id == null) {
                return $this->failValidationErrors('No se ha pasado un id de mesa válido');
            } else {
                $mesa_buscada = $evento->getMesa($evento_id, $mesa_id);
                if ($mesa_buscada == null) {
                    return $this->failNotFound('No se ha encontrado la mesa '. $mesa_id . ' en el evento con el id: ' . $evento_id);
                }
            }

            // Verifico que la ronda solicitada de ese evento exista y sea válida
            // De no pasar un numero de ronda se toma la ronda activa
            if ($ronda_id == null) {
                $rondaAct= $this->model->getRondaActiva($evento_id);
                if (count($rondaAct) == 0) {
                    return $this->failNotFound('El evento aún no posee ninguna ronda.');
                } else {
                    $ronda_id= $rondaAct[0]->id;
                }
            } else {
                $ronda_buscada = $evento->getRonda($evento_id, $ronda_id);
                if ($ronda_buscada == null) {
                    return $this->failNotFound('No se ha encontrado la ronda '. $ronda_id . ' en el evento con el id: ' . $evento_id);
                }
            }

            //  Ya tengo validado el evento, la mesa y la ronda

            $parejasMesa=  $evento->getParejasMesa($evento_id, $mesa_id, $ronda_id);
            return $this->respond(array("parejasMesa" => $parejasMesa));
            
            // $listaParejas = $this->model->getParejas($evento_id);
            // return $this->respond( array("parejas" => $listaParejas) );
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: ' . $err->getMessage());
        }
    }
}
