<?php

namespace Delivery\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //SE NAO ESTIVER AUTORIZADO REDIRECIONA PARA LOGIN
        if(!Auth::check()){
            return redirect('/auth/login');
        }
        //SE A ROLE FOR DIFERENTE DA ROLE DO USUARIO LOGADO REDIRECIONA PARA O LOGIN
        if(Auth::user()->role <> 'admin'){
            return redirect('/auth/login');
        }
        //SE PASSAR PELAS ETAPAS ANTERIORES ELE CONTINUA O PROCESSO
        return $next($request);
    }
}
