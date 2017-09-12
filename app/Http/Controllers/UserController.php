<?php

namespace App\Http\Controllers;

use JWTAuth;
use JWTAuthException;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    #metodo para registrar
    public function register(Request $request){
    	#validación
        $this->validate($request, [
            'name' => 'required|min: 4',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required|min:6'
        ]);
        #creamos 1 nuevo usuario
        $user = new User($request->all());
        #guardamos contraseña encriptada
        $user->password = bcrypt($request->password);
        #guardamos usuario en db
        $user->save();
        #retornamos JSON
        return response()->json([
        	'status' => 200,
        	'mensaje' => 'Usuario fue creado',
        	'datos' => $user
        ]);
    }

    #metodo para iniciar sesión
    public function login(Request $request){
    	$credenciales = $request->only('username', 'password');
    	$token = null;
    	try{
    		#verifica credenciales y crea token para el usuario
    		if (!$token = JWTAuth::attempt($credenciales)) {
    			return response()->json(['error' => 'credenciales invalidas'], 422);
      	}
    	}catch(JWTAuthException $e){
    		#error al crear token
    		return response()->json(['error' => 'no pudo crearse token'], 500);
    	}
    	#todo bien, retorna el token
    	return response()->json(compact('token'));
    }

    #obtener usuario apartir del token
    public function getAuthUser(Request $request){
    	#obtenemos usuario del token
    	$user = JWTAuth::toUser($request->token);
    	return response()->json(['usuario' => $user]);
    }
}
