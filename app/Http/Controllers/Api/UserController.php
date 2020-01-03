<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use JWTAuth;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\VideoRepositoryInterface;
use Exception;
use Hash;
use Carbon\Carbon;

class UserController extends AppBaseController
{
    
    private $user;
    private $video;
    private $longest_streak;
    private $current_streak;
    private $day_streak;
    
    public function __construct(UserRepositoryInterface $user, VideoRepositoryInterface $video){
        $this->user = $user;
        $this->video = $video;
    }
    
    public function remove_from_favorite(Request $request){
        try
        {
        $user_id = $request->get('user_id');
        $post_id = $request->post_id;
        $type = $request->type;
        if (!$post_id or !$type){
            throw new Exception('Missing paramter');
        }
        $this->user->RemoveFromFavorite($user_id, $post_id, $type);
 
        return $this->sendResponse([]);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    
    public function add_to_favorite(Request $request){
        try
        {
        $user_id = $request->get('user_id');
        $post_id = $request->post_id;
        $type = $request->type;
        if (!$post_id or !$type){
            throw new Exception('Missing paramter');
        }
        $this->user->addToFavorite($user_id, $post_id, $type);
 
        return $this->sendResponse([]);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    
    public function register(Request $request){

        try
        {
           
            $email = $request->email;
            $password = $request->password;
            $purpose = $request->purpose;
            if (!$email or !$password){
                throw new Exception('Missing paramter');
            }

            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
            {
                throw new Exception('Email invalid');
            }

            $data = [
                'email'=> $email,
                'password'=>bcrypt($password),
            ];
            if($purpose != ''){
                $data['purpose'] = $purpose;
            }
            $check_email = $this->user->countBy(['email' => $email]);
            if ($check_email > 0) {
                throw new Exception('Email exited');
            }
            
            $id = $this->user->insertGetId($data);
                           
            $user = $this->user->find($id);
                          
            $token = JWTAuth::fromUser($user);

            $data = [
                'id' => $id,
                'email' => $email,
                'token' => $token,
                
            ];
           
           return $this->sendResponse($data);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
    }
     
    public function login(Request $request){
        try
        {
            $email = $request->email;
            $password = $request->password;
            $purpose = $request->purpose;
            $credentials = [
        		'password'=>$request->password,
        	];
             
            if (!$email or !$password){
                throw new Exception('Missing email or password');
            }
            
            $credentials['email'] = $email;
            
           if(!$token = JWTAuth::attempt($credentials)){
                throw new Exception('Email or password is wrong');
           }
            
           $user = $this->user->findBy(['email' => $email]);
            if($purpose != ''){
                $this->__set_purpose($user->id, $purpose);
            }
            $data = [
                'id' => $user->id,
                'email' => $user->email,
                'token' => $token,
                
            ];
            
            return $this->sendResponse($data);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }

    }
    public function updatePersonnalize(Request $request){
        try
        {
            $user_id = $request->get('user_id');
            $purpose = $request->purpose;
            if (!$purpose){
                throw new Exception('Missing paramter');
            }
            $this->user->update($user_id, ['purpose' => $purpose]);
            
            return $this->sendResponse([]);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    
    private function __set_purpose($id, $purpose){
        return $this->user->update($id, ['purpose' => $purpose]);
    }
    
    
    public function login_google(Request $request){
        try
        {
           $email = $request->email;
           $google_id = $request->google_id;
           $purpose = $request->purpose;
           if (!$email or !$google_id){
                throw new Exception('Missing paramter');
           }
            
            $check = $this->user->countBy(['email' => $email]);
            
            if($check == 0){
                
                $data = [
                    'google_id' => $google_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'email' => $email
                ];
                
                $this->user->insert($data);
                
            }
            $user = $this->user->findBy(['email' => $email]);
            $token = JWTAuth::fromUser($user);
            if($purpose != ''){
                $this->__set_purpose($user->id, $purpose);
            }
           $data = [
               'id' => $user->id,
               'token' => $token,
           ];
            
            return $this->sendResponse($data);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    
    public function login_facebook(Request $request){
        try
        {
           $facebook_id = $request->facebook_id;
           $email = $request->email;
           $purpose = $request->purpose;
            if (!$facebook_id or !$email){
                throw new Exception('Missing paramter');
            }
            
            $check = $this->user->countBy(['facebook_id' => $facebook_id]);

            if($check == 0){
                $data = [
                    'facebook_id' => $facebook_id,
                    'email' => $email
                ];
                $this->user->insert($data);
                
            }
            
            $user = $this->user->findBy(['facebook_id' => $facebook_id]);
            if($purpose != ''){
                $this->__set_purpose($user->id, $purpose);
            }
            $token = JWTAuth::fromUser($user);
            
            $data = [
                    'id' => $user->id,
                    'token' => $token,
                ];
          
            return $this->sendResponse($data);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }

    }

    public function logout(Request $request){
        try
        {
            JWTAuth::invalidate(JWTAuth::getToken());
            return $this->sendResponse([]);
            
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    

}
