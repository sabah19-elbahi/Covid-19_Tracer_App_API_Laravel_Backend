<?php

namespace App\Models;


use \DateTimeInterface;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Device extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'devices';

    public static $searchable = [
        'udid',
    ];

    protected $dates = [
        'date_test',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'udid',
        'token',
        'user_id',
        'key',
        'date_test',
        'covid',
        'risk',
        'created_at',
        'updated_at',
        'deleted_at',
        'fcm_token',
    ];

    public function getDateTestAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateTestAttribute($value)
    {
        $this->attributes['date_test'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
