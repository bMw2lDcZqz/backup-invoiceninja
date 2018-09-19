<?php

namespace Modules\Backup\Transformers;

use Modules\Backup\Models\Backup;
use App\Ninja\Transformers\EntityTransformer;

/**
 * @SWG\Definition(definition="Backup", @SWG\Xml(name="Backup"))
 */

class BackupTransformer extends EntityTransformer
{
    /**
    * @SWG\Property(property="id", type="integer", example=1, readOnly=true)
    * @SWG\Property(property="user_id", type="integer", example=1)
    * @SWG\Property(property="account_key", type="string", example="123456")
    * @SWG\Property(property="updated_at", type="integer", example=1451160233, readOnly=true)
    * @SWG\Property(property="archived_at", type="integer", example=1451160233, readOnly=true)
    */

    /**
     * @param Backup $backup
     * @return array
     */
    public function transform(Backup $backup)
    {
        return array_merge($this->getDefaults($backup), [
            
            'id' => (int) $backup->public_id,
            'updated_at' => $this->getTimestamp($backup->updated_at),
            'archived_at' => $this->getTimestamp($backup->deleted_at),
        ]);
    }
}
