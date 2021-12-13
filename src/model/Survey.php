<?php

declare(strict_types=1);

namespace App\Model;

use Core\Model\DbModel;

class Survey extends DbModel
{
    protected string $table = 'survey';
    protected bool $autoIncrement = true;
    protected string $primaryKey = 'id';
    protected array $fields = [
        'selected','feedback','feedback','create_at'
    ];

    public int $id;
    public int $selected;
    public ?string $feedback;
    public int $create_at;

    public static function table(): string
    {
        return db_table('survey');
    }

}
 