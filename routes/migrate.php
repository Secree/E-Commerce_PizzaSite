<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route as RouteFacade;

// One-time migration route for production database setup
// Visit: https://jonas-pizza.vercel.app/setup-database?key=migrate2026
RouteFacade::get('/setup-database', function () {
    // Simple security check
    if (request('key') !== 'migrate2026') {
        return response()->json(['error' => 'Unauthorized'], 403);
    }
    
    try {
        // Run migrations
        Artisan::call('migrate', ['--force' => true]);
        
        $output = Artisan::output();
        
        return response()->json([
            'success' => true,
            'message' => 'Database migrated successfully!',
            'output' => $output
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});
