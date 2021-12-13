<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController 
{
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return view('home', $response, 'main', [
            'title' => 'Resepsionis BPS'
        ]);
    }
}