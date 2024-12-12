<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use HasFactory, SoftDeletes;

    public const string STATUS_PENDING = 'pending';

    public const string STATUS_IN_PROGRESS = 'in-progress';

    public const string STATUS_COMPLETED = 'completed';

    protected $fillable = [
        'title',
        'description',
        'url',
        'status',
    ];

    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_COMPLETED => 'Completed',
        ];
    }

    public function adTemplate(): HasOne
    {
        return $this->hasOne(AdTemplate::class);
    }
}
