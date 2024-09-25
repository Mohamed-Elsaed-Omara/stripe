<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StripeService;

class PaymentController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function checkout(Request $request)
    {
        //$request->validate(['amount' => 'required|numeric']);

        $session = $this->stripeService->createCheckoutSession(
            $request->amount,
            'usd',
            route('checkout.success'),
            route('checkout.cancel')
        );

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        if ($sessionId) {
            $session = $this->stripeService->retrieveCheckoutSession($sessionId);
            dd($session);
        }else {
            return 'No session ID found';
        }
    }


    public function cancel()
    {
        return 'Payment canceled!';
    }
}
