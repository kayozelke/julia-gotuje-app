<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Image;

class DashboardController extends Controller {

    public function dashboardPanel(Request $request){
        
        $toastSuccessTitle = session('toastSuccessTitle', null);
        $toastSuccessDescription = session('toastSuccessDescription', null);
        $toastSuccessHideTime = session('toastSuccessHideTime', null);
        $toastErrorTitle = session('toastErrorTitle', null);
        $toastErrorDescription = session('toastErrorDescription', null);
        $toastErrorHideTime = session('toastErrorHideTime', null);

        $publicated_posts_count = 'N/A';
        $images_count = 'N/A';

        // get posts count that are not hidden (is_hidden = 0) and where the value at column hide_before_time is null or time at value is in the past
        try { 
            $publicated_posts_count = Post::where('is_hidden', 0)
                ->where(function ($query) {
                    $query->whereNull('hide_before_time')
                        ->orWhere('hide_before_time', '<', now());
                })
                ->count();
        } catch (\Exception $e) {
            $publicated_posts_count = 'N/A';
        }

        try { 
            $images_count = Image::count();
        } catch (\Exception $e) {
            $images_count = 'N/A';
        }

        // get disk space
        $disk_usage = $this->getDiskUsage();
        
        
        return view('panel.auth.dashboard', [
            'publicated_posts_count' => $publicated_posts_count,
            'images_count' => $images_count,
            'disk_space' => $disk_usage,

            'toastSuccessTitle' => "$toastSuccessTitle",
            'toastSuccessDescription' => "$toastSuccessDescription",
            'toastSuccessHideTime' => $toastSuccessHideTime,
            'toastErrorTitle' => $toastErrorTitle,
            'toastErrorDescription' => $toastErrorDescription,
            'toastErrorHideTime' => $toastErrorHideTime,
        ]);
    }


    private function getDiskUsage()
    {
        // Ścieżka do głównego dysku serwera
        $path = '/'; // Zmień na inną ścieżkę, jeśli używasz innego dysku, np. '/home', '/var/www'

        // Całkowita pamięć
        $totalSpace = disk_total_space($path);

        // Wolna pamięć
        $freeSpace = disk_free_space($path);

        // Używana pamięć
        $usedSpace = $totalSpace - $freeSpace;

        // Wartości w MB/GB
        return [
            'total_space' => $this->formatBytes($totalSpace),
            'free_space' => $this->formatBytes($freeSpace),
            'used_space' => $this->formatBytes($usedSpace),
        ];
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
    

}
