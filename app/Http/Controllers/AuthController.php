<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Status;
class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function setDoiSoat(Request $request){
        $request->validate([
            "ngayDoiSoat" =>'required|numeric'
        ]);
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $doisoat = ['doisoat'=>$request->ngayDoiSoat];
        $user->update($doisoat);

        $data =[
            "status"=> "1",
            "message"=>"ok",
            "results"=>$request->ngayDoiSoat,
        ];
        return response()->json($data);

    }
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->save();
        $results =[
            'name' => $request->name,
            'email' => $request->email,
        ];
        $data = [
            'messaage' => 'Successfully created user!',
            'status'=>'201',
            'results'=>$results,
        ];
        return response()->json($data);
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();


        $results =[
           'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ];
        $data = [
            'messaage' => 'Successfully login !',
            'status'=>'200',
            'results'=>$results,
        ];
        return response()->json($data);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([

            'message' => 'Successfully logged out',
            'status' => '200',
            'results' => null,

        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
  
     public function user(Request $request)
    {
        $user = Auth::user();

        $data = [
            'messaage' => 'Successfully login !',
            'status'=>'200',
            'results'=>$user,
        ];
        return response()->json($data);
    }

    public function test(){
        $data = Status::all();
            return response()->json($data);
    }
}