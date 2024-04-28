<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Str;
use App\Models\Usuario;
use App\Models\Token;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class PHPMailerController extends Controller
{
    



    public static function store($request)
{
    
   
    $token = Str::random(60); 
    $correoDestinatario = $request['correo'];


    $usuario = Usuario::where('correo', $correoDestinatario)->first();
   

    if($usuario != null){

        try {
            $nuevoToken = new Token();
            $nuevoToken->correo = $correoDestinatario;
            $nuevoToken->token = $token;
            $nuevoToken->save();
        } catch (QueryException $e) {
            // Manejar la excepción de violación de clave foránea
            return response()->json(['error' => 'Error al crear token ' . $e->getMessage()], 500);
        }
       
    
    try {
        // Se obtiene la dirección de correo electrónico del usuario desde la solicitud
       

        // Guardar el nuevo token en la base de datos
        $nuevoToken->save();




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

        
        
        
        $mail->Body = " <html>
        <head>
            <title>Recuperación de contraseña</title>
        </head>
        <body>
            <h1>Recuperación de contraseña</h1>
            <h4>Si no has solicitado un cambio de contraseña ponte en contacto con nuestro equipo técnico</h4>
            <a href='http://localhost:4200/cambiarContrasena?token=".$token."&correo=".$correoDestinatario."'>Cambiar mi contraseña</a>
        </body>
        </html>
        ";
        // Enviar el correo electrónico
        $mail->send();
                
        return response()->json(['message' => 'Correo electrónico enviado correctamente'], 200);
    } catch (Exception $e) {
        // Registrar el mensaje de error
        Log::error('Error al enviar el correo electrónico: ' . $e->getMessage());
    
        // Devolver una respuesta JSON con el mensaje de error
        return response()->json(['error' => 'No se pudo enviar el correo electrónico'], 500);
    }
}else return "No existe el correo";

}



public static function cambiarContrasena($data){

    $correoEnviado = $data['correo'];
    $tokenEnviado = $data['token'];

  if(Token::where('correo', $correoEnviado)
  ->where('token', $tokenEnviado)
  ->first()){


     $data['contrasena'] = password_hash($data['contrasena'], PASSWORD_DEFAULT);

    $usuario = Usuario::where('correo', $correoEnviado)->first();
    $usuario->contrasena= $data['contrasena'];
    $usuario->save();
    

    $tokenABorrar = Token::find($data['correo']);
    $tokenABorrar->delete();

    return response('<h1>Contraseña cambiada con éxito</h1><p>Puedes cerrar esta ventana</p>', 200)
    ->header('Content-Type', 'text/html');




  }else{
    return "Hubo un problema";
  }




}


public static  function mostrarFormNuevaContrasena(){
  
    $response = Http::get('http://localhost:4200/cambiarContrasena');
    return $response;
  }

}
