<?php
namespace App\Helpers\Promocodes;

use App\Mail\DefaultMail;
use App\Models\Promocode;
use App\Models\PromocodeCreator;
use App\Models\PromocodeUse;
use Carbon\Carbon;

class Promocodes {


    private $length;

    private $mask = '****-****';


    function __construct()
    {
        $this->length = substr_count($this->mask, '*');
    }

    public function createInEmail($email, $name, $reward = 0, $quantity = 1000, $expire_days = 0)
    {
        $reward = $reward ? $reward : _setting('friend-promocode-reward');
        $expire_days = $expire_days ? $expire_days :  _setting('friend-promocode-expired');

        $creator = $this->getCreator($email);

        $expire_days = $expire_days ? $expire_days : 365000;

        $expire_date = date("Y-m-d H:i:s", time() + ($expire_days * 86400));

        if(!$creator){

            $creator = PromocodeCreator::create([
                'email' => $email,
                'name' => $name,
                'promocode_id' => $this->create($reward, $quantity, $expire_date)->id
            ]);

            session(['promocode_creator' => $email]);

        }

        $creator->promocode->expire_date = $expire_date;
        $creator->promocode->save();

        session()->flash('share_promocode', $creator->promocode->code);

        return $creator->promocode;
    }

    /**
     * @param $code
     * @param $email
     * @param $name
     */
    public function used($code, $email, $name)
    {
        $promocode = Promocode::byCode($code)->first();

        PromocodeUse::create([
            'email' => $email,
            'promocode_id' => $promocode->id,
            'used_at' => Carbon::now()
        ]);

        $promocode->quantity--;
        $promocode->save();

        $this->sendCodeToCreator($this->createInEmail($email, $name), $promocode->creator);

    }

    protected function sendCodeToCreator($promocode, $creator)
    {
        if(!$creator->friend_promocode_active){
            \Mail::send(new DefaultMail('promocode-friend-active-code', [
                '[friend_name]' => $promocode->creator->name,
                '[name]' => $creator->name,
                '[reward]' => $promocode->reward,
                '[link]' => $promocode->url
            ], $creator->name, $creator->email));
            $creator->friend_promocode_active = true;
            $creator->save();
        }
    }

    public function create($reward, $quantity = -1, $expire_date = null)
    {

        return Promocode::create([
            'code' => $this->generate(),
            'reward' => $reward,
            'quantity' => $quantity,
            'expire_date' => $expire_date
        ]);

    }

    /**
     * Here will be generated single code using your parameters from config.
     *
     * @return string
     */
    private function generate()
    {
        $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $mask = $this->mask;
        $promocode = '';
        $random = [];
        for ($i = 1; $i <= $this->length; $i++) {
            $character = $characters[rand(0, strlen($characters) - 1)];
            $random[] = $character;
        }
        shuffle($random);
        $length = count($random);
        for ($i = 0; $i < $length; $i++) {
            $mask = preg_replace('/\*/', $random[$i], $mask, 1);
        }
        $promocode .= $mask;

        $promocode = $this->exist($promocode) ? $this->generate() : $promocode;

        return $promocode;
    }


    private function exist($code)
    {
        return !!Promocode::byCode($code)->count();
    }


    public function check($code, $email = '')
    {

        /**
         * @var Promocode $promocode
         */

        $promocode = Promocode::byCode($code)->first();

        if(!$promocode){
            return _('promocode.errors.invalid');
        }

        if($promocode->only_email && $promocode->only_email != $email)
        {
            return _('promocode.errors.only_email');
        }

        if($this->isPromocodeCreator($code, $email))
        {
            return _('promocode.errors.email_is_created');
        }

        if($this->isPromocodeUses($code, $email))
        {
            return _('promocode.errors.already_used');
        }


        if($promocode->isExpired())
        {
            return _('promocode.errors.expired');
        }


        return $promocode->reward;

    }

    public function validation($code)
    {
        /**
         * @var Promocode $promocode
         */

        $email = '';

        $promocode = Promocode::byCode($code)->first();

        if(!$promocode) return false;

        if($promocode->only_email && $promocode->only_email != $email)
            return false;

        if($this->isPromocodeCreator($code, session('promocode_creator')) || $this->isPromocodeUses($code, session('promocode_user')) || $promocode->isExpired())
            return false;

        return true;
    }


    private function isPromocodeUses($code, $email)
    {
        $uses = $this->getUses($email);

        return $uses ? $uses->promocode()->byCode($code)->first() : false;
    }

    private function isPromocodeCreator($code, $email)
    {
        $creator = $this->getCreator($email);

        return $creator ? $creator->promocode()->byCode($code)->first() : false;
    }


    /**
     * @param $email
     * @return PromocodeCreator
     */
    private function getCreator($email)
    {
        return PromocodeCreator::where('email', $email)->first();
    }

    /**
     * @param $email
     * @return PromocodeUse
     */
    private function getUses($email)
    {
        return PromocodeUse::where('email', $email)->first();
    }


    public function apply($code)
    {
        session(['promocode' => $code]);
    }

    public function remove()
    {
        session()->forget('promocode');
    }

    public function getSessionPromocode()
    {
        $code = session('promocode');

        return $code ? Promocode::byCode($code)->first() : false;
    }



}