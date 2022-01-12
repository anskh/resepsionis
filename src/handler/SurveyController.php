<?php

declare(strict_types=1);

namespace App\Handler;

use App\Model\Survey;
use App\Model\SurveyForm;
use Anskh\PhpWeb\Http\Session\FlashMessage;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SurveyController
{
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        my_app()->session()->set('survey_token', my_config()->get('config.survey.token'));

        return my_view('create_survey', $response, 'layout/main', [
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
        $token = my_app()->session()->unset('survey_token');
        if ($token === my_config()->get('config.survey.token')) {
            //simpan
            Survey::create([
                'selected' => 4,
                'feedback' => null,
                'create_at' => time()
            ]);

            my_app()->session()->flashSuccess('feedback_info', 'Terimakasih atas penilaian yang diberikan.');

            return new RedirectResponse(my_route_to('home'));
        }else{
            my_app()->session()->flashError('feedback_info', 'Token survei tidak valid.');
        }

        return new RedirectResponse(my_route_to('create_survey'));
    }
    public function puas(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $token = my_app()->session()->unset('survey_token');
        if ($token === my_config()->get('config.survey.token')) {
            //simpan
            Survey::create([
                'selected' => 3,
                'feedback' => null,
                'create_at' => time()
            ]);

            my_app()->session()->flashSuccess('feedback_info', 'Terimakasih atas penilaian yang diberikan.');

            return new RedirectResponse(my_route_to('home'));
        }else{
            my_app()->session()->flashError('feedback_info', 'Token survei tidak valid.');
        }

        return new RedirectResponse(my_route_to('create_survey'));
    }

    public function cukup(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new SurveyForm();

        if ($request->getMethod() === 'POST') {
            if ($model->validateWithRequest($request)) {
                $token = my_app()->session()->unset('survey_token');
                if ($token === my_config()->get('config.survey.token')) {
                    //simpan
                    Survey::create([
                        'selected' => 2,
                        'feedback' => $model->feedback,
                        'create_at' => time()
                    ]);

                    my_app()->session()->flash('feedback_info', 'Terimakasih atas penilaian dan feedback yang diberikan.', FlashMessage::SUCCESS);

                    return new RedirectResponse(my_route_to('home'));
                }else{
                    my_app()->session()->flashError('feedback_info', 'Token survei tidak valid.');

                    return new RedirectResponse(my_route_to('create_survey'));
                }
            }
        }

        return my_view('feedback_cukup', $response, 'layout/main', [
            'title' => 'Isi Feedback Survei Kepuasan Konsumen BPS',
            'model'=>$model
        ]);
    }

    public function tidak(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $model = new SurveyForm();

        if ($request->getMethod() === 'POST') {
            if ($model->validateWithRequest($request)) {
                $token = my_app()->session()->unset('survey_token');
                if ($token === my_config()->get('config.survey.token')) {
                    //simpan
                    Survey::create([
                        'selected' => 1,
                        'feedback' => $model->feedback,
                        'create_at' => time()
                    ]);

                    my_app()->session()->flashSuccess('feedback_info', 'Terimakasih atas penilaian dan feedback yang diberikan.');

                    return new RedirectResponse(my_route_to('home'));
                }else{
                    my_app()->session()->flashError('feedback_info', 'Token survei tidak valid.');

                    return new RedirectResponse(my_route_to('create_survey'));
                }
            }
        }

        return my_view('feedback_tidak', $response, 'layout/main', [
            'title' => 'Isi Feedback Survei Kepuasan Konsumen BPS',
            'model'=>$model
        ]);
    }
}
