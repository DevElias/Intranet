<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller

{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresasAtivas = DB::table('empresa')->where('status', 1)->count();
        $empresasPendentes = DB::table('empresa')->where('status', 0)->count();
        $usuariosAtivos = DB::table('usuario')->where('status', 1)->count();
        $usuariosPendentes = DB::table('solicitacao')->where('status', 0)->count();
        return view('dashboard.admin')->with([
            'empresasativas'        =>  $empresasAtivas,
            'empresaspendentes'     =>  $empresasPendentes,
            'usuariosativos'        =>  $usuariosAtivos,
            'usuariospendentes'     =>  $usuariosPendentes,
        ]);
    }
    public function cliente()
    {
        session_start();
        $empresasClienteAtiva = DB::table('solicitacao')->where('id_usuario', $_SESSION['id'])->where('status', 1)->count();
        $empresasClientePendente = DB::table('solicitacao')->where('id_usuario', $_SESSION['id'])->where('status', 0)->count();
            return view('dashboard.cliente')->with([
                'empresacliente'           =>  $empresasClienteAtiva,
                'empresaclientependente'   =>  $empresasClientePendente,
                ]);
    }
}
