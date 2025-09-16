<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\User;
use App\Models\Payment;

class PagesController extends Controller
{
    public function home()
    {
        // Get popular classes for homepage
        $popularClasses = Classes::with(['tutor', 'payments'])
            ->where('status', 'active')
            ->withCount('payments')
            ->orderBy('payments_count', 'desc')
            ->take(6)
            ->get();
            
        return view('pages.home', compact('popularClasses'));
    }

    public function learning()
    {
        // Get all active classes with filtering and pagination
        $query = Classes::with(['tutor', 'payments'])
            ->where('status', 'active');
            
        // Filter by category if provided
        if (request('category') && request('category') !== 'all') {
            $query->where('category', request('category'));
        }
        
        // Search functionality
        if (request('search')) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . request('search') . '%')
                  ->orWhere('description', 'like', '%' . request('search') . '%');
            });
        }
        
        $classes = $query->latest()->paginate(12);
        
        // Get unique categories for filter
        $categories = Classes::where('status', 'active')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');
            
        return view('pages.learning', compact('classes', 'categories'));
    }

    public function bootcamp()
    {
        // Get bootcamp/intensive classes
        $bootcampClasses = Classes::with(['tutor', 'payments'])
            ->where('status', 'active')
            ->where(function ($q) {
                $q->where('category', 'like', '%bootcamp%')
                  ->orWhere('category', 'like', '%intensive%');
            })
            ->latest()
            ->get();
            
        return view('pages.bootcamp', compact('bootcampClasses'));
    }

    public function webinar()
    {
        // Get webinar classes
        $webinarClasses = Classes::with(['tutor', 'payments'])
            ->where('status', 'active')
            ->where('category', 'like', '%webinar%')
            ->latest()
            ->get();
            
        return view('pages.webinar', compact('webinarClasses'));
    }

    public function deskripsibootcamp()
    {
        return view('pages.deskripsi_bootcamp');
    }

    public function detailKursus()
    {
        // Get class details by ID if provided
        $classId = request('id');
        $class = null;
        
        if ($classId) {
            $class = Classes::with(['tutor', 'payments', 'tasks'])
                ->where('status', 'active')
                ->findOrFail($classId);
        }
        
        return view('pages.detail_kursus', compact('class'));
    }

    public function formPayments()
    {
        $classId = request('class_id');
        $class = null;
        
        if ($classId) {
            $class = Classes::with('tutor')
                ->where('status', 'active')
                ->findOrFail($classId);
        }
        
        return view('pages.form_payments', compact('class'));
    }

    public function beliSekarang()
    {
        return view('pages.beli_sekarang');
    }

    public function formPendaftaran()
    {
        return view('pages.form_pendaftaran');
    }

    public function kelas()
    {
        // Get all classes with filtering
        $query = Classes::with(['tutor', 'payments'])
            ->where('status', 'active');
            
        // Filter by category
        if (request('category') && request('category') !== 'all') {
            $query->where('category', request('category'));
        }
        
        // Search functionality
        if (request('search')) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . request('search') . '%')
                  ->orWhere('description', 'like', '%' . request('search') . '%');
            });
        }
        
        $classes = $query->latest()->paginate(12);
        
        // Get categories for filter
        $categories = Classes::where('status', 'active')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');
            
        return view('pages.kelas', compact('classes', 'categories'));
    }

    public function checkout()
    {
        // kalau nanti checkout butuh data kelas/pembayaran, bisa dioper dari sini
        return view('pages.checkout');
    }
}
