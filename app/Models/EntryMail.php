<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EntryMail extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;

    public const STATUS_SELECT = [
        'PROSES'    => 'Dalam Proses',
        'DISETUJUI' => 'Sudah Disetujui',
        'DITOLAK'   => 'Ditolak',
    ];

    public const TYPE_SELECT = [
        'PENGANTAR_SURAT_NIKAH'  => 'Pengantar Surat Menikah',
        'KETERANGAN_DOMISILI'    => 'Keterangan Domisili',
        'KETERANGAN_BELUM_MENIKAH' => 'Keterangan Belum Menikah',
        'PERSETUJUAN_TETANGGA'   => 'Persetujuan Tetangga',
    ];

    public $table = 'entry_mails';

    protected $appends = [
        'mail',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'type',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',

        // Add on
        'user_id',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getMailAttribute()
    {
        return $this->getMedia('mail')->last();
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}