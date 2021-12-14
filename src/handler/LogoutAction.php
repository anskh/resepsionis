<?php

declare(strict_types=1);

namespace App\Handler;

use PhpWeb\Http\Session\FlashMessage;
use Laminas\Diactoros\Response\RedirectResponse;
use PhpWeb\Http\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function PhpWeb\app;
use function PhpWeb\route_to;

class LogoutAction 
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        if(app()->user()->isAuthenticated()){
            app()->session()->unset(Session::ATTR_SESSION_ID);
            app()->session()->unset(Session::ATTR_SESSION_HASH);
            app()->session()->flash('login_info', 'Selamat telah berhasil keluar.', FlashMessage::SUCCESS);
        }

        return new RedirectResponse(route_to('home'));
    }
}