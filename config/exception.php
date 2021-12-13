<?php

declare(strict_types=1);

use Core\Http\Session\FlashMessage;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;

return [
    // callable when unauthorized
    'unauthorized' => function(int $status = 401): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write('Maaf, halaman tidak tersedia untuk Anda.');

        return $response->withStatus($status);
    },
    
    // callable when forbidden
    'forbidden' => function(int $status = 302): ResponseInterface
    {
        app()->session()->flash('forbidden_info', 'Perlu otentikasi untuk mengakses halaman tersebut.', FlashMessage::ERROR);
        
        return new RedirectResponse(route_to('login'), $status);
    },

    // callable when notfound
    'notfound' => function(): ResponseInterface
    {
        app()->session()->flash('notfound_info', 'Halaman yang dituju tidak ditemukan.', FlashMessage::ERROR);
        
        return view('notfound', new Response(), 'error');
    }

    // callable when error
    //'throwable' => static function(Throwable $exception){
    //    return view('error500', null, 'main', ['title'=>'Resepsionis BPS - Kesalahan 500', 'exception'=>$exception]);
    //},
];