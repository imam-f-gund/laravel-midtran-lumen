<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Midtrans\Config;
use App\Http\Controllers\Midtrans\CoreApi;

class PaymentsController extends Controller
{
    //
    public function bankTransferCharge(Request $req)
    {
        try {
            $transaction = array(
                "payment_type" => "bank_transfer",
                "transaction_details" => [
                    "gross_amount" => 10000,
                    "order_id" => date('Y-m-dHis')
                ],
                "customer_details" => [
                    "email" => "budi.utomo@Midtrans.com",
                    "first_name" => "Azhar",
                    "last_name" => "Ogi",
                    "phone" => "+628948484848"
                ],
                "item_details" => array([
                    "id" => "1388998298204",
                    "price" => 5000,
                    "quantity" => 1,
                    "name" => "Panci Miako"
                ], [
                    "id" => "1388998298202",
                    "price" => 5000,
                    "quantity" => 1,
                    "name" => "Ayam Geprek"
                ]),
                "bank_transfer" => [
                    "bank" => "bca",
                    "va_number" => "111111",
                ]
            );
                
            $charge = CoreApi::charge($transaction);
            if (!$charge) {
                return ['code' => 0, 'messgae' => 'Terjadi kesalahan'];
            }
            return ['code' => 1, 'messgae' => 'Success', 'result' => $charge];
        } catch (\Exception $e) {
            return ['code' => 0, 'messgae' => 'Terjadi kesalahan'];
        }
    }

    public function getTokenCC(Request $req)
    {
        try {
            $cc_data = [
                'client_key' => $req->client_key,
                'card_number' => $req->card_number,
                'card_exp_month' => $req->card_exp_month,
                'card_exp_year' => $req->card_exp_year,
                'card_cvv' => $req->card_cvv
            ];
            $data = http_build_query($cc_data);
                $token = CoreApi::getToken($data);
                $token_id = null;
                if ($token)
                    $token_id = json_decode($token->original)->token_id;

                return ['code' => 1, 'message' => 'Success', 'result' => $token_id];
                return ['code' => 1, 'message' => 'Success', 'result' => ['token' => $token]];
                } catch (\Exception $e) {
                    return ['code' => 0, 'message' => $e->getMessage(), 'result' => 'Terjadi kesalahan'];
                }
    }

    public function chargeCreditCard(Request $req)
    {
        try {
            $credit_card = array(
                'token_id' =>  $req->token_id,
                'authentication' => true,
                'bank' => "bni"
            );
            $transaction = array(
                            "transaction_details" => [
                                "gross_amount" => 10000,
                                "order_id" => date('Y-m-dHis')
                            ],
                            "customer_details" => [
                                "email" => "maemunyah@Midtrans.com",
                                "first_name" => "Azhar",
                                "last_name" => "Ogi",
                                "phone" => "+628948484848"
                            ],
                            "item_details" => array([
                                "id" => "1388998298204",
                                "price" => 5000,
                                "quantity" => 1,
                                "name" => "Ayam Zozozo"
                            ], [
                                "id" => "1388998298202",
                                "price" => 5000,
                                "quantity" => 1,
                                "name" => "Ayam Xoxoxo"
                            ]),
                        );
            $transaction['payment_type'] = "credit_card";
                        $transaction['credit_card'] = $credit_card;
            $result = CoreApi::charge($transaction);
                        if (!$result)
                            return ['code' => 0, 'message' => 'Something wrong | Internal Charge Credit Card'];
            return ['code' => 1, 'message' => 'Success', 'result' => $result];
                    } catch (\Exception $e) {
                        return ['code' => 0, 'message' => $e->getMessage(),'Something wrong | Internal Charge Credit Card'];
                    }
    }

}
