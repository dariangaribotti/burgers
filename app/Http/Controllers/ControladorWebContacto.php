<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Session;

class ControladorWebContacto extends Controller
{
    public function index()
    {   
        $pg = "contacto";
        return view("web.contacto", compact('pg'));
    }

    public function contactoGracias(Request $request)
  {
    $titulo = 'Contacto';
    $nombre = $request->input('txtNombre');
    $email = $request->input('txtEmail');
    $numero = $request->input('txtNumero');
    $descripcion = $request->input('txtDescripcion');

    if ($nombre != "" && $email != "" && $numero != "" && $descripcion != ""){
      //Envia  mail con las instrucciones

      $data = "Instrucciones";

      $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
      try {
        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = env('MAIL_HOST');  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = env('MAIL_USERNAME');                 // SMTP username
        $mail->Password = env('MAIL_PASSWORD');                           // SMTP password
        $mail->SMTPSecure = env('MAIL_ENCRYPTION');                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = env('MAIL_PORT');                                    // TCP port to connect to

        //Recipients
        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $mail->addAddress($email);               // Name is optional
        $mail->addReplyTo('no-reply@fmed.uba.ar');

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Gracias por contactarse: ' . $nombre;
        $mail->Body    = "Sus datos ingresados fueron:
        Nombre: $nombre
        Correo: $email
        Numero: $numero
        Descripción: $descripcion
        ";
        //$mail->send(burger....);
        $mensaje = "Se ha enviado correctamente el mensaje";
        return view('web.recuperar-clave', compact('titulo', 'mensaje'), redirect('/contacto-gracias'));
      } catch (Exception $e) {
        $mensaje = "Hubo un error al enviar el mensaje";
        return view('web.recuperar-clave', compact('titulo', 'mensaje'));
      }
    } else {
      return view('web.recuperar-clave', compact('titulo', 'mensaje'));
    }
  }
}
