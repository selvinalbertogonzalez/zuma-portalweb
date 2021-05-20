<?php

namespace App\Utils;
use Exception;
use App\ZumaUser;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
// use Log;

class VisaUtils {
    public static function getCredentials($user, $password, $serial, $affiliation) {
        $requestBody = [
            "MESSAGETYPEID" => "0200",
            "PROCESSINGCODE" => "580000",
            "SYSTEMTRACENO" => "000000",
            "NII" => "003",
            "POSCONDITIONCODE" => "00",
            "TERMINALID" => $serial,
            "CARDACQID" => $affiliation,
            "CONFIGTERMINALID" => [
                "USER" => $user,
                "PASSWORD" => $password,
                "CAJAMULTIPLE" => "",
                "NAMEPOS" => "APPMOBILE",
                "VERPOS" => "1.0.0.15",
            ],
        ];
        $client = new Client([
            'base_uri' => env('VISA_URL'),
            // 'curl' => [
            //     CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            // ],
        ]);
        try {
            $response = $client->request('POST', '/api/paymentretail/AuthorizationRequest', ['json' => $requestBody]);
            $responseBody = json_decode($response->getBody()->getContents(), true);
            if ($responseBody['Responsecode'] == '00') {
                $credentialsResponse = $responseBody['Configterminalid'];

                return ['success' => 1, 'message' => 'generated_sucessfully', 'username' => $credentialsResponse['User'], 'password' => $credentialsResponse['Password']];
            } else {
                Log::info($responseBody['Privateuse63']['Alternatehostresponse22']);

                return ['success' => 0, 'message' => $responseBody['Privateuse63']['Alternatehostresponse22']];
            }
        } catch (ClientException $e) {
            Log::info($e->getRequest()->getBody());
            Log::info($e->getResponse()->getBody());

            return ['success' => 0, 'message' => 'client_error'];
        } catch (ServerException $e) {
            Log::info($e->getRequest()->getBody());
            Log::info($e->getResponse()->getBody());

            return ['success' => 0, 'message' => 'server_error'];

        } catch (Exception $e) {
            Log::info($e->getMessage());

            return ['success' => 0, 'message' => 'unknown_error'];
        }
    }

    public static function updateParameters(ZumaUser $user, array $parameters) {
        $requestBody = [
            "MESSAGETYPEID" => "0200",
            "PROCESSINGCODE" => "590000",
            "SYSTEMTRACENO" => "000000",
            "POSENTRYMODE" => "022",
            "NII" => "003",
            "POSCONDITIONCODE" => "00",
            "TERMINALID" => $user->serial,
            "CARDACQID" => $user->affiliation,
            "MESSAGEAUTHCODE" => "",
            "CONFIGTERMINALID" => [
                "USER" => $user->affiliation_user,
                "PASSWORD" => $user->affiliation_password,
                "CAJAMULTIPLE" => "",
                "VERCM" => "5.0.0.0",
                "SERIALPINPAD" => "",
                "VERAGENTEEMV" => "3.0.0.12",
                "IMK" => "8",
                "NAMEPOS" => "APPMOBILE",
                "VERPOS" => "1.0.0.15",
                "PAYMENTGWIP" => "",
                "SHOPPERIP" => "",
                "MERCHANTSERVERIP" => "",
                "MERCHANTUSER" => $user->VisaUser,
                "MERCHNATPASSWORD" => $user->VisaPassword,
                "ROUTE" => "",
                "FORMATID" => "1",
                "DEFAULTTERMINAL" => [
                    "AUTOMATICSETTLE" => "0",
                    "MANUALENTRY" => "1",
                    "PINONLINE" => "0.01",
                    "EPS" => "1",
                    "EPSLIMIT" => "20000",
                    "NOCVM" => "0",
                    "COUNTRYCODE" => "",
                    "CURRENCYCODE" => "",
                    "SIGNCURRENCY" => "Q",
                    "FLOORLIMIT" => "0",
                    "TRIEFALLBACKS" => "2",
                    "PRINTCLIENTCVM" => "1",
                    "INSTANWINNER" => "0",
                    "INSTANWINNERCOMMERCE" => "0",
                    "INSTANWINNERCLIENT" => "0",
                    "INSTANWINNERTHIRD" => "0",
                    "PPASSTRANSLIMIT" => "0",
                    "PPASSCVMLIMIT" => "0",
                    "PPASSFLOORLIMIT" => "0",
                    "PWAVETRANSLIMIT" => "0",
                    "PWAVECVMLIMIT" => "0",
                    "PWAREFLOORLIMIT" => "0",
                    "VC" => "1",
                    "VCUOTAS" => "03060918",
                    "EF" => "0",
                    "EFCUOTAS" => "1218243648",
                    "CE" => "0",
                    "CECUOTAS" => "03061224",
                    "VD" => "0",
                    "CB" => "0",
                    "LU" => "0",
                    "PM" => "0",
                    "TIP" => "0",
                    "TYPETIP" => "",
                    "TIPPERCENTAGE" => "010015020030",
                    "ADJUSTTIPSETT" => "0",
                    "SPLITACCOUNT" => "1",
                    "PRINTSPLITBALANCE" => "1",
                    "MAXPERCENTAGETIP" => "10",
                    "PRINTPAGARE" => "1",
                    "CHECKINCHECKOUT" => "1",
                    "TIMEOUTIDLE" => "240",
                    "TIMEOUTINPUTCARD" => "35",
                    "TIMEOUAUTORIZATION" => "60",
                    "TIMEOUTSIGN" => "59",
                    "TIMEOUTREMOVECARD" => "71",
                    "TOURISTTAXPERCENTAGE" => "",
                ],
            ],
        ];
        $client = new Client(['base_uri' => env('VISA_URL')]);
        try {
            $response = $client->request('POST', '/api/paymentretail/AuthorizationRequest', ['json' => $requestBody]);
            $responseBody = json_decode($response->getBody()->getContents(), true);
            if ($responseBody['Responsecode'] == '00') {

                return ['success' => 1, 'message' => 'configured_successfully'];
            } else {
                return ['success' => 0, 'message' => $responseBody['Privateuse63']['Alternatehostresponse22']];
            }
        } catch (ClientException $e) {
            Log::info($e->getResponse()->getBody());

            return ['success' => 0, 'message' => 'client_error'];
        } catch (Exception $e) {
            return ['success' => 0, 'message' => 'unknown_error'];
        }
    }
}