<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Str;
use app\Models\Usuario;

class PHPMailerController extends Controller
{
    



    public static function store($request)
{
    
    $token = Str::random(60); 


    try {
        // Se obtiene la dirección de correo electrónico del usuario desde la solicitud
        $correoDestinatario = $request['correo'];

        // Crear una instancia de PHPMailer
        $mail = new PHPMailer(true);

        // Configurar las opciones de PHPMailer
        $mail->isSMTP();
        $mail->Host = env('MAIL_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
        $mail->SMTPSecure = env('MAIL_ENCRYPTION');
        $mail->Port = env('MAIL_PORT');

        // Configurar el remitente y destinatario del correo electrónico
        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $mail->addAddress($correoDestinatario);

        // Configurar el contenido del correo electrónico
        $mail->isHTML(true);
        $mail->Subject = "Cambio de contrasena";
        $mail->Body = "
                        <html>
                        <head>
                            <title>Recuperación de contraseña</title>
                        </head>
                        <body>
                            <h1>Recuperación de contraseña</h1>
                            <p>Por favor, introduce tu nueva contraseña a continuación:</p>
                            <form action='http://127.0.0.1:8000/api/cambiarContrasena1' method='post'>
                                <input type='password' name='password' placeholder='Nueva contraseña' required>
                                <input type='hidden' name='token' value='".$token."'>
                                <input type='hidden' name='correo' value='".$correoDestinatario."'>
                                <input type='submit' value='Guardar contraseña'>
                            </form>
                        </body>
                        </html>
                        ";

        // Enviar el correo electrónico
        $mail->send();

        return response()->json(['message' => 'Correo electrónico enviado correctamente'], 200);
    } catch (Exception $e) {
        return response()->json(['error' => 'No se pudo enviar el correo electrónico'], 500);
    }
}

public static function cambiarContrasena($data){




    
}
}
