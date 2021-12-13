<?php

declare(strict_types=1);

namespace App\Handler;

use App\Model\Guest;
use App\Model\NewGuestForm;
use Core\Http\Session\FlashMessage;
use Core\Model\FormModel;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GuestController
{
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return view('list_guest', $response, 'main', [
            'title' => 'Bukutamu BPS',
            'data' => Guest::all('id,nama,asal,keperluan,email,hp,tanggal', 0, 'tanggal DESC'),
            'assets' => [
                'css' => [
                    'css/dataTables.bootstrap4.min.css'
                ],
                'js' => [
                    'js/jquery.dataTables.min.js',
                    'js/dataTables.bootstrap4.min.js'
                ],
                'script' => "$('#guesttable').DataTable();"
            ]
        ]);
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new NewGuestForm();
        $rules = [
            'nama' => [FormModel::RULE_REQUIRED, [FormModel::RULE_MIN_LENGTH, 3]],
            'asal' => [FormModel::RULE_REQUIRED, [FormModel::RULE_MIN_LENGTH, 3]],
            'keperluan' => [FormModel::RULE_REQUIRED, [FormModel::RULE_MIN_LENGTH, 4]],
            'hp' => [FormModel::RULE_REQUIRED, [FormModel::RULE_MIN_LENGTH , 10], [FormModel::RULE_MAX_LENGTH, 15], FormModel::RULE_NUMERIC],
            'create_guest_csrf'=> FormModel::RULE_CSRF
        ];
        $labels = [
            'nama' => 'Nama Pengunjung <span class="text-danger">*</span>',
            'asal' => 'Asal Kementerian/Lembaga/Instansi/Sekolah/Daerah <span class="text-danger">*</span>',
            'keperluan' => 'Keperluan Kunjungan <span class="text-danger">*</span>',
            'email' => 'Alamat email',
            'hp' => 'Nomor HP <span class="text-danger">*</span>',
            'foto' => 'Identitas foto pengunjung'
        ];

        $allow_no_photo = app()->config('application.config.guest.allow_no_photo', false);

        if($allow_no_photo === false){
            $labels['foto'] = 'Identitas foto pengunjung <span class="text-danger">*</span>';
        }

        $model->setRules($rules);
        $model->setLabels($labels);

        if ($request->getMethod() === 'POST') {
            if ($model->validateWithRequest($request)) {
                $filename = null;
                if($allow_no_photo === false){
                    if(empty($model->foto)){
                        $model->addError('form', 'Atribut foto wajib diisi.');
                    }else{
                        $filename = save_base64_photo($model->foto);
                    }
                }

                if(!$model->hasError()){
                    Guest::create([
                        'nama'=>$model->nama,
                        'asal'=>$model->asal,
                        'keperluan'=>$model->keperluan,
                        'email'=> empty($model->email) ? null : $model->email,
                        'hp'=>$model->hp,
                        'foto'=> $filename,
                        'tanggal' => time()
                    ]);
                    app()->session()->flash('app_info', 'Data berhasil disimpan', FlashMessage::SUCCESS);

                    return new RedirectResponse(route_to('list_guest'));
                }
            }
        }

        if(empty($model->foto)){
            $model->foto = base64_photo('nophoto.png');
        }

        return view('create_guest', $response, 'main', [
            'title' => 'Bukutamu BPS',
            'model' => $model,
            'assets' => [
                'js' => [
                    'js/webcam-easy.min.js',
                    'js/create_guest.js'
                ],
                'css'=>['css/bootstrap4-modal-fullscreen.css'],
                'script'=>'init_webcam();'
            ]
        ]);
    }

    public function view(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request->getAttribute('id');

        return view('view_guest', $response, 'main', [
            'title' => 'Bukutamu BPS',
            'guest' => Guest::get($id)
        ]);
    }
}