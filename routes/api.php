<?php

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Usuario;
use App\Http\Controllers\PHPMailerController;
use App\Models\Evento;
use App\Models\TokenSession;
use App\Models\Token;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/crear-usuario', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Usuario::crearUsuario($data); // Llama a la función del modelo Usuario

    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/iniciarSesion', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Usuario::iniciarSesion($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/comprobarToken', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = TokenSession::comprobarToken($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});


//Correo de cambio contraseña

Route::post('/enviarCorreoCambioContrasena', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = PHPMailerController::store($data); // Llama a la función del modelo Usuario

    return response()->json($respuesta); // Devuelve la respuesta como JSON
});



//Endpoint donde se envia la nueva contrasena introducida por el usuario desde su gmail

Route::post('/cambiarContrasena', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Usuario::cambiarContrasena($data); // Llama a la función del modelo Usuario

    return $respuesta; // Devuelve la respuesta como JSON
});


Route::post('/comprobarTokenCorreo', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Token::coincideTokenConCorreo($data); // Llama a la función del modelo Usuario

    return $respuesta; // Devuelve la respuesta como JSON
});



Route::post('/clubesUsuario', function (Request $request) {
    $data = $request['DNI'];
    $respuesta = Usuario::obtenerClubes($data);

    return response()->json($respuesta); // Devuelve la respuesta como JSON
});







Route::post('/crearClub', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Usuario::crearClub($data); // Llama a la función del modelo Usuario

    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/unirseAClub', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Club::unirseAClub($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/dejarClub', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Usuario::dejarClub($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});


Route::post('/cuantosUsuarios', [Usuario::class, 'cuantosUsuarios']);




Route::post('/obtenerClubes', function () {

    $respuesta = Club::paginate(10);

    return response()->json($respuesta); // Devuelve la respuesta como JSON
});




Route::post('/searchClub', function (Request $request) {
    $data = $request->all();
    $response = Club::where('nombre', 'LIKE', $data['nombre'] . "%")->paginate(6);
    return response()->json($response);
});


Route::post('/obtenerEventosDeUsuario', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud

    $respuesta = Evento::obtenerEventosDeUsuario($data['dni']);
    return response()->json($respuesta); // Devuelve la respuesta paginada como JSON
});
