<?php

namespace App\Http\Controllers\Admin;

use App\Models\References\Trains;
use Illuminate\Http\Request;
use App\Models\References\TrainsCar;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use URL;

class TrainsCarController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function list()
    {

      //  var_dump(Storage::disk('public')->get('scheme/P4BoQTFNFWO44o32l3A0DQZ5y9mfJuQAJ0PEGRdd.png'));
      //  exit;

        return view('admin.trains_car.list')->with('title','Типы вагонов');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function create()
    {
        $options = [];
        $trains = Trains::get();

        foreach($trains as $train) {
            $options[$train->id] = $train->trainNumber  . ($train->trainName ? ' (' . $train->trainName . ')' : '');
        }

        return view('admin.trains_car.create_edit', compact('options'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'typeRu' => 'required|max:255',
                'typeEn' => 'required|max:255',
                'typeScheme' => 'required',
                'scheme' => 'mimes:jpg,jpeg,png,gif,svg|nullable',
                'train_id' => 'required|numeric',
            ],
            [
                'typeRu.required' => 'Укажите тип вагона!',
                'typeEn.required' => 'Укажите тип вагона для отображения пассажиру!',
                'typeScheme.required' => 'Укажите тип схемы!',
                'train_id.required' => 'Укажите поезд!',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $pic = $request->file('scheme');

            if (isset($pic)) {
                $path = $request->file('scheme')->store('scheme');
            }

            $scheme = isset($path) ? $path : '';

            TrainsCar::create(array_merge($request->all(),['scheme' => $scheme, 'isAddedManually' => true]));

            return redirect(URL::route('admin.trainscar.list'))->with('success', 'Тип вагона добавлен');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $trainsCar = TrainsCar::where('id',$id)->first();

        if ($trainsCar) {
            $options = [];
            $trains = Trains::get();

            foreach($trains as $train) {
                $options[$train->id] = $train->trainNumber  . ($train->trainName ? ' (' . $train->trainName . ')' : '');
            }

            return view('admin.trains_car.create_edit', compact('trainsCar', 'options'));
        }

        abort(404);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $validator = Validator::make($request->all(),
            [
                'typeRu' => 'required|max:255',
                'typeEn' => 'required|max:255',
                'typeScheme' => 'required',
                'scheme' => 'mimes:jpg,jpeg,png,gif,svg|nullable',
                'train_id' => 'numeric|nullable',
            ],
            [
                'typeRu.required' => 'Укажите тип вагона!',
                'typeEn.required' => 'Укажите тип вагона для отображения пассажиру!',
                'typeScheme.required' => 'Укажите тип схемы!',
                'train_id.required' => 'Укажите поезд!',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data['typeRu'] = $request->typeRu;
            $data['typeEn'] = $request->typeEn;
            $data['description'] = $request->description;
            $data['typeScheme'] = $request->typeScheme;
            if ($request->train_id) $data['train_id'] = $request->train_id;

            $pic = $request->file('scheme');

            if (isset($pic)) {

                $path = $request->file('scheme')->store('scheme');

                if ($path)  $data['scheme'] = $path;
            }

            TrainsCar::where('id', $id)->update($data);

            return redirect(URL::route('admin.trainscar.list'))->with('success', 'Данные обновлены');
        }
    }

    /**
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        $trainsCar = TrainsCar::where('id', $request->id)->first();

        if ($trainsCar) {
            Storage::delete($trainsCar->scheme);
        }

        TrainsCar::where(['id' => $request->id])->delete();
    }

    /**
     * @param Request $request
     */
    public function delImage(Request $request)
    {
        $trainsCar = TrainsCar::where('id', $request->id)->first();

        if ($trainsCar) {
            Storage::delete($trainsCar->scheme);
            TrainsCar::where('id', $request->id)->update(['scheme' => null]);
        }
    }
}