<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kependudukan extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const GENDER_SELECT = [
        'LAKI_LAKI' => 'Laki Laki',
        'PEREMPUAN' => 'Perempuan',
    ];

    public const MARITAL_STATUS_SELECT = [
        'KAWIN'       => 'Kawin',
        'BELUM_KAWIN' => 'Belum Kawin',
    ];

    public const RELIGION_SELECT = [
        'ISLAM'             => 'Islam',
        'KRISTEN_PROTESTAN' => 'Kristen Protestan',
        'KRISTEN_KATHOLIK'  => 'Kristen Katholik',
        'HINDHU'            => 'Hindhu',
        'BUDHA'             => 'Budha',
        'KONGHUCU'          => 'Konghucu',
        'KEPERCAYAAN_LAIN'  => 'Kepercayaan Lain',
    ];

    public const LATEST_EDUCATION_SELECT = [
        'SD'               => 'SD/Sederajat',
        'SLTP'             => 'SMP/SLTP Sederajat',
        'SLTA'             => 'SMA/SLTA Sederajat',
        'D3'               => 'Diploma III',
        'S1'               => 'Diploma IV / S1 Sederajat',
        'S2'               => 'S2',
        'S3'               => 'S3',
        'TIDAK_BERSEKOLAH' => 'Tidak Bersekolah',
    ];

    public $table = 'kependudukans';

    protected $dates = [
        'birthdate',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'fullname',
        'nik',
        'birthdate',
        'birthplace',
        'gender',
        'religion',
        'marital_status',
        'latest_education',
        'occupation',
        'father_name',
        'mother_name',
        'disease',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getBirthdateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setBirthdateAttribute($value)
    {
        $this->attributes['birthdate'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}