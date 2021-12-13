<?php

declare(strict_types=1);

namespace App\Model;

use Core\Model\FormModel;

class SurveyForm extends FormModel
{
    public string $feedback;

    protected array $labels = [
        'feedback' => 'Saran/Kritik/Alasan <span class="text-danger">*</span>',
    ];

    protected array $rules = [
        'feedback' => self::RULE_REQUIRED
    ];
}