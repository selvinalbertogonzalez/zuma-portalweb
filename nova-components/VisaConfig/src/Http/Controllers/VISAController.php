<?php

namespace Zuma\VisaConfig\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Notifications\ConfiguredVisa;
use App\Utils\VisaUtils;
use App\ZumaUser;
use Illuminate\Http\Request;

class VISAController extends Controller {
    public function validate(Request $request, array $rules = [], array $messages = [], array $customAttributes = []) {
        $user = ZumaUser::where('Correo', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'email_not_found']);
        }
        if ($user->affiliation !== null || $user->serial !== null) {
            return response()->json(['message' => 'already_registered']);
        }
        $credentialsResponse = VisaUtils::getCredentials($request->user, $request->password, $request->serial, $request->affiliation);
        if ($credentialsResponse['success'] == 0) {
            //failed
            return response()->json(['message' => 'invalid_credentials']);
        } else {
            $user->serial = $request->serial;
            $user->affiliation = $request->affiliation;
            $user->affiliation_user = $request->user;
            $user->affiliation_password = $request->password;
            $user->VisaUser = $credentialsResponse["username"];
            $user->VisaPassword = $credentialsResponse["password"];
            $user->save();
            $user->notify(new ConfiguredVisa);
            //succeed

            return response()->json(['message' => 'registered_successfully']);
        }
    }
}