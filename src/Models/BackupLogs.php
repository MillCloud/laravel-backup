<?php

namespace MillCloud\Backup\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $username
 * @property string $real_name
 */
class BackupLogs extends Model
{

    protected $fillable = [
        'name',
        'type',
        'status',
        'file_size',
        'file_path',
        'used',
        'reason',
        'created_at',
        'updated_at',
    ];

    protected $visible = [
        'name',
        'type',
        'status',
        'file_size',
        'file_path',
        'used',
        'reason',
        'created_at',
        'updated_at',
    ];
}
