<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $query = Plot::query();

        // Only show plots uploaded by admins that are approved and available for customers
        $query->whereHas('user', function($q) {
                $q->where('role', 'admin');
            })
            ->where('status', '!=', 'pending')
            ->where('status', '!=', 'rejected')
            ->whereIn('status', ['available', 'reserved']);

        // Search
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%")
                  ->orWhere('location', 'like', "%{$request->search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Price range filter
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Area range filter
        if ($request->filled('area_min')) {
            $query->where('area_sqm', '>=', $request->area_min);
        }
        if ($request->filled('area_max')) {
            $query->where('area_sqm', '<=', $request->area_max);
        }

        // Status filter (only available and reserved for customers)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // New listings filter
        if ($request->has('new_listings')) {
            $query->where('is_new_listing', true);
        }

        // Get statistics for all approved plots (not filtered by search/filters)
        $allPlotsQuery = Plot::whereHas('user', function($q) {
                $q->where('role', 'admin');
            })
            ->where('status', '!=', 'pending')
            ->where('status', '!=', 'rejected')
            ->whereIn('status', ['available', 'reserved']);

        $statistics = [
            'total_plots' => $allPlotsQuery->count(),
            'available_plots' => $allPlotsQuery->where('status', 'available')->count(),
            'avg_price' => $allPlotsQuery->where('status', 'available')->avg('price') ?? 0,
            'new_listings' => $allPlotsQuery->where('is_new_listing', true)->count(),
        ];

        // Order by newest first, then by views
        $plots = $query->with(['plotImages' => function($q) {
                        $q->orderBy('sort_order')->orderBy('is_primary', 'desc');
                    }])
                      ->orderBy('created_at', 'desc')
                      ->orderBy('views', 'desc')
                      ->paginate(9)
                      ->appends($request->except('page'));

        // For dropdowns - only show categories and locations from approved plots uploaded by admins
        $categories = ['residential', 'commercial', 'industrial'];
        $locations = Plot::whereHas('user', function($q) {
                $q->where('role', 'admin');
            })
            ->where('status', '!=', 'pending')
            ->where('status', '!=', 'rejected')
            ->select('location')
            ->distinct()
            ->pluck('location');
        $statuses = ['available', 'reserved'];

        return view('customer.plots.index', compact('plots', 'categories', 'locations', 'statuses', 'statistics'));
    }
    /**
     * Display the specified resource.
     */ 
    public function show(Plot $plot)
    {
        // Check if plot was uploaded by an admin
        if (!$plot->user || $plot->user->role !== 'admin') {
            abort(404, 'Land plot not found or not available.');
        }

        // Check if plot is approved and available for customers
        if ($plot->status === 'pending' || $plot->status === 'rejected') {
            abort(404, 'Land plot not found or not available.');
        }

        // Check if plot is sold and user doesn't own it
        if ($plot->status === 'sold' && optional($plot->activeReservation)->user_id !== Auth::id()) {
            abort(404, 'Land plot not found or not available.');
        }

        // Increment view count
        $plot->increment('views');

        return view('customer.plots.show', compact('plot'));
    }

}
