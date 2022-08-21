<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailData extends Model
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

    protected $table = 'mail_data';

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
        'father_religion',
        'father_occupation',
        'father_marital_status',
        'father_address',
        'mother_name',
        'mother_religion',
        'mother_occupation',
        'mother_marital_status',
        'mother_address',
        'disease',
        'keterangan_surat',
        'created_at',
        'updated_at',
        'deleted_at',

        // Add on
        'entry_mail_id',
    ];

    protected $dates = [
        'birthdate',
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

    // Return an instance of EntryMail when 'entry_mail_id' is not null, otherwise return null
    public function entryMail(){
        return $this->belongsTo(EntryMail::class, 'entry_mail_id');
    }
}
