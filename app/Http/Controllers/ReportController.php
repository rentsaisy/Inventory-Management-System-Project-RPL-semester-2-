<?php

namespace App\Http\Controllers;

use App\Models\IncomingTransaction;
use App\Models\OutgoingTransaction;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function monthlyReport()
    {
        $currentMonth = now();
        
        // Get incoming transactions for current month
        $incomingTransactions = IncomingTransaction::whereMonth('transaction_date', $currentMonth->month)
            ->whereYear('transaction_date', $currentMonth->year)
            ->with(['product', 'supplier'])
            ->get();
        
        // Get outgoing transactions for current month
        $outgoingTransactions = OutgoingTransaction::whereMonth('transaction_date', $currentMonth->month)
            ->whereYear('transaction_date', $currentMonth->year)
            ->with(['product', 'customer'])
            ->get();
        
        // Calculate totals (price * quantity)
        $incomingTotal = $incomingTransactions->sum(fn($tx) => $tx->price * $tx->quantity);
        $outgoingTotal = $outgoingTransactions->sum(fn($tx) => $tx->price * $tx->quantity);
        
        // Count by type
        $incomingCount = $incomingTransactions->count();
        $outgoingCount = $outgoingTransactions->count();
        
        return view('stock-movements.monthly-report', [
            'currentMonth' => $currentMonth,
            'incomingTransactions' => $incomingTransactions,
            'outgoingTransactions' => $outgoingTransactions,
            'incomingTotal' => $incomingTotal,
            'outgoingTotal' => $outgoingTotal,
            'incomingCount' => $incomingCount,
            'outgoingCount' => $outgoingCount,
        ]);
    }
}
