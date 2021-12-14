<?php

declare(strict_types=1);

namespace App\Handler;

use App\Model\LoginForm;
use PhpWeb\Http\Session\FlashMessage;
use Laminas\Diactoros\Response\RedirectResponse;
use PhpWeb\Config\Config;
use PhpWeb\Http\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function PhpWeb\app;
use function PhpWeb\route_to;
use function PhpWeb\view;

class LoginAction 
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        if(app()->user()->isAuthenticated()){
            return new RedirectResponse(route_to('home'));
        }

        $login = new LoginForm();
        
        if($request->getMethod() === 'POST'){
            if($login->validateWithRequest($request)){
                $key = Config::ATTR_APP_CONFIG . '.' . Config::ATTR_APP_ACCESSCONTROL . '.' . Config::ATTR_ACCESSCONTROL_USERMODEL;
                $model = app()->config($key);
                $users = $model::find("email='{$login->email}'", 'id,password,token', 1);
                if($users){
                    $user = $users[0];
                    if(password_verify($login->password, $user['password'])){
                        app()->session()->flash('login_info', 'Selamat telah berhasil masuk.', FlashMessage::SUCCESS);
                        app()->session()->set(Session::ATTR_SESSION_ID, $user['id']);
                        $userAgent = $request->getServerParams()['HTTP_USER_AGENT'];
                        $shash = password_hash(sha1($user['password'].$user['token']).':'.$userAgent, Config::HASHING_ALGORITHM);
                        app()->session()->set(Session::ATTR_SESSION_HASH, $shash);

                        return new RedirectResponse(route_to('admin'));
                    }else{
                        $login->addError('form', 'Alamat email atau kata sandi tidak valid.');
                    }
                }else{
                    $login->addError('form', 'Pengguna tidak ditemukan.');
                }
            }
        }

        return view('login', $response, 'main', [
            'title' => 'Resepsionis BPS',
            'login' => $login
        ]);
    }
}