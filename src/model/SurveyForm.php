<?php

declare(strict_types=1);

namespace App\Model;

use Anskh\PhpWeb\Model\FormModel;

class SurveyForm extends FormModel
{
    public string $feedback;

    protected array $labels = [
        'feedback' => 'Saran/Kritik/Alasan <span class="text-danger">*</span>',
    ];

    protected array $rules = [
        'feedback' => self::ATTR_RULE_REQUIRED
    ];
}