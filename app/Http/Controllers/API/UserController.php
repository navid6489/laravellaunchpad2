<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
class UserController extends Controller 
{
public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password'),'flag'=>'0'])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
           // return response()->json(['success' => $success], $this-> successStatus); 
           return view('dashboard');
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'role' => 'required', 
        ]);
if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
$input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
return response()->json(['success'=>$success], $this-> successStatus); 
    }
/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 
    public function delete($id) 
    { 
       // $user = Auth::user();
        $user = User::findOrFail($id); 
        $user->delete();
       // return User::destroy($id); 
        return response()->json(['success' => $user ,'message'=>'Deleted Successfully' ], $this-> successStatus); 
    } 
    public function update($id,Request $request) 
    { 

        
       // $user = Auth::user();
        $user = User::findOrFail($id); 
        $input = $request->all(); 
        //$new_user_data = array("name"=>"", "password"=>"$input['password']");
        $user->name=$input['name'];
        $user->password=$input['password'];
        $user->save();
        return response()->json(['success' => $user ,'message'=>'Updated Successfully' ], $this-> successStatus); 
    } 
}