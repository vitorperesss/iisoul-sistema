<?php

include(__DIR__ . '../../database/conexao.php');

$acao = base64_decode($_POST['acao']);

switch ($acao) {
    case 'salvar_formulario':
        salvar_formulario($conexao);
        break;

    case 'buscar_dados':
        buscar_dados($conexao);
        break;

    case 'excluir_formulario':
        excluir_formulario($conexao);
        break;
}

function salvar_formulario($conexao)
{

    try {

        define('status', 'status');
        define('msg', 'msg');

        $nome_completo      =  $_POST['nome_completo'];
        $data_nascimento    =  $_POST['data_nascimento'];
        $cpf                =  base64_decode($_POST['cpf']);
        $cpf                =  str_replace('.', '', $cpf);
        $cpf                =  str_replace('-', '', $cpf);
        $rg                 =  $_POST['rg'];
        $rg                 =  str_replace('.', '', $rg);
        $rg                 =  str_replace('-', '', $rg);
        $telefone           =  $_POST['telefone'];
        $telefone           =  str_replace('(', '', $telefone);
        $telefone           =  str_replace(')', '', $telefone);
        $telefone           =  str_replace('-', '', $telefone);
        $telefone           =  str_replace(' ', '', $telefone);
        $celular            =  $_POST['celular'];
        $celular           =  str_replace('(', '', $celular);
        $celular           =  str_replace(')', '', $celular);
        $celular           =  str_replace('-', '', $celular);
        $celular           =  str_replace(' ', '', $celular);
        $email              =  $_POST['email'];
        $logradouro         =  $_POST['logradouro'];
        $bairro             =  $_POST['bairro'];
        $numero             =  $_POST['numero'];
        $complemento        =  $_POST['complemento'];
        $cep                =  $_POST['cep'];
        $cep                =  str_replace('-', '', $cep);
        $sexo               =  $_POST['sexo'];
 
        if($sexo == 'masculino'){
            $sexo = 'M';
        }else{
            $sexo = 'F';
        }

        if ($nome_completo == '') {
            $mensagem =  'Preencha o campo nome completo';
            $resposta = array(status => false, msg => $mensagem);
            return json_encode($resposta);
            exit;
        }
        if ($data_nascimento == '') {
            $mensagem =  'Preencha o campo data de nascimento';
            $resposta = array(status => false, msg => $mensagem);
            return json_encode($resposta);
            exit;
        }
        if ($cpf == '') {
            $mensagem =  'Preencha o campo cpf';
            $resposta = array(status => false, msg => $mensagem);
            return json_encode($resposta);
            exit;
        }
        if ($rg == '') {
            $mensagem =  'Preencha o campo rg';
            $resposta = array(status => false, msg => $mensagem);
            return json_encode($resposta);
            exit;
        }
        if ($telefone == '') {
            $mensagem =  'Preencha o campo telefone';
            $resposta = array(status => false, msg => $mensagem);
            return json_encode($resposta);
            exit;
        }
        if ($celular == '') {
            $mensagem =  'Preencha o campo celular';
            $resposta = array(status => false, msg => $mensagem);
            return json_encode($resposta);
            exit;
        }
        if ($email == '') {
            $mensagem =  'Preencha o campo email';
            $resposta = array(status => false, msg => $mensagem);
            return json_encode($resposta);
            exit;
        }
        if ($logradouro == '') {
            $mensagem =  'Preencha o campo logradouro';
            $resposta = array(status => false, msg => $mensagem);
            return json_encode($resposta);
            exit;
        }
        if ($bairro == '') {
            $mensagem =  'Preencha o campo bairro';
            $resposta = array(status => false, msg => $mensagem);
            return json_encode($resposta);
            exit;
        }
        if ($numero == '') {
            $mensagem =  'Preencha o campo numero';
            $resposta = array(status => false, msg => $mensagem);
            return json_encode($resposta);
            exit;
        }
        if ($cep == '') {
            $mensagem =  'Preencha o campo cep';
            $resposta = array(status => false, msg => $mensagem);
            return json_encode($resposta);
            exit;
        }
        if ($sexo == '') {
            $mensagem =  'Preencha o campo sexo';
            $resposta = array(status => false, msg => $mensagem);
            return json_encode($resposta);
            exit;
        }

        $sql = "INSERT INTO public.cadastro (nome_completo, data_nascimento, cpf, rg, telefone, celular, email, logradouro, bairro, numero, complemento, cep, sexo)
                VALUES ('$nome_completo', '$data_nascimento', '$cpf', '$rg', '$telefone', '$celular', '$email', '$logradouro', '$bairro', '$numero', '$complemento', '$cep', '$sexo')";

        $resultado = mysqli_query($conexao, $sql);

        if ($resultado) {
            $mensagem =  'Cadastro realizado com sucesso';
            $resposta = array(status => true, msg => $mensagem);
        } else {
            $mensagem =  'Erro ao realizar cadastro';
            $resposta =  array(status => false, msg => $mensagem);
        }

        mysqli_close($conexao);
        echo json_encode($resposta);
    } catch (Exception $e) {
        $mensagem =  'Erro ao se comunicar com servidor ' . $e->getMessage();
        $resposta = array(status => false, msg => $mensagem);
        echo json_encode($resposta);
    }
}

