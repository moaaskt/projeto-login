<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ForcePasswordChange implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Se o usuário não está logado ou não é um cliente, o filtro não faz nada
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'cliente') {
            return;
        }

        // Verifica a flag que exige a troca de senha
        if ($session->get('senha_requer_troca') == 1) {
            // Permite o acesso apenas à página de perfil/troca de senha e ao logout
            if (!url_is('cliente/perfil*') && !url_is('logout')) {
                return redirect()->to('/cliente/perfil')
                                 ->with('info', 'Por segurança, você precisa atualizar sua senha temporária antes de continuar.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Não é necessário implementar nada aqui para este caso
    }
}