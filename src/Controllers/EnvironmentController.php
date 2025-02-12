<?php

namespace Froiden\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Froiden\LaravelInstaller\Helpers\EnvironmentManager;
use Froiden\LaravelInstaller\Request\UpdateRequest;

/**
 * Class EnvironmentController
 * @package Froiden\LaravelInstaller\Controllers
 */
class EnvironmentController extends Controller
{

    /**
     * @var EnvironmentManager
     */
    protected $environmentManager;

    /**
     * @param EnvironmentManager $environmentManager
     */
    public function __construct(EnvironmentManager $environmentManager)
    {
        $this->environmentManager = $environmentManager;
    }

    /**
     * Display the Environment page.
     *
     * @return \Illuminate\View\View
     */
    public function environment()
    {
        $envConfig = $this->environmentManager->getEnvContent();

        return view('vendor.installer.environment', compact('envConfig'));
    }

    /**
     * @param UpdateRequest $request
     * @return string
     */
    public function save(UpdateRequest $request)
    {

        session(["year"=> $request->year]);
        session(["invable"=> $request->invable ?? 0]);
        session(["serializable"=> $request->serializable ?? 0]);
        session(["batchable"=> $request->batchable ?? 0]);
        session(["name_co"=> $request->name_co]);
        session()->save();
        $message = $this->environmentManager->saveFile($request);

        $message['message'] = "پیام سیستم :  <br>" . $message['message'];

        return $message;

    }

}
