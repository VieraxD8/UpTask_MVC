<?php

namespace Model;

use Model\ActiveRecord;


class Usuario extends ActiveRecord {

    protected static $tabla = 'usuario';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password','token','confirmado'];

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $token;
    public $confirmado;
    public $password2;
    public $password_nuevo;
    public $password_actual;
   



    public function __construct($args = []){

        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;

        
        
    }


    //Validacion para cuenta nueva

    public function validarNuevaCuenta(){

        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre del Usuario es obligatorio';
        }

        if(!$this->email){
            self::$alertas['error'][] = 'El email del Usuario es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'El password no puede ir vacio';
        }
        if(strlen($this->password) < 6 ){
            self::$alertas['error'][] = 'El password debe tener mas de  seis caracteres';
        }

        if($this->password !== $this->password2){
            self::$alertas['error'][] = 'Los password son diferentes';
        }


        return self::$alertas;

    }

    //Valida el emamil

    public function validarEmail(){
        
        if(!$this->email){
            self::$alertas['error'][] = 'El email del Usuario es obligatorio';
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'El email NO ES VALIDO';
        }

        return self::$alertas;
        
    }


    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'El password no puede ir vacio';
        }
        if(strlen($this->password) < 6 ){
            self::$alertas['error'][] = 'El password debe tener mas de  seis caracteres';
        }

        
        return self::$alertas;
    }

    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = 'El email del Usuario es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'El password no puede ir vacio';
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'El email NO ES VALIDO';
        }

        return self::$alertas;
    }




    //Haasshea el passrword
    public function hashPassword(){

        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

    }

    //Generar un token

    public function crearToken(){
        $this->token = md5(uniqid());
    }

    //Validar perfil

    public function validar_perfil(){
        if(!$this->nombre){
            self::$alertas['error'][] = "El nombre es obligatorio";
        }
        if(!$this->email){
            self::$alertas['error'][] = "El email es obligatorio";
        }

        return self::$alertas;
    }

    //Nuevo Password

    public function nuevo_password(){
        if(!$this->password_actual){
            self::$alertas['error'][] = "El Password Actual no debe estar vacio";
        }

        if(!$this->password_nuevo){
            self::$alertas['error'][] = "El Password Nuevo es obligatorio  no debe estar vacio";
        }

        if(strlen($this->password_nuevo) < 6){
            self::$alertas['error'][] = "El password nuevo debe tener al menos mas de 6 caracteres";
        }

        return self::$alertas;
    }

    //Comprobar el password

    public function comprobar_password(){
        return password_verify($this->password_actual, $this->password);
    }


}















?>