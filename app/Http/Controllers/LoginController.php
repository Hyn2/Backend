<?php

namespace App\Http\Controllers;

use App\Helpers\ValidateHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct(protected ValidateHelper $valiHelper) {

    }

    public function __invoke(Request $request) {
        try {
            $credentials = $request->validate([
                'id' => 'required',
                'password' => 'required',
            ]);
          } catch(ValidationException $e) {
            $errMsg = $e->errors();
            $status = $e->status;
            return response()->json(['error' => $errMsg], $status);
        }
        // 주어진 ID를 통해 유저검색, password hashing 을 통해 비밀번호 비교 후 인증
        if(Auth::attempt([
            'id' => $credentials['id'],
            'password' => $credentials['password']
        ])) {
            $request->session()->regenerate();
            return response()->json($request->user());
        }

        return response()->json([
            'error' => '아이디 또는 비밀번호가 일치하지 않습니다.',
        ], 401);
    }
}
