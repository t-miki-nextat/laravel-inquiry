<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\InquiryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Inquiry
 * @property int $id ID
 * @property string $name name
 * @property string $email email
 * @property string $content inquiry_content
 * @property InquiryType $type inquiry_type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Inquiry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'content',
        'type',
    ];

    protected $casts = [
        'type' => InquiryType::class,
    ];
}
