<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Session;

require app_path() . '/start/constants.php';

class ControladorWebRecuperarClave extends Controller
{
  public function index()
  {
    return view("web.recuperar-clave");
  }

  public function recuperarClave(Request $request)
  {
    $titulo = 'Recupero de clave';
    $email = $request->input('txtEmail');
    $clave = rand(1000, 9999);

    $cliente = new Cliente();
    $cliente->obtenerPorCorreo($email);

    if ($request->filled(["txtEmail"])){
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
        $mail->Subject = 'Recupero de clave';
        $mail->Body    = "Los datos de acceso son: 
        Usuario: $cliente->correo
        Clave: $clave
        ";
        //$mail->send();
        $msg["MSG"] = "Se ha cambiado correctamente la clave";
        $msg["ESTADO"] = "success";
        return view('web.recuperar-clave', compact('titulo', 'mensaje'));
      } catch (Exception $e) {
        $msg["MSG"] = "Hubo un error al cambiar la clave";
        $msg["ESTADO"] = "danger";
        return view('web.recuperar-clave', compact('titulo', 'mensaje'));
      }
    } else {
      $msg["MSG"] = "Complete los datos";
      $msg["ESTADO"] = "danger";
      return view('web.recuperar-clave', compact('titulo', 'mensaje'));
    }
  }
}
