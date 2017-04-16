<?php namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(['users' => User::all()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if (!$token = JWTAuth::attempt($request->only(['email', 'password']))) {
            return response()->json(['result' => 'wrong email or password.']);
        }

        return response()->json(['result' => $token]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $attributes = $request->only(['name', 'email', 'password']);

        $user = new User;
        if (!$user->validate($attributes)) {
            return response()->json([
                'success' => false,
                'attributes' => $attributes,
                'errors' => $user->errors(),
            ]);
        }

        $attributes['password'] = Hash::make($attributes['password']);
        User::create($attributes);

        return response()->json(['success' => true]);
    }

    /**
     * @param string $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirm($code)
    {
        switch (true) {
            case empty($code):
                return response()->json([
                    'success' => false,
                    'errors' => ['code' => 'Empty required param'],
                ]);
            case !is_string($code):
                return response()->json([
                    'success' => false,
                    'errors' => ['code' => 'Wrong format: ' . var_export($code, true)],
                ]);
            case !($user = User::where('activation_code', $code)->orderBy('id', 'desc')->first()):
                return response()->json([
                    'success' => false,
                    'errors' => ['code' => 'User not found'],
                ]);
        }

        $user->activation_code = null;
        $user->activation_status = 1;
        $user->save();

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_user_details(Request $request)
    {
        $input = $request->all();
        $user = JWTAuth::toUser($input['token']);

        return response()->json(['result' => $user]);
    }

}
