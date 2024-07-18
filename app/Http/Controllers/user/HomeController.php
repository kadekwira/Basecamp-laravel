<?php

namespace App\Http\Controllers\user;

use Carbon\Carbon;
use App\Models\Konten;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{


    public function index(Request $request)
    {
        // Set the locale for Carbon
        Carbon::setLocale('id');
    
        // Set timezone if necessary
        $now = Carbon::now('Asia/Jakarta');
        $nowMySQLFormat = $now->toDateTimeString(); // Convert to MySQL datetime format

        // Use the formatted datetime in the query
        $kontenList = Konten::where('jadwal_post', '<=', $nowMySQLFormat)
                            ->where('jadwal_end', '>=', $nowMySQLFormat)
                            ->first();
        
                            
        return view('user.index', compact('kontenList'));
    }
    
}
