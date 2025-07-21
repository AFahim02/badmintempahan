<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Telegram\Bot\Api;

class PaymentController extends Controller
{
    private $userSecretKey;
    private $categoryCode;

    public function __construct()
    {
        $this->userSecretKey = env('TOYYIBPAY_USER_SECRET_KEY');
        $this->categoryCode = env('TOYYIBPAY_CATEGORY_CODE');
    }

    public function createBill(Request $request)
    {
        try {
            // Retrieve reservation details
            $reservation = Reservation::findOrFail($request->reservation_id);
            Log::info('Reservation Fee: ' . $reservation->fee);

            $billData = [
                'userSecretKey' => $this->userSecretKey,
                'categoryCode' => $this->categoryCode,
                'billName' => 'BadminTempahan Reservation',
                'billDescription' => 'Reservation on ' . $reservation->reservation_date,
                'billPriceSetting' => 1,
                'billPayorInfo' => 1,
                'billAmount' => $reservation->fee * 100, // Convert to cents
                'billReturnUrl' => route('payment.callback', ['reservation_id' => $reservation->id]), // Callback URL
                'billCallbackUrl' => route('payment.callback', ['reservation_id' => $reservation->id]), // Callback URL
                'billEmail' => Auth::user()->email,
                'billPhone' => $reservation->contact_number,
                'billTo' => Auth::user()->name,
            ];

            Log::info('Sending payment request: ', $billData);

            // Make the API request to ToyyibPay
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_URL, env('TOYYIBPAY_BASE_URL') . '/index.php/api/createBill');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $billData);

            $result = curl_exec($curl);
            if (curl_errno($curl)) {
                Log::error('cURL error: ' . curl_error($curl), []); // Provide an empty array
            }
            curl_close($curl);

            $response = json_decode($result, true);
            Log::info('ToyyibPay API Response:', ['response' => $response]); // Correctly logging as an array

            if (isset($response[0]['BillCode'])) {
                // Redirect to ToyyibPay page
                return redirect(env('TOYYIBPAY_BASE_URL') . $response[0]['BillCode']);
            } else {
                Log::error('Failed to create bill:', ['response' => $response]); // Correctly logging as an array
                return redirect()->back()->withErrors(['error' => 'Failed to create bill.']);
            }
        } catch (ModelNotFoundException $e) {
            Log::error('Reservation not found: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Reservation not found.']);
        } catch (Exception $e) {
            Log::error('An error occurred while creating the bill: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'An error occurred.']);
        } // <-- Add this closing brace to close the try block
    } // <-- Add this closing brace to close the createBill method

    public function callback(Request $request)
    {
        Log::info('Payment Callback Data:', $request->all());

        try {
            // Retrieve the reservation ID from the callback (billExternalReferenceNo, externalReferenceNo, or order_id)
            $reservationId = $request->input('billExternalReferenceNo');
            if (empty($reservationId)) {
                $reservationId = $request->input('externalReferenceNo');
                if (empty($reservationId)) {
                    $reservationId = $request->input('order_id');
                    if (!empty($reservationId)) {
                        Log::info('Using order_id as reservation ID', ['order_id' => $reservationId]);
                    } else {
                        Log::warning('billExternalReferenceNo, externalReferenceNo, and order_id not found', $request->all());
                    }
                } else {
                    Log::info('Using externalReferenceNo as reservation ID', ['externalReferenceNo' => $reservationId]);
                }
            }

            if (empty($reservationId)) {
                Log::error('Missing reservation ID in callback.');
                return response()->json(['status' => 'error', 'message' => 'Missing reservation ID.'], 400);
            }

            // Find the reservation by ID
            $reservation = Reservation::findOrFail($reservationId);

            // Get payment details from the callback
            $paymentStatus = $request->input('status_id'); // Use status_id from the callback
            $refno = $request->input('transaction_id'); // Using transaction_id for reference
            $reason = $request->input('msg', 'No reason provided'); // Use msg for reason
            $billcode = $request->input('billcode');

            // Retrieve the amount directly from the reservation fee
            $amountReceived = $reservation->fee; // Get the original fee from the reservation

            // Convert to cents if needed
            $amountReceivedInCents = $amountReceived;

            Log::info('Payment Status Received: ' . $paymentStatus);
            Log::info('Amount Retrieved from Reservation: ' . $amountReceivedInCents);
            Log::info('User ID from Reservation: ' . $reservation->user_id);

            // Create or update the payment record with user_id from reservation
            $payment = Payment::updateOrCreate(
                ['reservation_id' => $reservation->id],
                [
                    'status' => $paymentStatus == 1 ? 'success' : ($paymentStatus == 2 ? 'pending' : 'failed'),
                    'amount' => $amountReceivedInCents, // Store the amount retrieved from the reservation
                    'refno' => $refno,
                    'reason' => $reason,
                    'billcode' => $billcode,
                    'user_id' => $reservation->user_id, // Use user_id from reservation
                ]
            );

            Log::info('Payment record updated successfully: ', $payment->toArray());

            // Update the reservation's payment status
            $reservation->payment_status = ($paymentStatus == 1) ? 'success' : 'failed';
            $reservation->save();

            // Redirect based on payment status
            if ($paymentStatus == 1) {
                // Send Telegram notification if the user has a chat ID
                $user = User::find($reservation->user_id);
                if ($user && $user->telegram_chat_id) {
                    try {
                        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
                        $message = "✅ Payment received!\n\n" .
                            "Reservation ID: {$reservation->id}\n" .
                            "Venue: {$reservation->venue->name}\n" .
                            "Date: " . \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d') . "\n" .
                            "Time: " . \Carbon\Carbon::parse($reservation->start_time)->format('H:i') . " - " . \Carbon\Carbon::parse($reservation->end_time)->format('H:i') . "\n" .
                            "Amount: RM " . number_format($reservation->fee, 2) . "\n\n" .
                            "Thank you for your booking!";

                        $telegram->sendMessage([
                            'chat_id' => $user->telegram_chat_id,
                            'text' => $message,
                        ]);

                        Log::info('Telegram notification sent to user: ' . $user->id);
                    } catch (\Exception $e) {
                        Log::error('Telegram notification failed for user ' . $user->id . ': ' . $e->getMessage());
                    }
                }

                return redirect()->route('payment.success');
            } else {
                return redirect()->route('payment.failed'); // Redirect to failed page
            }
        } catch (ModelNotFoundException $e) {
            Log::error('Reservation not found: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Reservation not found.'], 404);
        } catch (Exception $e) {
            Log::error('An error occurred in the callback: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'An error occurred while processing the callback.'], 500);
        }
    }

    public function success(Request $request)
    {
        try {
            return view('reservations.success'); // Create a success view
        } catch (Exception $e) {
            Log::error('An error occurred while rendering the success view: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'An error occurred while processing your request.']);
        }
    }

    public function failed(Request $request)
    {
        return view('reservations.failed'); // Create a failed view
    }
}