<?php

namespace App\Console\Commands;

use App\ApplicationSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Swap;

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
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            // Exchange USD to EUR
            $usdToEur = Swap::latest('USD/EUR');
            // Update DB
            $usdToEurSetting = ApplicationSetting::where('key', 'usd2eur')->first();
            if(is_null($usdToEurSetting)){
                ApplicationSetting::create([
                    'key'   =>  'usd2eur',
                    'name'  =>  'USD to EUR',
                    'value' =>  $usdToEur->getValue()
                ]);
            }else{
                $usdToEurSetting->update([
                    'value' =>  $usdToEur->getValue()
                ]);
            }
        }catch(\Exception $ex){
            Log::error($ex->getMessage());
        }
    }
}
