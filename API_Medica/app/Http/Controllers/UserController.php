<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all();
        return response()->json(['mensagem' => 'Lista de usuários cadastrados', "resultado" => $usuarios], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Aqui ficaria a verificação se o usuário está logado (para poder realizar essa ação)
        try{
            $usuario = User::create($request->all());
        }catch(\Exception $e){
            return response()->json(['mensagem' => 'Parâmetros faltando ou inválidos'], 400);
        }
        //Aqui ficaria uma verificação para verificar o tipo do usuário logado e ainda, saber se ele pode ou não fazer isso
        $usuario->save();
        return response()->json(['mensagem' => 'Usuário criado com sucesso'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $cpf)
    {
        $usuario = User::where('cpf', $cpf)->first();
        if (!$usuario) {
            return response()->json(['mensagem' => 'Usuário não encontrado'], 404);
        }
        return response()->json(['mensagem' => 'Dados do usuário encontrados', 'resultado' => $usuario], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $cpf)
    {
        //Aqui ficaria a verificação se o usuário está logado (para poder realizar essa ação)
        $user = User::where('email', $request->email)->first();
        $usuario = User::where('cpf', $cpf)->first();
        if (!$usuario) {
            return response()->json(['mensagem' => 'Usuário não encontrado'], 404);
        }
        $usuario->update($request->all());
        return response()->json(['mensagem' => 'Dados do usuário alterados com sucesso'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $cpf)
    {
        //Aqui ficaria a verificação se o usuário está logado (para poder realizar essa ação)
        $usuario = User::where('cpf', $cpf)->first();
        if (!$usuario) {
            return response()->json(['mensagem' => 'Usuário não encontrado'], 404);
        }
        $usuario->delete();
        return response()->json(['mensagem' => 'Usuário apagado com sucesso'], 200);

    }
}
