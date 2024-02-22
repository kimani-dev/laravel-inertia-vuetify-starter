<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class AccessLogsController extends Controller
{
    public function index()
    {
        return Inertia::render('Logs/Index', [
            'logs' => AccessLog::with('user')->latest()->get(),
        ]);
    }
}
