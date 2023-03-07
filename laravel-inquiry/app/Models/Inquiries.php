<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Inquiries
 * @property int $id ID
 * @property string $name name
 * @property string $email email
 * @property text $content inquiry_content
 * @property text $type inquiry_type
 */
class Inquiries extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string, text>
     */
    protected $fillable = [
        'name',
        'email',
        'content',
        'type',
    ];
}
