<?php

namespace App\Controllers\API;

use App\Models\EventoModel;
use App\Models\MesaModel;
use App\Models\RondaModel;
use App\Models\JugadorModel;
use App\Models\BoletaModel;
use App\Models\BoletaParejaModel;
use CodeIgniter\CLI\Console;
use CodeIgniter\RESTful\ResourceController;

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

    public function crear()
    {
        try {
            $evento = [
                'nombre'        => $this->request->getVar('nombre', FILTER_SANITIZE_STRING),
                'comentario'    => $this->request->getVar('comentario', FILTER_SANITIZE_STRING),
                'fecha_inicio'  => $this->request->getVar('fecha_inicio'),
                'fecha_cierre'  => $this->request->getVar('fecha_cierre'),
            ];   
            
            
            
            // Si subió una imagen
            $file = $this->request->getFile('imagen');
            if ($file) {
                $file->move('./public/assets/img/eventos');
                $evento["imagen"]= $file->getName();
                // echo var_dump($evento);
            }
            // $evento = $this->request->getJSON();
            $evento["estado"]= 'C'; // Estado: CREADO
            $evento["ciudad_id"]= 1; // Estado: Gtmo

            if ($this->model->insert($evento)) {
                $evento["id"] = $this->model->insertID;
                return $this->respondCreated($evento);
            } else {
                return $this->failValidationErrors($this->model->validation->listErrors());
            }
        } catch (\Exception $err) {
            return $this->failServerError('Exception ha ocurrido un error en el servidor:'.$err->getMessage());
        }
    }

    public function editar($id = null)
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

    public function actualizar($id = null)
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

    public function eliminar($id = null)
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
            $eventoFinalizar = $this->model->find($evento_id);
            if ($eventoFinalizar == null) {
                return $this->failNotFound('No se ha encontrado un '. $this->objeto .' con el id: '. $evento_id);
            }

            // Se toma el evento y se valida que el estado sea CREADO 
            if ($eventoFinalizar["estado"]!='C'){ // Estado: C (CREADO)
                return $this->failServerError('El evento no se encuentra en el estado Creado y no se puede Iniciar');
            }           
            $cant_parejas= $this->model->getCantParejas($evento_id);
            // Se toma la cant. de parejas y se verifica que existan al menos 2
            if ($cant_parejas<2){ // Estado: C (CREADO)
                return $this->failServerError('El evento no posee parejas definidas para iniciar');
            } 

            if ($this->model->update($evento_id, ['estado' => 'I'])) {
                
                // Se toma la cantidad de parejas y se divide por 2 para determinar la cantidad de mesas
                
                $cant_mesas= intdiv($cant_parejas, 2);

                // Si la cantidad de parejas es impar se agrega una mesa
                if (fmod($cant_parejas, 2)>0) $cant_mesas++; 

                $mesa_modelo= new MesaModel();
                // Se agrega una mesa por cada par de parejas definidas en el evento
                for ($i=1; $i < $cant_mesas + 1; $i++) {
                    $mesaAdd=['id'=>0, 'numero' => $i, 'evento_id' => $evento_id, 'bonificacion'=>0];
                    $mesa_modelo->insert($mesaAdd);
                }

                // Se agrega la primera ronda en estado Creada

                $rondaMoldelo= new RondaModel();
                $nro_ronda= $this->model->getProximaRonda($evento_id);
                $rondaAdd=['id'=>0, 'numero' => $nro_ronda, 'evento_id' => $evento_id, 'dia'=>1, 'cerrada'=>false, 'comentario'=>'Ronda'.$nro_ronda];
                if ($rondaMoldelo->insert($rondaAdd)) {
                    $rondaAdd['id'] = $rondaMoldelo->insertID;
                    $this->AddBoletas($evento_id, $rondaAdd['id']);

                    return $this->respond(array('nuevaRonda' => $rondaAdd, 'boletas'=> $this->model->getBoletas($evento_id, $rondaAdd['id'])));
                }


                return $this->respondUpdated($eventoFinalizar);
            } else            
                return $this->failValidationErrors($this->model->validation->listErrors());
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: '.$err->getMessage());
        }
    }

    public function finalizar($evento_id = null)
    {
        try {
            $evento = $this->request->getJSON();
                        
            if ($evento == null) {
                return $this->failValidationErrors('No se ha pasado un id de evento válido');
            }
            $evento_id = $evento->evento_id;
            $eventoFinalizar = $this->model->find($evento_id);
            if ($eventoFinalizar == null) {
                return $this->failNotFound('No se ha encontrado un '. $this->objeto .' con el id: '. $evento_id);
            }

            // Se toma el evento y se valida que el estado sea INICIADO 
            if ($eventoFinalizar["estado"]!='I'){ // Estado: I (INICIADO)
                return $this->failServerError('El evento no se encuentra en el estado Iniciado y no se puede Finalizar');
            }           
            if ($this->model->update($evento_id, ['estado' => 'F'])) {
                
                
                return $this->respondUpdated($eventoFinalizar);
            } else            
                return $this->failValidationErrors($this->model->validation->listErrors());
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: '.$err->getMessage());
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
            return $this->respond($rondaAct[0]); //array("rondaActiva" => $rondaAct[0])
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
    
    public function mesas()
    {
        try {
            // $evento = $this->request->getJSON();
            $evento_id = $this->request->getVar('evento_id');
                        
            // if ($evento == null) {
            //     return $this->failValidationErrors('No se ha pasado un id de evento válido');
            // }
            // $evento_id = $evento->evento_id;
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

    public function boleta($evento_id = null, $mesa_id = null, $ronda_id = null)
    {
        try {
            if ($evento_id == null) {
                return $this->failValidationErrors('No se ha pasado un id de evento válido');
            }

            $evento_buscado = $this->model->find($evento_id);
            if ($evento_buscado == null) {
                return $this->failNotFound('No se ha encontrado un evento con el id: ' . $evento_id);
            }

            if ($mesa_id == null) {
                return $this->failValidationErrors('No se ha pasado un id de mesa válido');
            }

            $mesa_buscada = $this->model->getMesa($evento_id, $mesa_id);
            if ($mesa_buscada == null) {
                return $this->failNotFound('No se ha encontrado una mesa con el id: ' . $mesa_id);
            }

            // Verifico que la ronda solicitada de ese evento exista y sea válida
            // De no pasar un numero de ronda se toma la ronda activa
            if ($ronda_id == null) {
                $rondaAct= $this->model->getRondaActiva($evento_id);
                if (count($rondaAct) == 0) {
                    return $this->failNotFound('El evento aún no posee ninguna ronda.');
                } else {
                    $ronda_id= $rondaAct[0]->id;
                    $ronda_buscada= $rondaAct;
                }
            } else {
                $ronda_buscada = $this->model->getRonda($evento_id, $ronda_id);
                if ($ronda_buscada == null) {
                    return $this->failNotFound('No se ha encontrado la ronda '. $ronda_id . ' en el evento con el id: ' . $evento_id);
                }
            }

            $boleta = $this->model->getBoleta($evento_id, $ronda_id, $mesa_id)[0];
            $JugadorModel = new JugadorModel();

            if ($boleta == null) {
                return $this->failNotFound('No se ha encontrado una boleta en el: ' . $evento_id . ' para la mesa: ' .  $mesa_id . ' en la ronda: ' . $ronda_id);
            }

            // De cada Boleta se obtienen las 2 BoletasPareja asociadas
            $boletaPareja = $this->model->getBoletasPareja($boleta->id);

            // echo var_dump($boletaPareja);
            // De la primera BoletaPareja se obtiene la pareja como tal.
            for ($j=0; $j < count($boletaPareja) ; $j++) { 
                
                $mesa = $this->model->getMesa($evento_id, $boleta->{"mesa_id"});
                $boleta->{"mesa"}=$mesa[0];

                $boleta->{"ronda"}=$ronda_buscada[0];

                // unset($boleta->{"mesa_id"});
                    
                $pareja = $this->model->getPareja($boletaPareja[$j]->pareja_id);   

                // De la primera Pareja se obtienen los 2 jugadores
                $jugador1 = $JugadorModel->getJugador($pareja[0]->jugador1_id);
                $jugador2 = $JugadorModel->getJugador($pareja[0]->jugador2_id);

                // Se agregan los 2 jugadores a la pareja
                $pareja[0]->{"jugador1"} = $jugador1; 
                $pareja[0]->{"jugador2"} = $jugador2;     
                
                // Se quitan los 2 id de jugadores a la pareja
                unset($pareja[0]->{"jugador1_id"});
                unset($pareja[0]->{"jugador2_id"});

                $boletaPareja[$j]->{"pareja"} = $pareja[0];
                unset($boletaPareja[$j]->{"pareja_id"});
            }

            $boleta->{"boleta_parejas"} = $boletaPareja;  

            // echo var_dump($jugadores);
            return $this->respond(array("boleta" => $boleta));
        } catch (\Exception $err) {
            return $this->failServerError('Ha ocurrido el siguiente error en el servidor: ' . $err->getMessage());
        }
    }


    public function boletasCompleta()
    {
        try {
            $request = $this->request->getJSON();
            if ($request == null) {
                return $this->failValidationErrors('No se han pasado los parametros requeridos');
            }
            // $evento_id = $request->evento_id;
            // $evento_buscado = $this->model->find($evento_id);
            // if ($evento_buscado == null) {
            //     return $this->failNotFound('No se ha encontrado un evento con el id: '. $evento_id);
            // }

            // Verifico que la ronda solicitada de ese evento exista y sea válida
            // De no pasar un numero de ronda se toma la ronda activa
            $ronda_id = $request->ronda_id;
            // if ($ronda_id == null) {
            //     $rondaAct= $this->model->getRondaActiva($evento_id);
            //     if (count($rondaAct) == 0) {
            //         return $this->failNotFound('El evento aún no posee ninguna ronda.');
            //     } else {
            //         $ronda_id= $rondaAct[0]->id;
            //     }
            // } else {
            //     $ronda_buscada = $this->model->getRonda($evento_id, $ronda_id);
            //     if ($ronda_buscada == null) {
            //         return $this->failNotFound('No se ha encontrado la ronda '. $ronda_id . ' en el evento con el id: ' . $evento_id);
            //     }
            // }

            $ronda_buscada = $this->model->getRondaId($ronda_id);
            if ($ronda_buscada == null) {
                return $this->failNotFound('No se ha encontrado la ronda '. $ronda_id );
            }

            $ronda=$ronda_buscada[0];
            
            $listaBoletas = $this->model->getBoletas($ronda->evento_id, $ronda->id);
            $JugadorModel = new JugadorModel();

            for ($i=0; $i < count($listaBoletas); $i++) { 
                // De cada Boleta se obtienen las 2 BoletasPareja asociadas
                $boletaPareja = $this->model->getBoletasPareja($listaBoletas[$i]->id);

                // echo var_dump($boletaPareja);
                // De la primera BoletaPareja se obtiene la pareja como tal.
                for ($j=0; $j < count($boletaPareja) ; $j++) { 
                    
                    $mesa = $this->model->getMesa($ronda->evento_id, $listaBoletas[$i]->{"mesa_id"});
                    $listaBoletas[$i]->{"mesa"}=$mesa[0];

                    $listaBoletas[$i]->{"ronda"}=$ronda;

                    // unset($boleta->{"mesa_id"});
                        
                    $pareja = $this->model->getPareja($boletaPareja[$j]->pareja_id);   

                    // De la primera Pareja se obtienen los 2 jugadores
                    $jugador1 = $JugadorModel->getJugador($pareja[0]->jugador1_id);
                    $jugador2 = $JugadorModel->getJugador($pareja[0]->jugador2_id);

                    // Se agregan los 2 jugadores a la pareja
                    $pareja[0]->{"jugador1"} = $jugador1; 
                    $pareja[0]->{"jugador2"} = $jugador2;     
                    
                    // Se quitan los 2 id de jugadores a la pareja
                    unset($pareja[0]->{"jugador1_id"});
                    unset($pareja[0]->{"jugador2_id"});

                    $boletaPareja[$j]->{"pareja"} = $pareja[0];
                    unset($boletaPareja[$j]->{"pareja_id"});
                }

                $listaBoletas[$i]->{"boleta_parejas"} = $boletaPareja;  
            
            }
            // echo var_dump($jugadores);
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
            $listaParejas = $this->model->getParejas($evento_id);
            $JugadorModel = new JugadorModel();
            for ($i=0; $i < count($listaParejas); $i++) { 
                $jugador1 = $JugadorModel->getJugador($listaParejas[$i]->jugador1_id);
                $listaParejas[$i]->jugador1 = $jugador1;                
                unset($listaParejas[$i]->jugador1_id);
                
                $jugador2 = $JugadorModel->getJugador($listaParejas[$i]->jugador2_id);
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
