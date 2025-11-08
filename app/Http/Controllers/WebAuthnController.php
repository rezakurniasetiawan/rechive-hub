<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WebAuthnController extends Controller
{
    public function registerChallenge(Request $request)
    {
        $user = Auth::user();
        $challenge = base64_encode(random_bytes(32));
        session(['webauthn_challenge' => $challenge]);

        return response()->json([
            'challenge' => $challenge,
            'user' => [
                'id' => base64_encode($user->id),
                'name' => $user->name,
                'displayName' => $user->name,
            ]
        ]);
    }

    public function registerCredential(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|string',
            'rawId' => 'required|string',
            'response' => 'required|array',
            'type' => 'required|string',
        ]);

        $user = Auth::user();

        DB::table('webauthn_credentials')->updateOrInsert(
            ['credential_id' => $data['id']],
            [
                'user_id' => $user->id,
                'public_key' => $data['response']['attestationObject'] ?? '',
                'sign_count' => 0,
            ]
        );

        return response()->json(['success' => true]);
    }

    public function loginChallenge()
    {
        $challenge = base64_encode(random_bytes(32));
        session(['webauthn_login_challenge' => $challenge]);
        return response()->json(['challenge' => $challenge]);
    }

    public function verifyLogin(Request $request)
    {
        $credentialId = $request->input('id');
        $credential = DB::table('webauthn_credentials')->where('credential_id', $credentialId)->first();

        if (!$credential) {
            return response()->json(['success' => false, 'message' => 'Credential not found.']);
        }

        Auth::loginUsingId($credential->user_id);
        return response()->json(['success' => true]);
    }

    // 🧩 Tambahan baru — Cek apakah user sudah mendaftarkan biometrik
    public function checkRegistration()
    {
        $user = Auth::user();

        $registered = DB::table('webauthn_credentials')
            ->where('user_id', $user->id)
            ->exists();

        return response()->json([
            'registered' => $registered
        ]);
    }
}