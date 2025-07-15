<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Request;

class LogSuccessfulLogout
{
    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        $cacheKey = 'logout_logged_' . $event->user->id . '_' . time();
        
        // Prevent duplicate logging within the same second
        if (cache()->has($cacheKey)) {
            return;
        }
        
        cache()->put($cacheKey, true, 2); // Cache for 2 seconds

        ActivityLog::create([
            'user_id' => $event->user->id,
            'item_type' => 'App\Models\User',
            'item_id' => $event->user->id,
            'action' => 'logout',
            'item_data' => [
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
                'guard' => $event->guard,
            ],
        ]);
    }
}