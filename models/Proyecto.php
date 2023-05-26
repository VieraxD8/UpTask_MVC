<?php

    namespace Model;

    use Model\ActiveRecord;

    class Proyecto extends ActiveRecord {

        protected static $tabla = 'proyectos';
        protected static $columnasDB = ['id','proyecto'  ,'url', 'propietarioid'];

        public $id;
        public $url;
        public $proyecto;
        public $propietarioid;

        public function __construct($args = []){

            $this->id = $args['id'] ?? null;
            $this->url = $args['url'] ?? '';
            $this->proyecto = $args['proyecto'] ?? '';
            $this->propietarioid = $args['propietarioid'] ?? '';


        }


        public function validarProyecto(){
            if(!$this->proyecto){
                self::$alertas['error'][] = 'El nombre del proyecto es obligatoro';
            }

            return self::$alertas;
        }
        

    }




?>