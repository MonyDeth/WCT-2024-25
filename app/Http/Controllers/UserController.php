<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        Auth::login($user);
        // return response()->json(['message' => 'User created', 'data' => $user]);
        return redirect()->route('dashboard')->with('success', 'Welcome!');
    }

    public function login(Request $request)
    {
        $body = request()->all();
        $email = $body['email'];
        $password = $body['password'];

        $user = User::where('email', $request->email)->first();

        if (!$user || !password_verify($request->password, $user->password)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
            return redirect('/')->withErrors(['login' => 'Invalid credentials']);
        }

        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'iat' => time(),
            'exp' => time() + 3600,
        ];

        $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        if ($request->expectsJson()) {
            return response()->json(['access_token' => $jwt]);
        }

        Auth::login($user);
        // return response()->json(['access_token' => $jwt]);
        return redirect()->route('dashboard')->with('success', 'Welcome back!');
        // return redirect('/')
        // ->with('success', 'Welcome back!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
