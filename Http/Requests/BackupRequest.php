<?php

namespace Modules\Backup\Http\Requests;

use App\Http\Requests\EntityRequest;

class BackupRequest extends EntityRequest
{
    protected $entityType = 'backup';
}
