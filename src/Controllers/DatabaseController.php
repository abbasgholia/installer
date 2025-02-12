<?php

namespace Froiden\LaravelInstaller\Controllers;

use App\Models\Setting;
use App\Models\SysSpc;
use Illuminate\Routing\Controller;
use Froiden\LaravelInstaller\Helpers\DatabaseManager;
use App\Models\Year;
class DatabaseController extends Controller
{

    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * Migrate and seed the database.
     *
     * @return \Illuminate\View\View
     */
    public function database()
    {
        // Sometimes migration file and seed files may take more then 30 seconds so we are going to set it 0 that indicates
        // that there is no time limit for execution.


        set_time_limit(0);

        $response = $this->databaseManager->migrateAndSeed();

        Year::create(['year' => session('year') , "close"=>0]);
        Setting::create(['name_spc' => "invable" , "value" => session('invable') , "year" => session('year') ]);
        Setting::create(['name_spc' => "serializable" , "value" => session('serializable'), "year" => session('year')  ]);
        Setting::create(['name_spc' => "batchable" , "value" => session('batchable') , "year" => session('year') ]);
        Setting::create(['name_spc' => "barcode_type" , "value" => "QRCODE", "year" => session('year')  ]);
        Setting::create(['name_spc' => "currently_counting_time" , "value" => 1 , "year" => session('year') ]);
        SysSpc::create(['name_spc' => "name_co" , "value" => session('name_co') ]);



        return redirect()->route('LaravelInstaller::final')
                         ->with(['message' => $response]);
    }
}
