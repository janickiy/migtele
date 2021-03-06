<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Pages;
use Illuminate\Support\Facades\Validator;
use URL;

class GrController extends Controller
{

    public function list()
    {
        return view('admin.pages.list')->with('title','Страницы');
    }

    public function create()
    {


        return view('admin.pages.create_edit');
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:admin_roles',
            'accessLevel' => 'numeric',
            'accessMap' => 'array'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            AdminRole::create($request->all())->adminRoleId;

            return redirect(URL::route('admin.role.list'))->with('success', 'Информация успешно добавлена');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {


        return view('admin.role.create_edit', compact('role', 'permissions', 'roout_list'));
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        if (!is_numeric($request->adminRoleId)) abort(500);

        $rules = [
            'name' => 'required|unique:admin_roles,name,' . $request->adminRoleId .',adminRoleId',
            'accessLevel' => 'numeric',
            'accessMap' => 'array'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $role = AdminRole::find($request->adminRoleId);
            $role->name = $request->name;
            $role->accessLevel = $request->accessLevel;
            $role->accessMap = $request->accessMap;
            $role->save();

            return redirect(URL::route('admin.role.list'))->with('success', 'Данные обновлены');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request)
    {
        $id = $request->id;


    }
}