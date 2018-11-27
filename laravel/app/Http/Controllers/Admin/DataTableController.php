<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\SessionLog;
use App\Models\Admin\{AdminUser, AdminRole};
use App\Models\{User, Settings, OrdersRailway};
use App\Models\References\{TrainsCar, Trains};
use Illuminate\Http\Request;
use Carbon\Carbon;
use URL;

class DataTableController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getSessionLog(Request $request)
    {
        $dates = explode(' - ', $request->date);

        if (array_key_exists(0, $dates) && array_key_exists(1, $dates)) {
            $start = Carbon::parse($dates[0])->format('Y-m-d H:i:s');
            $end = Carbon::parse($dates[1])->format('Y-m-d H:i:s');
            $logs = SessionLog::whereBetween('created_at', [$start, $end]);
        } else

            $logs = SessionLog::selectRaw('*');

        return Datatables::of($logs)
            ->editColumn('session_log_id', function ($logs) {
                return '<a href="' . URL::route('admin.logs.info', ['id' => $logs->session_log_id]) . '">' . $logs->session_log_id . '</a>';
            })
            ->editColumn('session_id', function ($logs) {
                return '<a href="#" class="choose_session_id" data-content="' . $logs->session_id . '">' . $logs->session_id . '</a>';
            })
            ->addColumn('user', function ($logs) {
                $user = User::where('userId', $logs->user_id)->first();

                return isset($user->login) && $user->login ? $user->login : '-';
            })->rawColumns(['user', 'session_log_id', 'session_id'])->make(true);
    }

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

    /**
     * @return mixed
     */
    public function getSettings()
    {
        \Cache::flush();

        //$user = $request->user('admin');

        $settings = Settings::selectRaw('*');;

        return Datatables::of($settings)
            ->addColumn('actions', function ($settings) {
                $editBtn = '<a title="Редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.settings.edit', ['id' => $settings->settingId]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a class="btn btn-xs btn-danger deleteRow" id="' . $settings->settingId . '"><span class="fa fa-remove"></span></a>';

                return $editBtn . $deleteBtn;

            })->rawColumns(['actions'])->make(true);
    }

    /**
     * @return mixed
     */
    public function getPortalUsers()
    {
        $users = User::orderBy('userId');

        return Datatables::of($users)
            ->addColumn('actions', function ($users) {

                $editBtn = '<a title="Редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.portalusers.edit', ['id' => $users->userId]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a class="btn btn-xs btn-danger deleteRow" id="' . $users->userId . '"><span class="fa fa-remove"></span></a>';

                return $editBtn . $deleteBtn;

            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return mixed
     */
    public function getOrdersRailways()
    {
        $order = OrdersRailway::selectRaw('*');

        return Datatables::of($order)
            ->addColumn('checkbox', function ($order) {
                return '<input type="checkbox" title="Отметить/Снять отметку" value="' . $order->orderId . '" name="activate[]">';
            })
            ->editColumn('orderId', function ($order) {
                return '<a href="' . URL::route('admin.ordersrailway.info', ['id' => $order->orderId]) . '">' . $order->orderId . '</a>';
            })
            ->editColumn('orderStatus', function ($order) {
                return OrdersRailway::$status_name[$order->orderStatus];
            })
            ->addColumn('user', function ($order) {
                return isset($order->user->login) && $order->user->login ? $order->user->login : '-';
            })
            ->rawColumns(['orderId', 'checkbox'])->make(true);
    }

    /**
     * @return mixed
     */
    public function getTrainsCar()
    {
        $trainsCar = TrainsCar::with('trains');

        return Datatables::of($trainsCar)
            ->editColumn('trains.trainName', function ($trainsCar) {
                return  isset($trainsCar->trains->trainName) ? $trainsCar->trains->trainName : '';
            })

            ->editColumn('trains.trainNumber', function ($trainsCar) {
                return  isset($trainsCar->trains->trainNumber) ? $trainsCar->trains->trainNumber : '';
            })

            ->editColumn('scheme', function ($trainsCar) {
                return isset($trainsCar->scheme) ? 'да' : 'нет';
            })
            ->addColumn('actions', function ($trainsCar) {
                $editBtn = '<a title="Редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.trainscar.edit', ['id' => $trainsCar->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a class="btn btn-xs btn-danger deleteRow" id="' . $trainsCar->id . '"><span class="fa fa-remove"></span></a>';

                return $editBtn . $deleteBtn;

            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return mixed
     */
    public function getTrains()
    {
        $trains = Trains::selectRaw('*');

        return Datatables::of($trains)
            ->addColumn('actions', function ($trains) {
                $editBtn = '<a title="Редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('admin.trains.edit', ['id' => $trains->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a class="btn btn-xs btn-danger deleteRow" id="' . $trains->id . '"><span class="fa fa-remove"></span></a>';

                return $editBtn . $deleteBtn;

            })
            ->rawColumns(['actions'])->make(true);
    }
}
