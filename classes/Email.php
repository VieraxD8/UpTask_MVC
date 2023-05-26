<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token){

        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
        
    }

    public function enviarConfirmacion(){


        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '53345fb609924f';
        $mail->Password = '16127101318cc0';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com', 'uptask.com');
        $mail->Subject = 'Confirma tu Cuenta';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';


        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . " Has creado tu cuenta en UpTask, solo debes confirmala en el siguiente enlace </p>";
        $contenido .="<p>Presiona aqui: <a href='http://localhost:3000/confirmar?token=" . $this->token."'>Confirmar Cuenta</a> </p>";
        $contenido .= "<p>Si tu no creaste esta cuenta puedes ignorar el correo</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        // Enviar el email

        $mail->send();

    }

    public function enviarInstrucciones(){


        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '53345fb609924f';
        $mail->Password = '16127101318cc0';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com', 'uptask.com');
        $mail->Subject = 'Reestablece tu password';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';


        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . " Has solicitado cambiar la clave de tu cuenta en UpTask, solo debes confirmala en el siguiente enlace </p>";
        $contenido .="<p>Presiona aqui: <a href='http://localhost:3000/reestablecer?token=" . $this->token."'>Recuperar contraseña</a> </p>";
        $contenido .= "<p>Si tu no creaste esta cuenta puedes ignorar el correo</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        // Enviar el email

        $mail->send();

    }

    


}





?>