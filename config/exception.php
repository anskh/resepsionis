<?php

declare(strict_types=1);

use Anskh\PhpWeb\Http\Session\FlashMessage;
use Anskh\PhpWeb\Http\AppException;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;

return [
    // callable when notfound
    AppException::ATTR_NOTFOUND => static function(): ResponseInterface
    {
        my_app()->session()->flash('notfound_info', 'Halaman yang dituju tidak ditemukan.', FlashMessage::ERROR);
        
        return my_view('notfound', new Response(), 'layout/error');
    },

    AppException::ATTR_LOG_ENABLE => true,
    AppException::ATTR_LOG_NAME => 'app',
    AppException::ATTR_LOG_FILE => ROOT . '/writeable/log/app.log',

    // callable when error
    AppException::ATTR_THROWABLE => null
];