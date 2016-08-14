<?php


namespace Reactor\Http\Controllers;

use Illuminate\Http\Request;
use Reactor\Http\Controllers\Traits\ModifiesPermissions;
use Reactor\Http\Controllers\Traits\UsesUserForms;
use Nuclear\Users\User;

class UsersController extends ReactorController {

    use ModifiesPermissions, UsesUserForms;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = User::class;
    protected $routeViewPrefix = 'users';
    protected $permissionKey = 'USERS';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::sortable()->paginate();

        return $this->compileView('users.index', compact('users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('EDIT_USERS');

        $user = User::findOrFail($id);

        $user->delete();

        $this->notify('users.destroyed');

        return redirect()->route('reactor.users.index');
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $users = User::search($request->input('q'), 20, true)->get();

        return $this->compileView('users.search', compact('users'));
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request)
    {
        $this->authorize('EDIT_USERS');

        $ids = json_decode($request->input('_bulkSelected', '[]'));

        User::whereIn('id', $ids)->delete();

        $this->notify('users.destroyed');

        return redirect()->route('reactor.users.index');
    }

}