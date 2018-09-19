<?php

namespace Modules\Backup\;

use App\Providers\AuthServiceProvider;

class BackupAuthProvider extends AuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \Modules\Backup\Models\Backup::class => \Modules\Backup\Policies\BackupPolicy::class,
    ];
}
