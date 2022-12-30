<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Family extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'families';

    public const STATUS_KEPENDUDUKAN_SELECT = [
        'ASLI' => "Penduduk Asli",
        'PENDATANG' => "Penduduka Pendatang",
    ];

    protected $fillable = [
        'no_kk',
        'status_kependudukan',
        'address',
        'rt_rw',
        'postal_code',
        'kelurahan',
        'kecamatan',
        'city',
        'province',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    // Return multiple instance of kependudukans
    public function kependudukans(){
        return $this->hasMany(Kependudukan::class, 'family_id');
    }
}
