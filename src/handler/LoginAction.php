<?php

declare(strict_types=1);

namespace App\Handler;

use Anskh\PhpWeb\Http\App;
use App\Model\LoginForm;
use Laminas\Diactoros\Response\RedirectResponse;
use Anskh\PhpWeb\Http\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginAction 
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        if(my_app()->user()->isAuthenticated()){
            return new RedirectResponse(my_route_to('home'));
        }

        $login = new LoginForm();
        
        if($request->getMethod() === 'POST'){
            if($login->validateWithRequest($request)){
                $model = my_app()->getAttribute(App::ATTR_USER_MODEL);
                $users = $model::find("email='{$login->email}'", 'id,password,token', 1);
                if($users){
                    $user = $users[0];
                    if(password_verify($login->password, $user['password'])){
                        my_app()->session()->flashSuccess('login_info', 'Selamat telah berhasil masuk.');
                        my_app()->session()->set(Session::ATTR_USER_ID, $user['id']);
                        $userAgent = $request->getServerParams()['HTTP_USER_AGENT'];
                        $shash = password_hash(sha1($user['password'].$user['token']).':'.$userAgent, PASSWORD_BCRYPT);
                        my_app()->session()->set(Session::ATTR_USER_HASH, $shash);

                        return new RedirectResponse(my_route_to('admin'));
                    }else{
                        $login->addError('form', 'Alamat email atau kata sandi tidak valid.');
                    }
                }else{
                    $login->addError('form', 'Pengguna tidak ditemukan.');
                }
            }
        }

        return my_view('login', $response, 'layout/main', [
            'title' => 'Resepsionis BPS',
            'login' => $login
        ]);
    }
}