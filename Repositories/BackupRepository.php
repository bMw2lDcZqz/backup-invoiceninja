<?php

namespace Modules\Backup\Repositories;

use DB;
use Modules\Backup\Models\Backup;
use App\Ninja\Repositories\BaseRepository;
//use App\Events\BackupWasCreated;
//use App\Events\BackupWasUpdated;

class BackupRepository extends BaseRepository
{
    public function getClassName()
    {
        return 'Modules\Backup\Models\Backup';
    }

    public function all()
    {
        return Backup::scope()
                ->orderBy('created_at', 'desc')
                ->withTrashed();
    }

    public function find($filter = null, $userId = false)
    {
        $query = DB::table('backup')
                    ->where('backup.account_id', '=', \Auth::user()->account_id)
                    ->select(
                        
                        'backup.public_id',
                        'backup.deleted_at',
                        'backup.created_at',
                        'backup.is_deleted',
                        'backup.user_id'
                    );

        $this->applyFilters($query, 'backup');

        if ($userId) {
            $query->where('clients.user_id', '=', $userId);
        }

        /*
        if ($filter) {
            $query->where();
        }
        */

        return $query;
    }

    public function save($data, $backup = null)
    {
        $entity = $backup ?: Backup::createNew();

        $entity->fill($data);
        $entity->save();

        /*
        if (!$publicId || intval($publicId) < 0) {
            event(new ClientWasCreated($client));
        } else {
            event(new ClientWasUpdated($client));
        }
        */

        return $entity;
    }

}
