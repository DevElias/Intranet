<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer;

require(dirname(__FILE__).'/../../../vendor/phpmailer/phpmailer/src/PHPMailer.php');
require(dirname(__FILE__).'/../../../vendor/phpmailer/phpmailer/src/SMTP.php');
require(dirname(__FILE__).'/../../../vendor/phpmailer/phpmailer/src/POP3.php');
require(dirname(__FILE__).'/../../../vendor/phpmailer/phpmailer/src/Exception.php');

class UsuarioController extends Controller
{
    public function login(Request $request)
    {
        session_start();
        $input  = $request->all();
        $id  = Usuario::where('email', '=', $input['email'])->where('senha', '=', $input['senha'])->where('status', '=', 1)->orWhere('cpf', '=', $input['email'])->where('senha', '=', $input['senha'])->where('status', '=', 1)->pluck('id');

        if($id->isNotEmpty())
        {
            $aUser = Usuario::find($id);

            $_SESSION['id']     = $aUser[0]->id;
            $_SESSION['nome']   = $aUser[0]->nome;
            $_SESSION['email']  = $aUser[0]->email;
            $_SESSION['cpf']    = $aUser[0]->cpf;
            $_SESSION['tipo']   = $aUser[0]->tipo_usuario;
            $_SESSION['status'] = $aUser[0]->status;
            
            if($_SESSION['status'] == 0)
            {
                $message[] = 'Usu&aacute;rio pendente de aprova&ccedil;&atilde;o';
                $code      = 500;
                $redirect  = 'nao direciona';
                return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
            }

            $message[] = 'Usuario logado com sucesso!';
            $code      = 200;

            if($_SESSION['tipo'] == '0')
            {
                $redirect  = '/dashboard-admin';
            }
            else
            {
                $redirect  = '/dashboard-cliente';
            }
        }
        else
        {
            $message[] = 'Usu&aacute;rio o Senha Incorreto';
            $code      = 500;
            $redirect  = 'nao direciona';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /');
        die();
    }

    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $input   = $request->all();
        $usuario = new Usuario;

        $usuario->nome              = $request->nome;
        $usuario->email             = $request->email;
        $usuario->cpf               = $request->cpf;
        $usuario->data_nascimento   = $request->nascimento;
        $usuario->telefone          = $request->telefone;
        $usuario->whatsapp          = $request->whatsapp;
        $usuario->cep               = $request->cep;
        $usuario->endereco          = $request->endereco;
        $usuario->numero            = $request->numero;
        $usuario->complemento       = $request->complemento;
        $usuario->bairro            = $request->bairro;
        $usuario->cidade            = $request->cidade;
        $usuario->estado            = $request->estado;
        $usuario->senha             = $request->senha;
        $usuario->tipo_usuario      = '1';
        $usuario->status            = '0'; // Entra como Pendente
        $usuario->data_inclusao     = date('Y-m-d H:i:s');
        $usuario->usuario_inclusao  = '0'; // Cadastrado Manualmente
        $usuario->usuario_alteracao = '0';

        $usuario->save();

        if($usuario->wasRecentlyCreated == 1)
        {
            $message[] = 'Ol&aacute;! Aguarde a aprova&ccedil;&atilde;o do seu cadastro para manusear nossos recursos. Em breve retornaremos.';
            $code      = 200;
            $redirect  = '/';
        }
        else
        {
            $message[] = 'Erro ao Cadastrar Usu&aacute;rio';
            $code      = 500;
            $redirect  = '';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function profile($id)
    {
        session_start();

        if($_SESSION['id'] != $id)
        {
            header("Location: /404");
            die();
        }
        else
        {
            $aDados = DB::table('usuario')->find($id);
            return view('usuario.minha-conta')->with('dados', $aDados);
        }
    }

    public function update(Request $request)
    {
        session_start();

        $input   = $request->all();

        $results = DB::table('usuario')
                ->where('id', $input['id'])
                ->update(['data_nascimento'   => $input['nascimento'],
                          'cep'               => $input['cep'],
                          'endereco'          => $input['endereco'],
                          'numero'            => $input['numero'],
                          'complemento'       => $input['complemento'],
                          'bairro'            => $input['bairro'],
                          'cidade'            => $input['cidade'],
                          'telefone'          => $input['telefone'],
                          'whatsapp'          => $input['whatsapp'],
                          'estado'            => $input['estado'],
                          'senha'             => $input['senha'],
                          'usuario_alteracao' => $_SESSION['id'],
                          'data_alteracao'    => date("Y-m-d H:i:s")
                ]);

                if(!empty($results))
                {
                    $message[] = 'Usu&aacute;rio alterado com sucesso!';
                    $code = 200;
                    $redirect = '/minha-conta/'.$input['id'];
                }
                else
                {
                    $message[] = 'Erro ao tentar alterar usu&aacute;rio';
                    $code = 500;
                    $redirect = '';
                }

                # feedback
                $code = (!empty($code)) ? $code : 200;
                return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function esqueci(Request $request)
    {
        $aUsuario =  DB::select("SELECT * FROM usuario WHERE usuario.email = '" . $request->email . "'");
        $mail     = new PHPMailer\PHPMailer();

        if(!empty($aUsuario))
        {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.kinghost.net';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = "noreply@santistacontroleambiental.com.br";
            $mail->Password = "WMorais@20";

            //Recipients
            $mail->setFrom('noreply@santistacontroleambiental.com.br', 'Santista Sistema');
            $mail->addAddress($request->email, utf8_decode($aUsuario[0]->nome));

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Esqueci minha senha';
            $mail->Body    = '<html>
                                        <head>
                                        	<meta charset="utf-8"/>
                                        	<meta http-equiv="X-UA-Compatible" content="IE=edge">
                                        	<title>Esqueci minha Senha</title>
                                        </head>
                                        <body>
                                            <style>
                                            	* {
                                            		font-size: 14px;
                                            		line-height: 1.8em;
                                            		font-family: arial;
                                            	}
                                            </style>
                                        	<table style="margin:0 auto; max-width:660px;">
                                        		<thead>
                                        			<tr>
                                        				<th><img src="http://cliente.santistacontroleambiental.com.br/assets/images/santista-controle-ambiental.png" />  </th>
                                        			</tr>
                                        		</thead>
                                        		<tbody>
                                        			<tr>
                                        				<td><p style="padding-bottom:20px; text-align:center;">Ol&aacute;,'. utf8_decode($aUsuario[0]->nome).'</p>
                                            				Foi solicitado o envio de sua senha para acessar o sistema.<br>
                                                            <p><strong>Email: </strong>'.$aUsuario[0]->email.'</p>
                                                            <p><strong>Senha: </strong>'.$aUsuario[0]->senha.'</p>
                                        				</td>
                                        			</tr>
                                        			<tr>
                                        				<td>
                                        				</td>
                                        			</tr>
                                        		</tbody>
                                        	</table>
                                           </body>
                                        </html>';

            $mail->send();

            // Limpa os destinat�rios e os anexos
            $mail->ClearAllRecipients();
            $mail->ClearAttachments();

            $message[] = 'Senha enviada com sucesso!';
            $code      = 200;
            $redirect  = '/';
    }
    else
    {
        $message[] = 'E-mail n&atilde;o localizado';
        $code      = 500;
        $redirect  = '';
    }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code]);
    }

    public function notificacoes()
    {
        session_start();

        $aRet          =  DB::select("SELECT * FROM notificacao WHERE notificacao.status = 0 and notificacao.id_usuario_recebe = ".$_SESSION['id']);
        $html          = '';

        # Montagem Front Notificacoes
        for($i=0; $i < count($aRet); $i++)
        {
            $html .= '<div id="'.$aRet[$i]->id.'" onclick="AtualizaNotificacao('.$aRet[$i]->id.')" class="dropdown-item d-flex">';
            $html .= '<div class="notification-icon">';
            $html .= '<i class="i-Speach-Bubble-6 text-primary mr-1"></i>';
            $html .= '</div>';
            $html .= '<div class="notification-details flex-grow-1">';
            $html .= '<p class="m-0 d-flex align-items-center">';
            $html .= '<span>Nova Mensagem</span>';
            $html .= '<span class="badge badge-pill badge-primary ml-1 mr-1">new</span>';
            $html .= '<span class="flex-grow-1"></span>';
            $html .= '<span class="text-small text-muted ml-auto">'.date("d/m/Y", strtotime($aRet[$i]->data_notificacao)).'</span>';
            $html .= '</p>';
            $html .= '<p class="text-small text-muted m-0">'.$aRet[$i]->mensagem.'</p>';
            $html .= '</div>';
            $html .= '</div>';
        }

        $aRet['total'] = count($aRet);
        $aRet['html']  = $html;

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => '', 'code' => $code, 'dados' => $aRet]);
    }

    public function atualizanotificacoes(Request $request)
    {
        session_start();

        $input   = $request->all();

        $results = DB::table('notificacao')
        ->where('id', $input['id'])
        ->update(['status'   => 1
        ]);

        $aRet          =  DB::select("SELECT * FROM notificacao WHERE notificacao.status = 0 and notificacao.id_usuario_recebe = ".$_SESSION['id']);
        $html          = '';

        # Montagem Front Notificacoes
        for($i=0; $i < count($aRet); $i++)
        {
            $html .= '<div id="'.$aRet[$i]->id.'" onclick="AtualizaNotificacao('.$aRet[$i]->id.')" class="dropdown-item d-flex">';
            $html .= '<div class="notification-icon">';
            $html .= '<i class="i-Speach-Bubble-6 text-primary mr-1"></i>';
            $html .= '</div>';
            $html .= '<div class="notification-details flex-grow-1">';
            $html .= '<p class="m-0 d-flex align-items-center">';
            $html .= '<span>Nova Mensagem</span>';
            $html .= '<span class="badge badge-pill badge-primary ml-1 mr-1">new</span>';
            $html .= '<span class="flex-grow-1"></span>';
            $html .= '<span class="text-small text-muted ml-auto">'.date("d/m/Y", strtotime($aRet[$i]->data_notificacao)).'</span>';
            $html .= '</p>';
            $html .= '<p class="text-small text-muted m-0">'.$aRet[$i]->mensagem.'</p>';
            $html .= '</div>';
            $html .= '</div>';
        }

        $aRet['total'] = count($aRet);
        $aRet['html']  = $html;

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => '', 'code' => $code, 'dados' => $aRet]);
    }
    public function listausuario()
    {
        session_start();
        $aUsuarios = array();
        $aUsuarios = DB::select('SELECT * FROM usuario WHERE usuario.status = 0');
        return view('aprovacoes.usuarios')->with('usuarios', $aUsuarios);
    }

    public function aprovar(Request $request)
    {
        $input = $request->all();

        $results = DB::table('usuario')
        ->where('id', $input['id'])
        ->update(['status' => '1']);

        $aUsuario =  DB::select("SELECT * FROM usuario WHERE usuario.id = '" . $input['id'] . "'");
        $mail     = new PHPMailer\PHPMailer();

        if(!empty($aUsuario))
        {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.kinghost.net';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = "noreply@santistacontroleambiental.com.br";
            $mail->Password = "WMorais@20";

            //Recipients
            $mail->setFrom('noreply@santistacontroleambiental.com.br', 'Santista Sistema');
            $mail->addAddress($aUsuario[0]->email, utf8_decode($aUsuario[0]->nome));

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Usuario Aprovado - Sistema Santista Controle Ambiental';
            $mail->Body    = '<html>
                                        <head>
                                        	<meta charset="utf-8"/>
                                        	<meta http-equiv="X-UA-Compatible" content="IE=edge">
                                        	<title>Aprova&ccedil;&atilde;o de Usu&aacute;rio</title>
                                        </head>
                                        <body>
                                            <style>
                                            	* {
                                            		font-size: 14px;
                                            		line-height: 1.8em;
                                            		font-family: arial;
                                            	}
                                            </style>
                                        	<table style="margin:0 auto; max-width:660px;">
                                        		<thead>
                                        			<tr>
                                        				<th><img src="http://cliente.santistacontroleambiental.com.br/assets/images/santista-controle-ambiental.png" />  </th>
                                        			</tr>
                                        		</thead>
                                        		<tbody>
                                        			<tr>
                                        				<td><p style="padding-bottom:20px; text-align:center;">Ol&aacute;,'. utf8_decode($aUsuario[0]->nome).'</p>
                                            				Seu usu&aacute;rio foi <strong>aprovado</strong> para acessar o sistema, abaixo suas credenciais:.<br>
                                                            <p><strong>Email: </strong>'.$aUsuario[0]->email.'</p>
                                                            <p><strong>Senha: </strong>'.$aUsuario[0]->senha.'</p>
                                        				</td>
                                        			</tr>
                                        			<tr>
                                        				<td>
                                        				</td>
                                        			</tr>
                                        		</tbody>
                                        	</table>
                                           </body>
                                        </html>';

            $mail->send();

            // Limpa os destinat�rios e os anexos
            $mail->ClearAllRecipients();
            $mail->ClearAttachments();

            $message[] = 'Usu&aacute;rio aprovado com sucesso!';
            $code = 200;
            $redirect = '/aprovacoes/usuarios';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }

    public function reprovar(Request $request)
    {
        $input = $request->all();

        $results = DB::table('usuario')
        ->where('id', $input['id'])
        ->update(['status' => '2']);

        $aUsuario =  DB::select("SELECT * FROM usuario WHERE usuario.id = '" . $input['id'] . "'");
        $mail     = new PHPMailer\PHPMailer();

        if(!empty($aUsuario))
        {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.kinghost.net';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = "noreply@santistacontroleambiental.com.br";
            $mail->Password = "WMorais@20";

            //Recipients
            $mail->setFrom('noreply@santistacontroleambiental.com.br', 'Santista Sistema');
            $mail->addAddress($aUsuario[0]->email, utf8_decode($aUsuario[0]->nome));

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Aprova��o de Usu�rio';
            $mail->Body    = '<html>
                                        <head>
                                        	<meta charset="utf-8"/>
                                        	<meta http-equiv="X-UA-Compatible" content="IE=edge">
                                        	<title>Aprova&ccedil;&atilde;o de Usu&aacute;rio</title>
                                        </head>
                                        <body>
                                            <style>
                                            	* {
                                            		font-size: 14px;
                                            		line-height: 1.8em;
                                            		font-family: arial;
                                            	}
                                            </style>
                                        	<table style="margin:0 auto; max-width:660px;">
                                        		<thead>
                                        			<tr>
                                        				<th><img src="http://cliente.santistacontroleambiental.com.br/assets/images/santista-controle-ambiental.png" />  </th>
                                        			</tr>
                                        		</thead>
                                        		<tbody>
                                        			<tr>
                                        				<td><p style="padding-bottom:20px; text-align:center;">Ol&aacute;,'. utf8_decode($aUsuario[0]->nome).'</p>
                                            				Seu usu&aacute;rio foi <strong>reprovado</strong> para acessar o sistema.<br>
                                        				</td>
                                        			</tr>
                                        			<tr>
                                        				<td>
                                        				</td>
                                        			</tr>
                                        		</tbody>
                                        	</table>
                                           </body>
                                        </html>';

            $mail->send();

            // Limpa os destinat�rios e os anexos
            $mail->ClearAllRecipients();
            $mail->ClearAttachments();

            $message[] = 'Usu&aacute;rio reprovado com sucesso!';
            $code = 200;
            $redirect = '/aprovacoes/usuarios';
        }

        # feedback
        $code = (!empty($code)) ? $code : 200;
        return response(['response' => $message, 'code' => $code, 'redirect' => $redirect]);
    }
}
