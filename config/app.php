<?php

declare(strict_types=1);

use Anskh\PhpWeb\Http\App;
use App\Model\User;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;

return [
    App::ATTR_NAME => 'Resepsionis BPS',
    App::ATTR_VERSION => '1.0',
    App::ATTR_VENDOR => 'BPS Kabupaten Rokan Hulu',
    App::ATTR_VIEW_PATH => ROOT . '/src/view',
    App::ATTR_VIEW_EXT => '.phtml',
    App::ATTR_BASEURL => 'http://localhost/resepsionis',
    App::ATTR_BASEPATH => '/resepsionis',
    App::ATTR_DEFAULT_CONNECTION => 'mysql',
    App::ATTR_USER_MODEL=> User::class,
    App::ATTR_UNAUTHORIZED => static function(int $status = 401): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write('Maaf, halaman tidak tersedia untuk Anda.');

        return $response->withStatus($status);
    },
    App::ATTR_FORBIDDEN => static function(int $status = 302): ResponseInterface
    {
        my_app()->session()->flashError('forbidden_info', 'Perlu otentikasi untuk mengakses halaman tersebut.');
        
        return new RedirectResponse(my_route_to('login'), $status);
    }
];
