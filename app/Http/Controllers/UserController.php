<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->token = $user->createToken($user->email)->accessToken;
        return $user;
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->all())) {
            $user = auth()->user();
            $user->token = $user->createToken($user->email)->accessToken;
            $user->imagem = asset($user->imagem);
            return $user;
        }

        return ['status' => false];
    }

    /**
     * @param UserUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request)
    {
        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        if ($request->imagem) {
            $time = time();
            $diretorioPai = 'perfis';
            $diretorioImagem = $diretorioPai . DIRECTORY_SEPARATOR . 'perfil_id' . $user -> id;
            $ext = substr($request -> imagem, 11, strpos($request -> imagem, ';') - 11);
            $urlImagem = $diretorioImagem . DIRECTORY_SEPARATOR . $time . "." . $ext;
            $file = str_replace('data:image/' . $ext . ';base64,', '', $request -> imagem);
            $file = base64_decode($file);

            if ($user->imagem) {
                if (file_exists($user->imagem)) {
                    unlink($user->imagem);
                }
            }

            if (!file_exists($diretorioPai)) {
                mkdir($diretorioPai, 0700);
            }

            if (!file_exists($diretorioImagem)) {
                mkdir($diretorioImagem, 0700);
            }

            file_put_contents($urlImagem, $file);
            $user->imagem = $urlImagem;
        }

        $user->save();
        $user->imagem = asset($user->imagem);

        $user->token = $user->createToken($user->email)->accessToken;
        return $user;
    }
}
