@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Dashboard</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Admin</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="row">
            <div class="col-lg-2 col-md-4 col-sm-6">
                    <a class="card card-custom card-icon mb-4" href="/empresa">
                        <div class="card-body text-center"><i class="i-Post-Office"></i>
                            <p class="text-muted mt-2 mb-2">Empresas Ativas</p>
                            <p class="text-primary text-24 line-height-1 m-0"><?php echo $empresasativas ?></p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <a class="card card-custom card-icon mb-4" href="/aprovacoes/empresas">
                        <div class="card-body text-center"><i class="i-Check"></i>
                            <p class="text-muted mt-2 mb-2">Empresas Pendentes</p>
                            <p class="text-primary text-24 line-height-1 m-0"><?php echo $empresaspendentes ?></p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <a class="card card-custom card-icon mb-4" href="/empresa/nova">
                        <div class="card-body text-center"><i class="i-Add-Window"></i>
                            <p class="text-muted mt-2 mb-2">Adicionar Nova Empresa</p>
                            <p class="text-primary text-24 line-height-1 m-0">+</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <a class="card card-custom card-icon mb-4" href="/dados/clientes">
                        <div class="card-body text-center"><i class="i-Business-Man"></i>
                            <p class="text-muted mt-2 mb-2">Usuários Cadastrados</p>
                            <p class="text-primary text-24 line-height-1 m-0"><?php echo $usuariosativos ?> </p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <a class="card card-custom card-icon mb-4" href="/aprovacoes/clientes">
                        <div class="card-body text-center"><i class="i-Add-User"></i>
                            <p class="text-muted mt-2 mb-2">Aprovações de Usuários em Empresa</p>
                            <p class="text-primary text-24 line-height-1 m-0"><?php echo $usuariospendentes ?> </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>

@endsection
