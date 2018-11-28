<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Admin\AdminUser;
use App\Models\Admin\AdminRole;
use App\Model\Pages;

use Illuminate\Http\Request;
use Carbon\Carbon;
use URL;

class DataTableController extends Controller
{


    /**
     * @return mixed
     */
    public function getAdminUsers()
    {
        $users = AdminUser::selectRaw('*');

        return Datatables::of($users)
            ->addColumn('actions', function ($users) {
                $editBtn = '<a title="Редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.users.edit', ['id' => $users->adminUserId]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';

                if ($users->adminUserId != \Auth::id())
                    $deleteBtn = '<a class="btn btn-xs btn-danger deleteRow" id="' . $users->adminUserId . '"><span class="fa fa-remove"></span></a>';
                else
                    $deleteBtn = '';

                return $editBtn . $deleteBtn;

            })
            ->addColumn('role', function ($users) {

                $adminRoles = AdminRole::join('admin_user_roles', 'admin_user_roles.adminRoleId', '=', 'admin_roles.adminRoleId')
                    ->where('admin_user_roles.adminUserId', $users->adminUserId)
                    ->pluck('admin_roles.name');

                $names = $adminRoles->toArray();

                return $adminRoles ? implode(",", $names) : '';
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        $roles = AdminRole::selectRaw('*');

        return Datatables::of($roles)
            ->addColumn('actions', function ($roles) {
                $editBtn = '<a title="Редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.role.edit', ['id' => $roles->adminRoleId]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a class="btn btn-xs btn-danger deleteRow" id="' . $roles->adminRoleId . '"><span class="fa fa-remove"></span></a>';

                if (!in_array($roles->adminRoleId, [1]))
                    return $editBtn . $deleteBtn;
                else
                    return '';

            })->rawColumns(['actions'])->make(true);
    }

   public function getPages()
   {
       $row = Pages::select('*');

       return Datatables::of($row)


           ->addColumn('actions', function ($row) {
               $editBtn = '<a title="Редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.pages.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
               $deleteBtn = '<a class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

               return $editBtn . $deleteBtn;

           })->rawColumns(['actions'])->make(true);
   }








}
