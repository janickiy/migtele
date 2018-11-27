<?php
namespace App\Http\Controllers\Forms;


use App\Http\Requests\Feedback;
use App\Http\Requests\FeedbackOnTypeRequest;
use App\Mail\Admin\FeedbackOnTypeMail;
use App\Model\CallOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{


    const ITEMS = [
            'pay-products' => 'Покупка товара',
            'to-ceo' => 'Обратиться к директору',
            'purchase-returns' => 'Вопрос по обмену/возврату брака',
            'cooperation' => 'Сотрудничество'
        ];

    public function send(Feedback $request)
    {

        $request->request->set('date', Carbon::now());

        CallOrder::create($request->all());


        \Mail::send(new \App\Mail\Feedback($request->all()));


        return back()->with('success_message', 'Ваше сообщение успешно отправлено');

    }


    public function view($slug)
    {
        $items = self::ITEMS;

        $auth_view = \Auth::guest() ? '' : 'profile.';

        return view($auth_view.'feedback', compact('slug', 'items'));
    }

    public function sendOnType(FeedbackOnTypeRequest $request)
    {

        $request->request->set('date', Carbon::now());

        //CallOrder::create($request->all());

        \Mail::send(new FeedbackOnTypeMail($request->all()));


        return back()->with('success_message', 'Ваше обращение успешно отправлено');
    }

}
