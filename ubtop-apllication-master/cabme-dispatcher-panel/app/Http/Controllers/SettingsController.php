<?php

namespace App\Http\Controllers;

use App\Models\Settings;

class SettingsController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');

    }

    public function getSettings()
    {
        $settings = Settings::paginate(1);

        foreach ($settings as $data)

            return $data->adminpanel_color;
    }
}
