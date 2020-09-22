<?php
namespace Zuma\PosConfig\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Utils\VisaUtils;
use App\VisaConfiguration;
use App\ZumaUser;
use Illuminate\Http\Request;

class PosConfigController extends Controller {

    public function get(Request $request, $id) {
        $config = VisaConfiguration::where('user_id', $id)->first();
        if (!$config) {
            return [
                'payments' => '030609',
                'open_tip' => false,
                'closed_tip' => false,
                'automatic_closure' => false,
                'signature_amount' => 100000000000,
                'user_id' => $id,
                'pos_pin' => '0000',
            ];
        }

        return $config;
    }

    public function update(Request $request, $id) {
        $user = ZumaUser::find($id);
        $response = VisaUtils::updateParameters($user, []);
        if ($response['success'] == 1) {
            VisaConfiguration::updateOrCreate([
                'user_id' => $id,
            ], [
                'payments' => $request->payments ?? "",
                'open_tip' => $request->open_tip,
                'closed_tip' => $request->closed_tip,
                'signature_amount' => $request->signature_amount,
                'automatic_closure' => $request->automatic_closure,
                'pos_pin' => $request->pos_pin,
            ]);
        }

        return $response;
    }
}