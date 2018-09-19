<?php

namespace Modules\Backup\Http\Controllers;

use Auth;
use App\Http\Controllers\BaseController;
use App\Services\DatatableService;
use Modules\Backup\Datatables\BackupDatatable;
use Modules\Backup\Repositories\BackupRepository;
use Modules\Backup\Http\Requests\BackupRequest;
use Modules\Backup\Http\Requests\CreateBackupRequest;
use Modules\Backup\Http\Requests\UpdateBackupRequest;

class BackupController extends BaseController
{
    protected $BackupRepo;
    //protected $entityType = 'backup';

    public function __construct(BackupRepository $backupRepo)
    {
        //parent::__construct();

        $this->backupRepo = $backupRepo;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('list_wrapper', [
            'entityType' => 'backup',
            'datatable' => new BackupDatatable(),
            'title' => mtrans('backup', 'backup_list'),
        ]);
    }

    public function datatable(DatatableService $datatableService)
    {
        $search = request()->input('sSearch');
        $userId = Auth::user()->filterId();

        $datatable = new BackupDatatable();
        $query = $this->backupRepo->find($search, $userId);

        return $datatableService->createDatatable($datatable, $query);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(BackupRequest $request)
    {
        $data = [
            'backup' => null,
            'method' => 'POST',
            'url' => 'backup',
            'title' => mtrans('backup', 'new_backup'),
        ];

        return view('backup::edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(CreateBackupRequest $request)
    {
        $backup = $this->backupRepo->save($request->input());

        return redirect()->to($backup->present()->editUrl)
            ->with('message', mtrans('backup', 'created_backup'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit(BackupRequest $request)
    {
        $backup = $request->entity();

        $data = [
            'backup' => $backup,
            'method' => 'PUT',
            'url' => 'backup/' . $backup->public_id,
            'title' => mtrans('backup', 'edit_backup'),
        ];

        return view('backup::edit', $data);
    }

    /**
     * Show the form for editing a resource.
     * @return Response
     */
    public function show(BackupRequest $request)
    {
        return redirect()->to("backup/{$request->backup}/edit");
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateBackupRequest $request)
    {
        $backup = $this->backupRepo->save($request->input(), $request->entity());

        return redirect()->to($backup->present()->editUrl)
            ->with('message', mtrans('backup', 'updated_backup'));
    }

    /**
     * Update multiple resources
     */
    public function bulk()
    {
        $action = request()->input('action');
        $ids = request()->input('public_id') ?: request()->input('ids');
        $count = $this->backupRepo->bulk($ids, $action);

        return redirect()->to('backup')
            ->with('message', mtrans('backup', $action . '_backup_complete'));
    }
}
