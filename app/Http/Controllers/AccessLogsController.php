<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class AccessLogsController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Logs/Index', [
            'logs' => AccessLog::with('user')->latest()
                ->when($request->search, function ($query, $search) {
                    $query->where('ip', 'LIKE', '%' . $search . '%')
                        ->orWhere('user_agent', 'LIKE', '%' . $search . '%');
                })
                ->when($request->action, function ($query, $action) {
                    $query->where('action', $action);
                })
                ->paginate($request->itemsPerPage ?? 10, ['*'], 'page', $request->page ?? 1),
            'filterOptions' => [
                'action' => [
                    ['value' => 'POST', 'label' => 'POST'],
                    ['value' => 'GET', 'label' => 'GET'],
                    ['value' => 'PUT', 'label' => 'PUT'],
                    ['value' => 'DELETE', 'label' => 'DELETE'],
                ]
            ]
        ]);
    }
}
