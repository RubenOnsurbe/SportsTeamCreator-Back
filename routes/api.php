<?php

use App\Models\Club;
use App\Models\Equipo;
use App\Models\UsuarioEquipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Usuario;
use App\Models\Usuarioclub;
use App\Http\Controllers\PHPMailerController;
use App\Models\Evento;
use App\Models\TokenSession;


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
    $respuesta = PHPMailerController::cambiarContrasena($data); // Llama a la función del modelo Usuario

    return $respuesta; // Devuelve la respuesta como JSON
});



Route::post('/clubesUsuario', function (Request $request) {
    $data = $request->all();
    $respuesta = Usuarioclub::getClubs($data);

    return response()->json($respuesta); // Devuelve la respuesta como JSON
});



Route::post('/crearClub', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Club::crearClub($data); // Llama a la función del modelo Usuario

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

Route::post('/obtenerEventosDeClub', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Evento::obetenerEventosDeClub($data);
    return response()->json($respuesta); // Devuelve la respuesta paginada como JSON
});

Route::post('/obtenerEventosDeEquipo', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Evento::obtenerEventosDeEquipo($data);
    return response()->json($respuesta); // Devuelve la respuesta paginada como JSON
});

Route::post('/equiposUsuario', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Equipo::EquiposUsuario($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/getRoles', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Usuarioclub::getRoles($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});
Route::post('/datosClub', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Club::infoClub($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});
Route::post('/modificarClub', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Club::modificarClub($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/modificarUsuario', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Usuario::modificarUsuario($data);
    return response()->json($respuesta); // Devuelve la respuesta paginada como JSON
});
Route::post('/infoUsuario', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Usuario::obtenerInfo($data);// Llama a la función del modelo Usuario

    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/jugadoresClub', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Usuarioclub::jugadoresClub($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/nombreJugador', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Usuario::nombreJugador($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/obtenerDatosEquipo', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Equipo::obtenerDatosEquipo($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/modificarEquipo', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Equipo::modificarEquipo($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/crearEvento', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Evento::crearEvento($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/equiposClub', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Equipo::equiposClub($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/crearEquipo', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Equipo::crearEquipo($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/unirseEquipo', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = UsuarioEquipo::unirseEquipo($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/borrarEquipo', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Equipo::borrarEquipo($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/equipoPorId', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Equipo::equipoPorId($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/editarEquipo', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Equipo::editarEquipo($data); // Llama a la función del modelo Usuario
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/comprobarUsuarioPerteneceClub', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Usuarioclub::comprobarUsuarioPerteneceClub($data);
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/borrarEvento', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Evento::borrarEvento($data); // Llama a la función del modelo Evento
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/jugadoresEquipo', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = UsuarioEquipo::jugadoresEquipo($data); // Llama a la función del modelo UsuarioEquipo
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/expulsarJugadorEquipo', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = UsuarioEquipo::expulsarJugadorEquipo($data); // Llama a la función del modelo UsuarioEquipo
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});

Route::post('/infoEquipo', function (Request $request) {
    $data = $request->all(); // Obtén los datos de la solicitud
    $respuesta = Equipo::infoEquipo($data); // Llama a la función del modelo Equipo
    return response()->json($respuesta); // Devuelve la respuesta como JSON
});