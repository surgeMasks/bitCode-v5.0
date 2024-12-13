<?php
   namespace App\Traits;
   trait OnlinePurchaseHash {

     protected function sendingHash($order_id, $price)
    {
        $hash = strtoupper(md5(
                            config('env.PAYHERE_MERCHANT_ID') .
                            $order_id .
                            $price .
                            'LKR' .
                            strtoupper(md5(config('env.PAYHERE_MERCHANT_SECRET')))
                    )
        );

        return $hash;
    }

    protected function receivedHash($request)
    {
        $merchant_id = $request['merchant_id'];
        $order_id = $request['order_id'];
        $payhere_amount = $request['payhere_amount'];
        $payhere_currency = $request['payhere_currency'];
        $status_code = $request['status_code'];

        $hash = strtoupper(md5(
            $merchant_id .
            $order_id .
            $payhere_amount .
            $payhere_currency .
            $status_code .
            strtoupper(md5(config('env.PAYHERE_MERCHANT_SECRET')))
        ));

        return $hash;
    }

}
