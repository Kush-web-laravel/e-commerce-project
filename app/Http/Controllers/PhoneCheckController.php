<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;

class PhoneCheckController extends Controller
{
    public function validatePhone(Request $request)
    {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();

        try {
            $phoneNumber = $phoneNumberUtil->parse($request->phone, $request->countryCode);

            if ($phoneNumberUtil->isValidNumber($phoneNumber)) {
                $formattedNumber = $phoneNumberUtil->format($phoneNumber, PhoneNumberFormat::E164);
                return view('phone-auth', [
                    'valid' => true,
                    'formatted' => $formattedNumber,
                    'message' => 'Valid phone number',
                ]);
            } else {
                return view('phone-auth', [
                    'valid' => false,
                    'message' => 'Invalid phone number',
                ]);
            }
        } catch (NumberParseException $e) {
            Log::error($e);
            return view('phone-auth', [
                'valid' => false,
                'message' => 'Invalid phone number format',
            ]);
        }
    }

    public function showPhoneAuthForm()
    {
        return view('phone-auth');
    }
}