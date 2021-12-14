<?php

declare(strict_types=1);

namespace App\Handler;

use App\Model\Guest;
use App\Model\NewGuestForm;
use PhpWeb\Http\Session\FlashMessage;
use PhpWeb\Model\FormModel;
use Laminas\Diactoros\Response\RedirectResponse;
use PhpWeb\Config\Config;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function PhpWeb\view;
use function PhpWeb\route_to;
use function PhpWeb\app;
use function App\base64_photo;
use function App\save_base64_photo;

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
                'script' => "$('#guesttable').DataTable({\"order\":[5,'desc']});"
            ]
        ]);
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new NewGuestForm();
        $rules = [
            'nama' => [FormModel::ATTR_RULE_REQUIRED, [FormModel::ATTR_RULE_MIN_LENGTH, 3]],
            'asal' => [FormModel::ATTR_RULE_REQUIRED, [FormModel::ATTR_RULE_MIN_LENGTH, 3]],
            'keperluan' => [FormModel::ATTR_RULE_REQUIRED, [FormModel::ATTR_RULE_MIN_LENGTH, 4]],
            'hp' => [FormModel::ATTR_RULE_REQUIRED, [FormModel::ATTR_RULE_MIN_LENGTH , 10], [FormModel::ATTR_RULE_MAX_LENGTH, 15], FormModel::ATTR_RULE_NUMERIC],
            'create_guest_csrf'=> FormModel::ATTR_RULE_CSRF
        ];
        $labels = [
            'nama' => 'Nama Pengunjung <span class="text-danger">*</span>',
            'asal' => 'Asal Kementerian/Lembaga/Instansi/Sekolah/Daerah <span class="text-danger">*</span>',
            'keperluan' => 'Keperluan Kunjungan <span class="text-danger">*</span>',
            'email' => 'Alamat email',
            'hp' => 'Nomor HP <span class="text-danger">*</span>',
            'foto' => 'Identitas foto pengunjung'
        ];

        $allow_no_photo = app()->config(Config::ATTR_APP_CONFIG . '.config.guest.allow_no_photo', false);

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

                if($model->hasError()){
                    app()->session()->flash('app_info', 'Terdapat isian yang masih belum valid', FlashMessage::ERROR);
                }else{
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
            }else{
                app()->session()->flash('app_info', 'Terdapat isian yang masih belum valid', FlashMessage::ERROR);
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
            'guest' => Guest::getRow($id)
        ]);
    }
}
