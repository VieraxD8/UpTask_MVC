<?php 


    namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;


    class DashboardControllers{


        public static function index(Router $router) {

            session_start();

            isAuth();

            $id = $_SESSION['id'];

            $proyectos = Proyecto::belongsTo('propietarioid', $id);

            


            $router->render('dashboard/index', [
                
                'titulo' => 'Proyectos',
                'proyectos' => $proyectos
            
            ]);


        }

        public static function crear_proyecto(Router $router) {
            
            session_start();

            isAuth();

            $alertas = [];

            if($_SERVER['REQUEST_METHOD'] ==='POST'){

                $proyecto = new Proyecto($_POST);

 

                //vALIDACION 

                $alertas = $proyecto->validarProyecto();

                if(empty($alertas)){

                    //Generar una url unica

                    $proyecto->url = md5(uniqid());


                    //Almacenar el creador del proyecto

                    $proyecto->propietarioid = $_SESSION['id'];

              
                    
                    //Guardar  el Proyecto

                    $proyecto->guardar();

                    //Reedireccionar 

                    header('Location: /proyecto?id='. $proyecto->url);


                }

            }


            $router->render('dashboard/crear_proyecto', [
                
                'titulo' => 'Crear Proyecto',
                'alertas' => $alertas
            
            ]);
        }


        public static function proyecto(Router $router){

            session_start();

            isAuth();



            $token = $_GET['id'];
            if(!$token) header('Location: /dashboard');

            //REvisar que la persona que visita el proyecto, es quien lo creo

            $proyecto = Proyecto::where('url', $token);

        
            if($proyecto->propietarioid !== $_SESSION['id']){
               header('Location: /dashboard');
            }



            $router->render('dashboard/proyecto', [
                
                'titulo' => $proyecto->proyecto
            
            ]);

        }


        public static function perfil(Router $router){

            session_start();
            isAuth();

            $alertas = [];

            $usuario = Usuario::find($_SESSION['id']);

            if($_SERVER['REQUEST_METHOD'] ==='POST'){

                $usuario->sincronizar($_POST);

                $alertas = $usuario->validar_perfil();

                if(empty($alertas)){

                    $existeUsuario = Usuario::where('email', $usuario->email);

                    if( $existeUsuario && $existeUsuario->id !== $usuario->id){
                        //Mensaje de error
                        Usuario::setAlerta('error', 'Email no valido, ya pertenece a otra cuenta');
                        $alertas = $usuario->getAlertas();



                    }else {
                        //Guardar el registro
                        //Guardar el usuario

                        $usuario->guardar();

                        Usuario::setAlerta('exito', 'Guardado Correctamente');
                        $alertas = $usuario->getAlertas();

                        //Assignar el nombre nuevo a la barra

                        $_SESSION['nombre'] = $usuario->nombre;
                    }

                    }


                    

            }


            $router->render('dashboard/perfil', [
                
                'titulo' => 'Perfil',
                'usuario' => $usuario,
                'alertas' => $alertas
            
            ]);

        }


        public static function cambiar_password(Router $router){

            session_start();
            isAuth();

            $alertas = [];


            if($_SERVER['REQUEST_METHOD'] ==='POST'){

                $usuario = Usuario::find($_SESSION['id']);

                //Sincronizar con los datos del usuario

                $usuario->sincronizar($_POST);

                $alertas = $usuario->nuevo_password();

                if(empty($alertas)){
                    $resultado = $usuario->comprobar_password();

                    if($resultado ){

                        

                        $usuario->password = $usuario->password_nuevo;
                        
                        //Eliminar propiedades no necesarias
                        unset($usuario->password_actual);
                        unset($usuario->password_nuevo);

                        //hashear el nuevo password

                        $usuario->hashPassword();

                        //Actualizar 

                        $resultado = $usuario->guardar();

                        if($resultado) {
                            Usuario::setAlerta('exito', 'El password ha sido cambiado exitosamente');
                            $alertas = $usuario->getAlertas();
                        }
                        
                        //Asignar el nuevo password



                    }else {
                        Usuario::setAlerta('error', 'Password Incorrecto');
                        $alertas = $usuario->getAlertas();
                    }
                }

            }

            $router->render('dashboard/cambiar-password',[

                'titulo' => 'Cambiar Clave',
                'alertas' => $alertas

            ]);
        }


    }










?>