<?php

namespace App\Console\Commands;

use App\Model\Currency;
use App\Model\ExchangeRate;
use Illuminate\Console\Command;

class CurrencyUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update currency';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function getExchangeRate($name){

        $date = date("Y/m/d");
        $codes = array(
            'usd'=>840,
            'eur'=>978,
        );
        $data = file_get_contents("http://cbrates.rbc.ru/tsv/{$codes[$name]}/{$date}.tsv");
        if($data){
            $ratio = explode("\t", $data);
            return trim($ratio[1]);
        }else{
            return false;
        }

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = date("Y-m-d");

        $rate = ExchangeRate::where('date', $date)->first();

        if(!$rate || !$rate->usd || !$rate->eur){

            $data = [
                'date' => $date,
                'usd' => $this->getExchangeRate('usd'),
                'eur' => $this->getExchangeRate('eur')
            ];

            if($rate){
                $rate->update($data);
                echo "Update row exchange rate";
            }else{
                ExchangeRate::create($data);
                echo "Create new row exchange rate";
            }

        }else{
            echo "Nothing update";
        }

    }
}
