<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;
use Classes\Email;




class LoginControllers {

    public static function login(Router $router){
      

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                //Verifiar que el usuario exista

                $usuario = Usuario::where('email', $auth->email);

                if(!$usuario || !$usuario->confirmado){

                    $usuario::setAlerta('error', 'Este usuario no existe');

                }else{

                    //El usuario existe

                    if(password_verify($_POST['password'], $usuario->password)){

                        //Iniciar Sesion 

                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Reedireccionar 

                        header('Location: /dashboard');


                    }else {
                        $usuario::setAlerta('error', 'Password es invalido');
                    }

                }
                
            }

        }

        $alertas = Usuario::getAlertas();

        //Render a la vista

        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesion',
            'alertas' => $alertas

        ]);
    }

    public static function logout(){
        
        session_start();

        $_SESSION=[];

        header('Location: /');

    }

    public static function crear(Router $router){

        $alertas = [];
       
        $usuario = new Usuario;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevaCuenta();

           if(empty($alertas)){
            $existeUsuario = Usuario::where('email', $usuario->email);

                if($existeUsuario){

                        Usuario::setAlerta('error', 'El usuario ya esta registrado');
                        $alertas = Usuario::getAlertas();
                } else {
                    
                    // Hashear  el password
                    
                    $usuario->hashPassword();

                    //ELIMINAR password2

                    unset($usuario->password2);

                    //Generar token

                    $usuario->crearToken();
  

                    //Enviar Email

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    //Crear un nuevo usuario

                    $resultado = $usuario->guardar();

                    if($resultado){
                        header('Location: /mensaje');
                    }

                }
            }

        }

          //Render a la vista

          $router->render('auth/crear', [
            'titulo' => 'Crear Cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas

        ]);
    }

    public static function olvide(Router $router){

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarEmail();

            if(empty($alertas)){

                //Buscar el usuario

                $usuario = Usuario::where('email', $usuario->email);
                
                if($usuario && $usuario->confirmado === '1'){
                    //Generar un nuevo token

                    $usuario->crearToken();
                    unset($usuario->password2);

                    //Actualizar el usuario
                    $usuario->guardar();

                    //Enviar el email

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                    $email->enviarInstrucciones();

                    //Imprimir la alarta
                    Usuario::setAlerta('exito', 'Revisa tu Email');

                }else{

                    //No lo encontro

                    Usuario::setAlerta('error','El usuario no existe o no esta confirmado');
                }

            }

        }
        $alertas = Usuario::getAlertas();

        //Render a la vista

        $router->render('auth/olvide-password', [
            'titulo' => 'Olvide Password',
            'alertas' => $alertas

        ]);
    }


    public static function reestablecer(Router $router){
     
        $token = s($_GET['token']);
        $mostrar = true;

        if(!$token) header('Location: /');

        //Identificar el usuario con este token

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no valido');
            $mostrar = false;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //Añadir el nuevo password

            $usuario->sincronizar($_POST);

            //Validar el password

            $alertas = $usuario->validarPassword();

            if(empty($alertas)){
                //Hashear el nuevo password

                $usuario->hashPassword();

                //Eliminar el token

                $usuario->token = null;

                //Guardar el usuario

                $resultado = $usuario->guardar();

                //Reedirecionar

                if($resultado){
                    
                    header('Location: /');

                }



            }


        }

        $alertas = Usuario::getAlertas();
        
        //Render a la vista

        $router->render('auth/Reestablecer', [
            'titulo' => 'Reestablecer Password',
            'alertas'=> $alertas,
            'mostrar' => $mostrar

        ]);
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta Creada Correstamente'

        ]);

    }

    public static function confirmar(Router $router){

        $token = S($_GET['token']);

        if(!$token ) header('Localhost: /');

        //Encontrar el usuario con este token

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){

            //No se encontro un usuario con ese token
            
            Usuario::setAlerta('error', 'Token No Valido');
        } else {
            //Confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->password2);

            //Guardar en la BD
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }

        $alertas = Usuario::getAlertas();


        $router->render('auth/confirmar', [
            'titulo' => 'Cuenta Confirmada',
            'alertas' => $alertas

        ]);

    }



}



?>