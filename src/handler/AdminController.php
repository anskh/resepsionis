<?php

declare(strict_types=1);

namespace App\Handler;

use App\Model\EditGuestFormAdmin;
use App\Model\EditUserForm;
use App\Model\Guest;
use App\Model\NewGuestFormAdmin;
use App\Model\Survey;
use App\Model\User;
use App\Model\UserForm;
use PhpWeb\Http\Session\FlashMessage;
use PhpWeb\Http\Session\Session;
use PhpWeb\Model\FormModel;
use Laminas\Diactoros\Response\RedirectResponse;
use PhpWeb\Config\Config;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function PhpWeb\view;
use function PhpWeb\app;
use function PhpWeb\route_to;

class AdminController 
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        return view('admin', $response, 'admin', [
            'title' => 'Halaman Administrasi'
        ]);
    }

    public function listGuest(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return view('admin_list_guest', $response, 'admin', [
            'title' => 'Halaman Administrasi Tamu',
            'data' => Guest::all('id,nama,asal,keperluan,email,hp,tanggal'),
            'assets' => [
                'css' => [
                    'css/dataTables.bootstrap4.min.css'
                ],
                'js' => [
                    'js/jquery.dataTables.min.js',
                    'js/dataTables.bootstrap4.min.js',
                    'js/delete.js'
                ],
                'script' => "$('#guesttable').DataTable();"
            ]
        ]);
    }

    public function listUser(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return view('admin_list_user', $response, 'admin', [
            'title' => 'Halaman Administrasi Pengguna',
            'data'=>User::all(),
            'assets' => [
                'css' => [
                    'css/dataTables.bootstrap4.min.css'
                ],
                'js' => [
                    'js/jquery.dataTables.min.js',
                    'js/dataTables.bootstrap4.min.js',
                    'js/delete.js'
                ],
                'script' => "$('#usertable').DataTable();"
            ]
        ]);
    }

    public function createUser(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new UserForm();

        if($request->getMethod()==='POST'){
            if($model->validateWithRequest($request)){
                if(User::create([
                    'name'=>$model->name,
                    'email'=>$model->email,
                    'password'=>password_hash($model->password, Config::HASHING_ALGORITHM) ,
                    'token'=>Session::generateToken(),
                    'roles'=>$model->roles,
                    'create_at'=>time()
                ]) > 0){
                    app()->session()->flash('add_user', 'Data berhasil ditambahkan', FlashMessage::SUCCESS);
                }else{
                    app()->session()->flash('add_user', 'Data gagal ditambahkan', FlashMessage::ERROR);
                }
                
                return new RedirectResponse(route_to('admin_list_user'));
            }
        }

        return view('admin_create_user', $response, 'admin', [
            'title' => 'Halaman Tambah pengguna',
            'model'=>$model
        ]);
    }

    public function editUser(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $model = new EditUserForm();
        $model->fill(User::getRow($id));

        $rules = [
            'name' => [FormModel::ATTR_RULE_REQUIRED, [FormModel::ATTR_RULE_MIN_LENGTH, 3]],
            'email' => [FormModel::ATTR_RULE_EMAIL,[FormModel::ATTR_RULE_UNIQUE, 'user', 'email', $model->email]],
            'roles' => [FormModel::ATTR_RULE_REQUIRED, [FormModel::ATTR_RULE_IN_LIST, ['user','admin','user|admin','admin|user']]],
            'user_csrf' => FormModel::ATTR_RULE_CSRF
        ];

        $model->setRules($rules);

        if($request->getMethod() === 'POST'){
            if($model->validateWithRequest($request)){
                if(User::update([
                    'name'=>$model->name,
                    'email'=>$model->email,
                    'roles'=>$model->roles,
                    'update_at'=> time()
                ], ['id =' => $id]) > 0){
                    app()->session()->flash('update_user', 'Ubah data berhasil.', FlashMessage::SUCCESS);
                }else{
                    app()->session()->flash('update_user', 'Tidak ada perubahan data.', FlashMessage::INFO);
                }
                
                return new RedirectResponse(route_to('admin_list_user'));
            }
        }

        return view('admin_edit_user', $response, 'admin', [
            'title' => 'Halaman Ubah Data Pengguna',
            'model'=>$model
        ]);
    }

    public function removeUser(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');

        if($request->getMethod() === 'POST'){

            if( User::delete(['id ='=>$id]) > 0)
            {

                $response->getBody()->write('OK');

                app()->session()->flash('delete_user', 'Hapus data berhasil.', FlashMessage::SUCCESS);

                return $response;
            }
        }

        $response->getBody()->write('ERROR');

        app()->session()->flash('delete_user', 'Hapus data gagal.', FlashMessage::ERROR);

        return $response;
    }

    public function listSurvey(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return view('admin_list_survey', $response, 'admin', [
            'title' => 'Halaman Administrasi Survei Kepuasan',
            'data' => Survey::all(),
            'assets' => [
                'css' => [
                    'css/dataTables.bootstrap4.min.css'
                ],
                'js' => [
                    'js/jquery.dataTables.min.js',
                    'js/dataTables.bootstrap4.min.js',
                    'js/delete.js'
                ],
                'script' => "$('#surveytable').DataTable();"
            ]

        ]);
    }

    public function removeSurvey(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');

        if($request->getMethod() === 'POST'){

            if( Survey::delete(['id ='=>$id]) > 0)
            {

                $response->getBody()->write('OK');

                app()->session()->flash('delete_survey', 'Hapus data berhasil.', FlashMessage::SUCCESS);

                return $response;
            }
        }

        $response->getBody()->write('ERROR');

        app()->session()->flash('delete_survey', 'Hapus data gagal.', FlashMessage::ERROR);

        return $response;
    }

    public function viewGuest(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');

        return view('admin_view_guest', $response, 'admin', [
            'title' => 'Halaman Administrasi Survei Kepuasan',
            'guest'=> Guest::getRow($id)
        ]);
    }

    public function editGuest(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $model = new EditGuestFormAdmin();
        $model->fill(Guest::getRow($id));

        if($request->getMethod() === 'POST'){
            if($model->validateWithRequest($request)){
                if(Guest::update([
                    'nama'=>$model->nama,
                    'asal'=>$model->asal,
                    'keperluan'=>$model->keperluan,
                    'email'=>$model->email?? null,
                    'hp'=>$model->hp
                ], ['id =' => $id]) > 0){
                    app()->session()->flash('update_guest', 'Ubah data berhasil.', FlashMessage::SUCCESS);
                }else{
                    app()->session()->flash('update_guest', 'Tidak ada perubahan data.', FlashMessage::INFO);
                }
                
                return new RedirectResponse(route_to('admin_list_guest'));
            }
        }

        return view('admin_edit_guest', $response, 'admin', [
            'title' => 'Halaman Administrasi Survei Kepuasan',
            'model'=>$model
        ]);
    }

    public function createGuest(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $model = new NewGuestFormAdmin();

        $model->tanggal= date('Y-m-d');

        if($request->getMethod()==='POST'){
            if($model->validateWithRequest($request)){
                if(Guest::create([
                    'nama'=>$model->nama,
                    'asal'=>$model->asal,
                    'keperluan'=>$model->keperluan,
                    'email'=>empty($model->email)? null: $model->email,
                    'hp'=>$model->hp,
                    'tanggal'=>strtotime($model->tanggal)
                ]) > 0){
                    app()->session()->flash('add_guest', 'Data berhasil ditambahkan', FlashMessage::SUCCESS);
                }else{
                    app()->session()->flash('add_guest', 'Data gagal ditambahkan', FlashMessage::ERROR);
                }
                
                return new RedirectResponse(route_to('admin_list_guest'));
            }
        }

        return view('admin_create_guest', $response, 'admin', [
            'title' => 'Halaman Administrasi Survei Kepuasan',
            'guest'=> Guest::getRow($id),
            'model'=>$model
        ]);
    }

    public function removeGuest(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');

        if($request->getMethod() === 'POST'){

            if( Guest::delete(['id ='=>$id]) > 0)
            {

                $response->getBody()->write('OK');

                app()->session()->flash('delete_guest', 'Hapus data berhasil.', FlashMessage::SUCCESS);

                return $response;
            }
        }

        $response->getBody()->write('ERROR');

        app()->session()->flash('delete_guest', 'Hapus data gagal.', FlashMessage::ERROR);

        return $response;
    }
}