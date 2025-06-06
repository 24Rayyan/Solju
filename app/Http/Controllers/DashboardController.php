<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $filter = $request->get('filter', '12bulan'); // default 12 bulan
        $now = Carbon::now();

        switch ($filter) {
            case '24jam':
                $startDate = $now->copy()->subDay();
                $groupByFormat = '%Y-%m-%d %H:00';
                break;
            case '7hari':
                $startDate = $now->copy()->subDays(7);
                $groupByFormat = '%Y-%m-%d';
                break;
            case '30hari':
                $startDate = $now->copy()->subDays(30);
                $groupByFormat = '%Y-%m-%d';
                break;
            case '12bulan':
            default:
                $startDate = $now->copy()->subMonths(12);
                $groupByFormat = '%Y-%m';
                break;
        }

        // Invoice dengan filter berdasarkan periode yang dipilih
        $invoiceBelumLunas = Order::whereNull('payment_proof')
            ->whereBetween('created_at', [$startDate, $now])
            ->count();
        
        $invoiceLunas = Order::whereNotNull('payment_proof')
            ->whereBetween('created_at', [$startDate, $now])
            ->count();
        
        $totalProdukTerjual = OrderProduct::whereHas('order', function ($query) use ($startDate, $now) {
            $query->whereBetween('created_at', [$startDate, $now]);
        })->sum('quantity');

        // Total pemasukan saat ini
        $currentIncome = OrderProduct::whereHas('order', function ($query) use ($startDate, $now) {
            $query->whereBetween('created_at', [$startDate, $now]);
        })->selectRaw('SUM(quantity * price) as total')->value('total') ?? 0;

        // Total pemasukan periode sebelumnya
        switch ($filter) {
            case '24jam':
                $previousStart = $startDate->copy()->subDay();
                $previousEnd = $startDate;
                break;
            case '7hari':
                $previousStart = $startDate->copy()->subDays(7);
                $previousEnd = $startDate;
                break;
            case '30hari':
                $previousStart = $startDate->copy()->subDays(30);
                $previousEnd = $startDate;
                break;
            case '12bulan':
            default:
                $previousStart = $startDate->copy()->subMonths(12);
                $previousEnd = $startDate;
                break;
        }

        $previousIncome = OrderProduct::whereHas('order', function ($query) use ($previousStart, $previousEnd) {
            $query->whereBetween('created_at', [$previousStart, $previousEnd]);
        })->selectRaw('SUM(quantity * price) as total')->value('total') ?? 0;

        // Persentase kenaikan
        if ($previousIncome == 0) {
            $percentageChange = $currentIncome > 0 ? 100 : 0;
        } else {
            $percentageChange = (($currentIncome - $previousIncome) / $previousIncome) * 100;
        }

        // Penjualan per waktu
        $penjualan = OrderProduct::selectRaw("DATE_FORMAT(orders.created_at, '{$groupByFormat}') as period, SUM(order_products.quantity * order_products.price) as total")
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->where('orders.created_at', '>=', $startDate)
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        // Top Produk Terlaris dengan filter berdasarkan periode yang dipilih
        $topProducts = OrderProduct::selectRaw('name, SUM(quantity) as total_terjual, SUM(quantity * price) as nominal')
            ->whereHas('order', function ($query) use ($startDate, $now) {
                $query->whereBetween('created_at', [$startDate, $now]);
            })
            ->groupBy('name')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        return view('pages.orders.dashboard', compact(
            'invoiceBelumLunas',
            'invoiceLunas',
            'totalProdukTerjual',
            'penjualan',
            'filter',
            'currentIncome',
            'previousIncome',
            'percentageChange',
            'topProducts'
        ));
    }
}