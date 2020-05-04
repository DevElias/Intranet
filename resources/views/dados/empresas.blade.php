@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Empresas</h1>
    <ul>
        <li><a href="">Dashboard</a></li>
        <li>Dados de Empresa</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="table-responsive">
        <table class="display table table-striped table-bordered" id="dados-clientes" style="width:100%">
            <thead>
                <tr>
                    <th>Nome Fantasia</th>
                    <th>Razão Social</th>
                    <th>CNPJ</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Whatsapp</th>
                    <th>Status</th>
                    <th>Alteração</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($empresas as $empresa): ?>
                    <tr>
                        <td><?php echo($empresa->nome_fantasia);?></td>
                        <td><?php echo($empresa->razao_social);?></td>
                        <td class="cnpj"><?php echo($empresa->cnpj);?></td>
                        <td><?php echo($empresa->email);?></td>
                        <td class="tel"><?php echo($empresa->telefone);?></td>
                        <td class="whats"><?php echo($empresa->whatsapp);?></td>
                        <td>
                            <?php if($empresa->status == 0)
                                    {
                            ?>
                                    <span class="btn btn-warning m-1">Pendente</span>
                            <?php }
                            elseif($empresa->status == 1){?>
                                    <span class="btn btn-success m-1">Aprovado</span>
                            <?php }else{?>
                            <span class="btn btn-danger m-1">Reprovado</span>
                            <?php }?>
                        </td>
                        <td>
                        <a href="#" onclick="ReprovarEmpresa(<?php echo($empresa->id);?>);" title="Reprovar" class="reprovar">
                        <i class="text-20 i-Close-Window"></i></a> </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Nome Fantasia</th>
                    <th>Razão Social</th>
                    <th>CNPJ</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Whatsapp</th>
                    <th>Status</th>
                    <th>Alteração</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>
<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/empresa/empresa.js')}}"></script>
<script src="{{asset('assets/js/jquery-confirm.js')}}"></script>
<script src="{{asset('assets/js/sistema.js')}}"></script>
<script>
    $(document).ready(function () {
        // zero table
        $('#dados-clientes').DataTable({
            "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
        }); // feature enable/disable
        setTimeout(
            function()
            {
                $('.buttons-print span').html('Imprimir')
            }, 500);
    });
</script>
@endsection
