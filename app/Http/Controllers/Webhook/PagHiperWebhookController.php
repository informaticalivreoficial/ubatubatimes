<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PagHiperWebhookController extends Controller
{
    public function handle(Request $request)
    {
        if ($request->apiKey !== config('services.paghiper.api_key')) {
            abort(403);
        }

        $invoice = Invoice::where('external_id', $request->transaction_id)->first();

        if (!$invoice) return response()->json([]);

        if ($request->status === 'paid') {
            $invoice->markAsPaid();
        }

        if ($request->status === 'expired') {
            $invoice->markAsOverdue();
        }

        return response()->json(['ok' => true]);
    }
}
