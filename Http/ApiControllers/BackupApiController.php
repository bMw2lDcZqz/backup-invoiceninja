<?php

namespace Modules\Backup\Http\ApiControllers;

use App\Http\Controllers\BaseAPIController;
use Modules\Backup\Repositories\BackupRepository;
use Modules\Backup\Http\Requests\BackupRequest;
use Modules\Backup\Http\Requests\CreateBackupRequest;
use Modules\Backup\Http\Requests\UpdateBackupRequest;

class BackupApiController extends BaseAPIController
{
    protected $BackupRepo;
    protected $entityType = 'backup';

    public function __construct(BackupRepository $backupRepo)
    {
        parent::__construct();

        $this->backupRepo = $backupRepo;
    }

    /**
     * @SWG\Get(
     *   path="/backup",
     *   summary="List backup",
     *   operationId="listBackups",
     *   tags={"backup"},
     *   @SWG\Response(
     *     response=200,
     *     description="A list of backup",
     *      @SWG\Schema(type="array", @SWG\Items(ref="#/definitions/Backup"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function index()
    {
        $data = $this->backupRepo->all();

        return $this->listResponse($data);
    }

    /**
     * @SWG\Get(
     *   path="/backup/{backup_id}",
     *   summary="Individual Backup",
     *   operationId="getBackup",
     *   tags={"backup"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="backup_id",
     *     type="integer",
     *     required=true
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="A single backup",
     *      @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Backup"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function show(BackupRequest $request)
    {
        return $this->itemResponse($request->entity());
    }




    /**
     * @SWG\Post(
     *   path="/backup",
     *   summary="Create a backup",
     *   operationId="createBackup",
     *   tags={"backup"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="backup",
     *     @SWG\Schema(ref="#/definitions/Backup")
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="New backup",
     *      @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Backup"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function store(CreateBackupRequest $request)
    {
        $backup = $this->backupRepo->save($request->input());

        return $this->itemResponse($backup);
    }

    /**
     * @SWG\Put(
     *   path="/backup/{backup_id}",
     *   summary="Update a backup",
     *   operationId="updateBackup",
     *   tags={"backup"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="backup_id",
     *     type="integer",
     *     required=true
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="backup",
     *     @SWG\Schema(ref="#/definitions/Backup")
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="Updated backup",
     *      @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Backup"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function update(UpdateBackupRequest $request, $publicId)
    {
        if ($request->action) {
            return $this->handleAction($request);
        }

        $backup = $this->backupRepo->save($request->input(), $request->entity());

        return $this->itemResponse($backup);
    }


    /**
     * @SWG\Delete(
     *   path="/backup/{backup_id}",
     *   summary="Delete a backup",
     *   operationId="deleteBackup",
     *   tags={"backup"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="backup_id",
     *     type="integer",
     *     required=true
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="Deleted backup",
     *      @SWG\Schema(type="object", @SWG\Items(ref="#/definitions/Backup"))
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function destroy(UpdateBackupRequest $request)
    {
        $backup = $request->entity();

        $this->backupRepo->delete($backup);

        return $this->itemResponse($backup);
    }

}
