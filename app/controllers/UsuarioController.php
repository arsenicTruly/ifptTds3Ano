<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Usuario;
use app\services\UsuarioService;
use app\helpers\Validador;

class UsuarioController extends Controller
{
    private UsuarioService $service;
    private Validador $validador;

    public function __construct() {
        $this->service = new UsuarioService();
        $this->validador = new Validador;
    }

    public function index() {
        $data['usuarios'] = $this->service->getUsuarios();
        $this->view('usuarios/usuario_list', $data);
    }

    public function cadastrar() {
        $this->view('usuarios/usuario_create');
    }

    public function salvar() {

        //sanitizar
        $nomeUsuario = filter_input(INPUT_POST, 'nomeUsuario', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $perfil = $_POST['perfil'];

        //validar 
        $this->validador->obrigatorio('nomeUsuario', $nomeUsuario);
        $this->validador->obrigatorio('email', $email);

        if($this->validador->temErros()){
            $data['usuario'] = $_POST;
            $data["erros"]=$this->validador->getErros();

            $this->view('usuarios/usuario_create', $data);
            return;
        }

        //salvar
        $usuario = new Usuario(
            0, 
            $nomeUsuario, 
            $email, 
            $senha, 
            $perfil
        );

        if ($this->service->saveUsuario($usuario)) {
            $this->redirect(URL_BASE . '/usuarios');
        } else {
            // TODO Aqui você poderia passar uma mensagem de erro para a view
            echo "Erro: Este e-mail já está cadastrado!";
        }
    }

    public function editar() {
        $id = $_GET['id'];
        $data['usuario'] = $this->service->getUsuarioById($id);
        $this->view('usuarios/usuario_edit', $data);
    }

    public function atualizar() {
        $usuario = new Usuario(
            $_POST['id'], 
            $_POST['nomeUsuario'], 
            $_POST['email'], 
            $_POST['senha'] ?? '', 
            $_POST['perfil']
        );
        $this->service->updateUsuario($usuario);
        $this->redirect(URL_BASE . '/usuarios');
    }

    public function excluir() {
        $id = $_GET['id'];
        $this->service->deleteUsuario($id);
        $this->redirect(URL_BASE . '/usuarios');
    }
}