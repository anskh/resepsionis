<?php

declare(strict_types=1);

use PhpWeb\Http\Session\FlashMessage;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use PhpWeb\Config\Config;
use Psr\Http\Message\ResponseInterface;

use function PhpWeb\app;
use function PhpWeb\view;
use function PhpWeb\route_to;

return [
    // callable when unauthorized
    Config::ATTR_EXCEPTION_UNAUTHORIZED => function(int $status = 401): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write('Maaf, halaman tidak tersedia untuk Anda.');

        return $response->withStatus($status);
    },
    
    // callable when forbidden
    Config::ATTR_EXCEPTION_FORBIDDEN => function(int $status = 302): ResponseInterface
    {
        app()->session()->flash('forbidden_info', 'Perlu otentikasi untuk mengakses halaman tersebut.', FlashMessage::ERROR);
        
        return new RedirectResponse(route_to('login'), $status);
    },

    // callable when notfound
    Config::ATTR_EXCEPTION_NOTFOUND => function(): ResponseInterface
    {
        app()->session()->flash('notfound_info', 'Halaman yang dituju tidak ditemukan.', FlashMessage::ERROR);
        
        return view('notfound', new Response(), 'error');
    },

    Config::ATTR_EXCEPTION_LOG => [
        Config::ATTR_EXCEPTION_LOG_NAME => 'app',
        Config::ATTR_EXCEPTION_LOG_FILE => ROOT . '/writeable/log/app.log'
    ]

    // callable when error
    //Config::ATTR_EXCEPTION_THROWABLE => static function(Throwable $exception){
    //    return view('error500', null, 'main', ['title'=>'Resepsionis BPS - Kesalahan 500', 'exception'=>$exception]);
    //},
];