function excluir_formulario($conexao)
{

    try {

        define('status', 'status');
        define('msg', 'msg');

        $id = $_POST['id'];

        $sql = "UPDATE public.cadastro SET situacao = 0 WHERE id = '$id'";
        $resultado = mysqli_query($conexao, $sql);

        if ($resultado) {
            $mensagem =  'Excluído com sucesso';
            $resposta = array(status => true, msg => $mensagem);
        } else {
            $mensagem =  'Erro ao Excluir';
            $resposta =  array(status => false, msg => $mensagem);
        }

        mysqli_close($conexao);
        echo json_encode($resposta);

    } catch (Exception $e) {
        $mensagem =  'Erro ao se comunicar com servidor ' . $e->getMessage();
        $resposta = array(status => false, msg => $mensagem);
        echo json_encode($resposta);
    }

}

function buscar_dados($conexao)
{
    try {

        define('status', 'status');
        define('msg', 'msg');
        define('row', 'row');

        $sql = "SELECT * FROM public.cadastro WHERE situacao = 1";
        $resultado = mysqli_query($conexao, $sql);
        $row = mysqli_fetch_all($resultado, MYSQLI_ASSOC); 

        for ($i = 0; $i < count($row); $i++) {
            $row[$i]['data_nascimento'] = date('d/m/Y', strtotime($row[$i]['data_nascimento']));
            $row[$i]['telefone']        = '(' . substr($row[$i]['telefone'], 0, 2) . ') ' . substr($row[$i]['telefone'], 2, 4) . '-' . substr($row[$i]['telefone'], 6, 4);
            $row[$i]['celular']         = '(' . substr($row[$i]['celular'], 0, 2) . ') ' . substr($row[$i]['celular'], 2, 5) . '-' . substr($row[$i]['celular'], 7, 4);
            $row[$i]['cep']             = substr($row[$i]['cep'], 0, 5) . '' . substr($row[$i]['cep'], 5, 3);
            $row[$i]['sexo']            = $row[$i]['sexo'] == 'M' ? 'Masculino' : 'Feminino';
            $row[$i]['cpf']             = substr($row[$i]['cpf'], 0, 3) . '.' . substr($row[$i]['cpf'], 3, 3) . '.' . substr($row[$i]['cpf'], 6, 3) . '-' . substr($row[$i]['cpf'], 9, 2);
            $row[$i]['rg']              = substr($row[$i]['rg'], 0, 2) . '.' . substr($row[$i]['rg'], 2, 3) . '.' . substr($row[$i]['rg'], 5, 3) . '-' . substr($row[$i]['rg'], 8, 1);
            $row[$i]['acao']            = create_acao($row[$i]['id_cadastro']);
        }

        if ($resultado) {
            $resposta = array(status => true, row => $row);
        } else {
            $mensagem =  'Erro ao buscar dados';
            $resposta =  array(status => false, row => '', msg => $mensagem);
        }

        mysqli_close($conexao);
        echo json_encode($resposta);

    } catch (Exception $e) {
        $mensagem =  'Erro ao se comunicar com servidor ' . $e->getMessage();
        $resposta = array(status => false, msg => $mensagem);
        echo json_encode($resposta);
    }
}

function create_acao($id)
{
    ob_start(); ?>

    <button type="button" class="btn btn-outline-dark" onClick="editar_formulario('<?= $id ?>')">
        <i class="bi bi-pencil"></i>
    </button> 
    <button type="button" class="btn btn-outline-dark" onClick="excluir_formulario('<?= $id ?>')">
        <i class="bi bi-trash3"></i>
    </button> 
   
    <?php return ob_get_clean();

}



