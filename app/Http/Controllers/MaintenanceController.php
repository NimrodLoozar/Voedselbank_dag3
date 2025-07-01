<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function toggle(Request $request)
    {
        $isMaintenanceMode = $request->has('maintenance_mode');
        Setting::setMaintenanceMode($isMaintenanceMode);

        return redirect()->back()->with('status', 'Maintenance mode updated successfully.');
    }
}
