<?php

namespace Delivery\Http\Middleware;

use Closure;
use Delivery\Repositories\UserRepository;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class OAuthCheckRole
{
    private $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }


    public function handle($request, Closure $next, $role)
    {
        //PEGA ID DO USUARIO AUTENTICADO COM AUTH2
        $id = Authorizer::getResourceOwnerId();
        //PEGA OS DADOS DO USUARIO
        $user = $this->userRepository->find($id);
        //dd($user);
        if ($user->role != $role) {
            abort(403,'Access Forbidden');
        }


        //SE PASSAR PELAS ETAPAS ANTERIORES ELE CONTINUA O PROCESSO
        return $next($request);
    }
}
