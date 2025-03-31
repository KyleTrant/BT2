<?php

namespace App\Enums;

class TaskStatus
{
    public const PENDING = 'pending';
    public const IN_PROGRESS = 'in_progress';
    public const COMPLETED = 'completed';
    public static function all(): array
    {
        return [
            self::PENDING => 'Pending',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed'
        ];
    }
    public static function getLabel(string $status): string
    {
        return self::all()[$status] ?? "";
    }
}
