<?php

namespace App\Console\Commands;

use App\ApplicationSetting;
use Swap\Builder;
use Illuminate\Console\Command;

class AppUpdaterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updater:app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update application constances';

    /**
     * Swap instance
     * 
     * @var \Swap
     */
    private $swap;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Build Swap
        $this->swap = (new Builder())
        // Use the currencylayer.com service as first fallback
        ->add('currency_layer', ['access_key' => env('CURRENCYLAYER_SECRET'), 'enterprise' => false])
        ->build();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Exchange USD to EUR
        $usdToEur = $this->swap->latest('USD/EUR')->getValue();
        if(isset($usdToEur)){
            $usdToEurSetting = ApplicationSetting::where('key', 'usd2eur')->first();
            if(is_null($usdToEurSetting)){
                ApplicationSetting::create([
                    'key'   =>  'usd2eur',
                    'name'  =>  'USD to EUR',
                    'value' =>  $usdToEur
                ]);
            }else{
                $usdToEurSetting->update([
                    'value' =>  $usdToEur
                ]);
            }
        }
    }
}
