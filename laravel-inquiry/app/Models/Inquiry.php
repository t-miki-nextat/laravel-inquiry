<?php
declare(strict_types=1);

namespace App\Models;

use App\Enums\InquiryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Inquiry
 * @property int $id ID
 * @property string $name name
 * @property string $email email
 * @property string $content inquiry_content
 * @property InquiryType $type inquiry_type
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
        'type'  => InquiryType::class,
    ];
}
