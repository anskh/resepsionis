<?php

declare(strict_types=1);

namespace App\Handler;

use Anskh\PhpWeb\Http\Session\FlashMessage;
use Laminas\Diactoros\Response\RedirectResponse;
use Anskh\PhpWeb\Http\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LogoutAction 
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        if(my_app()->user()->isAuthenticated()){
            my_app()->session()->unset(Session::ATTR_USER_ID);
            my_app()->session()->unset(Session::ATTR_USER_HASH);
            my_app()->session()->flash('login_info', 'Selamat telah berhasil keluar.', FlashMessage::SUCCESS);
        }

        return new RedirectResponse(my_route_to('home'));
    }
}