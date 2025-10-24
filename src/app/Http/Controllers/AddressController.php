<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\AddressRequest;

class AddressController extends Controller
{
    public function edit($item_id)
    {
        $user = Auth::user();
        return view('mypage.address_edit', compact('user', 'item_id'));
    }

    public function update(AddressRequest $request, $item_id)
    {
        $user = Auth::user();
        $user->update($request->only(['postal_code', 'address', 'building_name']));

        return redirect()->route('purchase', ['item_id' => $item_id])
            ->with('message', '住所を更新しました');
    }
}
