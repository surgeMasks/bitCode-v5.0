<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseStatusEnum;
use App\Models\Project;
use App\Models\Purchase;
use App\Traits\FileTrait;
use App\Traits\OnlinePurchaseHash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    use OnlinePurchaseHash;

public function onlineTransfer(Request $request, Project $project)
    {

        $user =  Auth::user();

        DB::beginTransaction();
        $purchase = Purchase::create([
            'total' => $project->price,
            'status' => PurchaseStatusEnum::PENDING,
            'user_id' => $user->id
        ]);

        $price = $project->price;

        $price = number_format($price, 2, '.', '');

        $order_id = $purchase->id;
        $hash = $this->sendingHash($order_id, $price);
        DB::commit();

        return response()->json([
            'order_id' => $order_id,
            'hash' => $hash,
            'price' => $price,
        ],200);
    }
}

