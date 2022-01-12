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
use Anskh\PhpWeb\Http\Session\FlashMessage;
use Anskh\PhpWeb\Http\Session\Session;
use Anskh\PhpWeb\Model\FormModel;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminController 
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        return my_view('admin', $response, 'layout/admin', [
            'title' => 'Halaman Administrasi'
        ]);
    }

    public function listGuest(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return my_view('admin_list_guest', $response, 'layout/admin', [
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
        return my_view('admin_list_user', $response, 'layout/admin', [
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
                'script' => "$('#usertable').DataTable({\"order\": [0,'asc']});"
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
                    'password'=>password_hash($model->password, PASSWORD_BCRYPT) ,
                    'token'=>Session::generateToken(),
                    'roles'=>$model->roles,
                    'create_at'=>time()
                ]) > 0){
                    my_app()->session()->flash('add_user', 'Data berhasil ditambahkan', FlashMessage::SUCCESS);
                }else{
                    my_app()->session()->flash('add_user', 'Data gagal ditambahkan', FlashMessage::ERROR);
                }
                
                return new RedirectResponse(my_route_to('admin_list_user'));
            }else{
                my_app()->session()->flash('add_user', 'Terdapat isian yang belum valid', FlashMessage::ERROR);
            }
        }

        return my_view('admin_create_user', $response, 'layout/admin', [
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
            'roles' => [FormModel::ATTR_RULE_REQUIRED, [FormModel::ATTR_RULE_IN_LIST, 'user','admin','user|admin','admin|user']],
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
                    my_app()->session()->flash('update_user', 'Ubah data berhasil.', FlashMessage::SUCCESS);
                }else{
                    my_app()->session()->flash('update_user', 'Tidak ada perubahan data.', FlashMessage::INFO);
                }
                
                return new RedirectResponse(my_route_to('admin_list_user'));
            }else{
                my_app()->session()->flash('update_user', 'Terdapat isian yang belum valid', FlashMessage::ERROR);
            }
        }

        return my_view('admin_edit_user', $response, 'layout/admin', [
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

                my_app()->session()->flash('delete_user', 'Hapus data berhasil.', FlashMessage::SUCCESS);

                return $response;
            }
        }

        $response->getBody()->write('ERROR');

        my_app()->session()->flash('delete_user', 'Hapus data gagal.', FlashMessage::ERROR);

        return $response;
    }

    public function listSurvey(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return my_view('admin_list_survey', $response, 'layout/admin', [
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

                my_app()->session()->flash('delete_survey', 'Hapus data berhasil.', FlashMessage::SUCCESS);

                return $response;
            }
        }

        $response->getBody()->write('ERROR');

        my_app()->session()->flash('delete_survey', 'Hapus data gagal.', FlashMessage::ERROR);

        return $response;
    }

    public function viewGuest(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');

        return my_view('admin_view_guest', $response, 'layout/admin', [
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
                    'email'=>$model->email ?? null,
                    'hp'=>$model->hp
                ], ['id =' => $id]) > 0){
                    my_app()->session()->flashSuccess('update_guest', 'Ubah data berhasil.');
                }else{
                    my_app()->session()->flash('update_guest', 'Tidak ada perubahan data.');
                }
                
                return new RedirectResponse(my_route_to('admin_list_guest'));
            }else{
                my_app()->session()->flashError('update_guest', 'Terdapat isian yang belum valid.');
            }
        }

        return my_view('admin_edit_guest', $response, 'layout/admin', [
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
                    my_app()->session()->flashSuccess('add_guest', 'Data berhasil ditambahkan');
                }else{
                    my_app()->session()->flashError('add_guest', 'Data gagal ditambahkan');
                }
                
                return new RedirectResponse(my_route_to('admin_list_guest'));
            }else{
                my_app()->session()->flashError('add_guest', 'Terdapat isian yang belum valid.');
            }
        }

        return my_view('admin_create_guest', $response, 'layout/admin', [
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

                my_app()->session()->flashSuccess('delete_guest', 'Hapus data berhasil.');

                return $response;
            }
        }

        $response->getBody()->write('ERROR');

        my_app()->session()->flashError('delete_guest', 'Hapus data gagal.');

        return $response;
    }
}