<?php
namespace Itstructure\LaRbac\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Itstructure\LaRbac\Models\Permission;
use Itstructure\LaRbac\Http\Requests\{
    StorePermission as StorePermissionRequest,
    UpdatePermission as UpdatePermissionRequest
};
use App\Http\Controllers\Controller;

/**
 * Class PermissionController
 *
 * @package Itstructure\LaRbac\Http\Controllers
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class PermissionController extends Controller
{
    /**
     * Get list of all permissions.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $permissions = Permission::orderBy('id', 'asc')
            ->paginate(Config::get('rbac.paginate.main'));

        return view('rbac::permissions.index', compact('permissions'));
    }

    /**
     * Render page to create new permission.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('rbac::permissions.create');
    }

    /**
     * Store new permission data.
     *
     * @param StorePermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePermissionRequest $request)
    {
        Permission::create($request->all());

        return redirect()->route('list_permissions');
    }

    /**
     * Render page to edit current permission.
     *
     * @param Permission $permission
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Permission $permission)
    {
        return view('rbac::permissions.edit', compact('permission'));
    }

    /**
     * Update current permission data.
     *
     * @param Permission $permission
     * @param UpdatePermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Permission $permission, UpdatePermissionRequest $request)
    {
        $permission->fill($request->all())->save();

        return redirect()->route('show_permission', [
            'id' => $permission->id
        ]);
    }

    /**
     * Render page to show current permission.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $permission = Permission::findOrFail($id);

        return view('rbac::permissions.show', compact('permission'));
    }

    /**
     * Delete current permission data.
     *
     * @param Permission $permission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('list_permissions');
    }
}