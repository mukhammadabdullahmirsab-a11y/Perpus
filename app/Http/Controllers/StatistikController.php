<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailTransaksi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatistikController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('periode', 'all_time');
        $startDate = null;
        $endDate = null;

        if ($filter == 'today') {
            $startDate = Carbon::today();
            $endDate = Carbon::today()->endOfDay();
        } elseif ($filter == 'this_month') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } elseif ($filter == 'this_year') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        } elseif ($filter == 'custom') {
            $startDate = $request->from ? Carbon::parse($request->from)->startOfDay() : null;
            $endDate = $request->to ? Carbon::parse($request->to)->endOfDay() : null;
        }

        // Base query for filtered results
        $baseQuery = function($q) use ($startDate, $endDate) {
            $q->whereHas('transaksi', function($t) use ($startDate, $endDate) {
                if ($startDate) $t->where('tanggal_pinjam', '>=', $startDate);
                if ($endDate) $t->where('tanggal_pinjam', '<=', $endDate);
                $t->whereIn('status', ['dipinjam', 'dikembalikan']); // Only valid transactions
            });
        };

        // 1. Top 10 Borrowed Books
        $topBooks = DetailTransaksi::select('buku_id', DB::raw('SUM(jumlah) as total'))
            ->where($baseQuery)
            ->with('buku')
            ->groupBy('buku_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // 2. Least/Bottom 10 Borrowed Books (Limited to those with at least one record in DetailTransaksi if filtered, or all if not)
        // For better "professional" feel, we show books that have low total counts
        $bottomBooks = DetailTransaksi::select('buku_id', DB::raw('SUM(jumlah) as total'))
            ->where($baseQuery)
            ->with('buku')
            ->groupBy('buku_id')
            ->orderBy('total', 'asc')
            ->limit(10)
            ->get();

        // 3. Category Distribution
        $categoryData = DetailTransaksi::select('kategoris.nama_kategori', DB::raw('SUM(detail_transaksi.jumlah) as total'))
            ->join('bukus', 'detail_transaksi.buku_id', '=', 'bukus.id')
            ->join('kategoris', 'bukus.kategori_id', '=', 'kategoris.id')
            ->whereHas('transaksi', function($t) use ($startDate, $endDate) {
                if ($startDate) $t->where('tanggal_pinjam', '>=', $startDate);
                if ($endDate) $t->where('tanggal_pinjam', '<=', $endDate);
                $t->whereIn('status', ['dipinjam', 'dikembalikan']);
            })
            ->groupBy('kategoris.nama_kategori')
            ->orderByDesc('total')
            ->get();

        return view('admin.statistik.index', compact(
            'topBooks', 
            'bottomBooks', 
            'categoryData', 
            'filter', 
            'startDate', 
            'endDate'
        ));
    }
}
