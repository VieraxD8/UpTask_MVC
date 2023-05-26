<?php

namespace Model;
use Model\ActiveRecord;


class Tarea extends ActiveRecord {

    protected static $tabla = 'tarea';
    protected static $columnasDB = ['id', 'nombre', 'estado', 'proyectoid'];


    public $id;
    public $estado;
    public $nombre;
    public $proyectoid;

    public function __construct($args = []){

        $this->id = $args['id'] ?? null;
        $this->estado = $args['estado'] ?? 0;
        $this->nombre = $args['nombre'] ?? '';
        $this->proyectoid = $args['proyectoid'] ?? '';


    }
  
   

}







?>