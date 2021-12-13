<?php

declare(strict_types=1);

namespace App;

use Laminas\Diactoros\Response;
use PhpWeb\Config\Config;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\PhpRenderer;

use function PhpWeb\app;

if(!function_exists('App\view')){
    function view(string $view, string $layout = '', array $data = [], ?ResponseInterface $response = null, int $status = 200): ResponseInterface
    {
        $response = $response ?? new Response();
        $config = app()->config(Config::ATTR_APP_CONFIG . '.' . Config::ATTR_APP_VIEW);
        $view .= $config[Config::ATTR_VIEW_FILE_EXT];
        if (!empty($layout)) {
            $layout = 'layout/' . $layout . $config[Config::ATTR_VIEW_FILE_EXT];
        }
        $renderer = new PhpRenderer($config[Config::ATTR_VIEW_PATH], $data, $layout);
        $renderer->render($response, $view);

        return $response->withStatus($status);
    }
}