<?php

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Helper;
use App\Helpers\Security;
use App\Models\ChargeItem;
use App\Models\Payment;

class PaymentController extends AdminController
{
    /**
     * Show the form for manually registering a payment for a charge item.
     */
    public function create($chargeItemId)
    {
        $chargeItem = ChargeItem::find($chargeItemId);
        if (!$chargeItem) die('Charge item not found.');

        // You might want to pass more details to the view, like unit and building info.
        require_once dirname(__DIR__) . '/../templates/payments/create.php';
    }

    /**
     * Store a new manual payment in the database.
     */
    public function store($chargeItemId)
    {
        Security::checkCsrf();

        $chargeItem = ChargeItem::find($chargeItemId);
        if (!$chargeItem) die('Charge item not found.');

        // In a real app, you would add validation here.

        $paymentData = [
            'charge_item_id' => $chargeItemId,
            'user_id' => $chargeItem->user_id, // Assuming the payment is for the user associated with the unit
            'amount' => $_POST['amount'],
            'payment_method' => 'manual',
            'transaction_ref' => $_POST['transaction_ref'],
            'paid_at' => $_POST['paid_at'],
            'status' => 'completed',
            'verified_by' => Auth::id(),
        ];

        if (Payment::create($paymentData)) {
            $_SESSION['success'] = 'پرداخت با موفقیت ثبت شد.';
            // Redirect back to the charge details page.
            Helper::redirect("/admin/buildings/{$chargeItem->charge->building_id}/charges/{$chargeItem->charge_id}");
        } else {
            $_SESSION['errors'] = ['general' => ['خطایی در ثبت پرداخت رخ داد.']];
            Helper::redirect("/admin/payments/create/{$chargeItemId}");
        }
    }

    // Placeholder for online payment callback
    public function callback()
    {
        // This is where the online payment gateway would redirect the user back to.
        // You would typically receive POST data from the gateway, verify the transaction,
        // and then create the payment record.

        echo "<h1>این یک درگاه پرداخت آزمایشی است.</h1>";
        echo "<p>در یک برنامه واقعی، اینجا اطلاعات تراکنش از درگاه دریافت و پردازش می‌شود.</p>";
        // Here you would call Payment::create() with the gateway's data.
    }
}
