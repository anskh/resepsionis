<?php

declare(strict_types=1);

namespace App\Handler;

use App\Model\LoginForm;
use App\Model\User;
use Core\Config\Constants;
use Core\Http\Session\FlashMessage;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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
                $model = app()->config('application.access_control.' . Constants::ACCESS_MODEL);
                $users = $model::find("email='{$login->email}'", 'id,password,token', 1);
                if($users){
                    $user = $users[0];
                    if(password_verify($login->password, $user['password'])){
                        app()->session()->flash('login_info', 'Selamat telah berhasil masuk.', FlashMessage::SUCCESS);
                        app()->session()->set(Constants::SESSION_ID, $user['id']);
                        $userAgent = $request->getServerParams()['HTTP_USER_AGENT'];
                        $shash = password_hash(sha1($user['password'].$user['token']).':'.$userAgent, Constants::HASHING_ALGORITHM);
                        app()->session()->set(Constants::SESSION_HASH, $shash);

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