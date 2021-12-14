<?php

declare(strict_types=1);

namespace App\Handler;

use App\Model\Survey;
use App\Model\SurveyForm;
use PhpWeb\Http\Session\FlashMessage;
use Laminas\Diactoros\Response\RedirectResponse;
use PhpWeb\Config\Config;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function PhpWeb\app;
use function PhpWeb\view;
use function PhpWeb\route_to;

class SurveyController
{
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        app()->session()->set('survey_token', app()->config(Config::ATTR_APP_CONFIG . '.config.survey.token'));

        return view('create_survey', $response, 'main', [
            'title' => 'Isi Survei Kepuasan Konsumen BPS',
            'assets' => [
                'style' => '.btn-sq-lg {
                    width: 150px !important;
                    height: 150px !important;
                    margin:10px;
                  }'
            ]
        ]);
    }
    public function sangat(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $token = app()->session()->unset('survey_token');
        if ($token === app()->config(Config::ATTR_APP_CONFIG . '.config.survey.token')) {
            //simpan
            Survey::create([
                'selected' => 4,
                'feedback' => null,
                'create_at' => time()
            ]);

            app()->session()->flash('feedback_info', 'Terimakasih atas penilaian yang diberikan.', FlashMessage::SUCCESS);

            return new RedirectResponse(route_to('home'));
        }else{
            app()->session()->flash('feedback_info', 'Token survei tidak valid.', FlashMessage::ERROR);
        }

        return new RedirectResponse(route_to('create_survey'));
    }
    public function puas(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $token = app()->session()->unset('survey_token');
        if ($token === app()->config(Config::ATTR_APP_CONFIG . '.config.survey.token')) {
            //simpan
            Survey::create([
                'selected' => 3,
                'feedback' => null,
                'create_at' => time()
            ]);

            app()->session()->flash('feedback_info', 'Terimakasih atas penilaian yang diberikan.', FlashMessage::SUCCESS);

            return new RedirectResponse(route_to('home'));
        }else{
            app()->session()->flash('feedback_info', 'Token survei tidak valid.', FlashMessage::ERROR);
        }

        return new RedirectResponse(route_to('create_survey'));
    }

    public function cukup(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new SurveyForm();

        if ($request->getMethod() === 'POST') {
            if ($model->validateWithRequest($request)) {
                $token = app()->session()->unset('survey_token');
                if ($token === app()->config(Config::ATTR_APP_CONFIG . '.config.survey.token')) {
                    //simpan
                    Survey::create([
                        'selected' => 2,
                        'feedback' => $model->feedback,
                        'create_at' => time()
                    ]);

                    app()->session()->flash('feedback_info', 'Terimakasih atas penilaian dan feedback yang diberikan.', FlashMessage::SUCCESS);

                    return new RedirectResponse(route_to('home'));
                }else{
                    app()->session()->flash('feedback_info', 'Token survei tidak valid.', FlashMessage::ERROR);

                    return new RedirectResponse(route_to('create_survey'));
                }
            }
        }

        return view('feedback_cukup', $response, 'main', [
            'title' => 'Isi Feedback Survei Kepuasan Konsumen BPS',
            'model'=>$model
        ]);
    }

    public function tidak(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new SurveyForm();

        if ($request->getMethod() === 'POST') {
            if ($model->validateWithRequest($request)) {
                $token = app()->session()->unset('survey_token');
                if ($token === app()->config(Config::ATTR_APP_CONFIG .  '.config.survey.token')) {
                    //simpan
                    Survey::create([
                        'selected' => 1,
                        'feedback' => $model->feedback,
                        'create_at' => time()
                    ]);

                    app()->session()->flash('feedback_info', 'Terimakasih atas penilaian dan feedback yang diberikan.', FlashMessage::SUCCESS);

                    return new RedirectResponse(route_to('home'));
                }else{
                    app()->session()->flash('feedback_info', 'Token survei tidak valid.', FlashMessage::ERROR);

                    return new RedirectResponse(route_to('create_survey'));
                }
            }
        }

        return view('feedback_tidak', $response, 'main', [
            'title' => 'Isi Feedback Survei Kepuasan Konsumen BPS',
            'model'=>$model
        ]);
    }
}
