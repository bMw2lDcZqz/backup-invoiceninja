<?php

namespace Modules\Backup\Datatables;

use Utils;
use URL;
use Auth;
use App\Ninja\Datatables\EntityDatatable;

class BackupDatatable extends EntityDatatable
{
    public $entityType = 'backup';
    public $sortCol = 1;

    public function columns()
    {
        return [
            
            [
                'created_at',
                function ($model) {
                    return Utils::fromSqlDateTime($model->created_at);
                }
            ],
        ];
    }

    public function actions()
    {
        return [
            [
                mtrans('backup', 'edit_backup'),
                function ($model) {
                    return URL::to("backup/{$model->public_id}/edit");
                },
                function ($model) {
                    return Auth::user()->can('editByOwner', ['backup', $model->user_id]);
                }
            ],
        ];
    }

}
