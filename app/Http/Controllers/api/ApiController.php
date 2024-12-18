<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function assessment()
    {
        try {
            $response = Http::get('https://dummyjson.com/users');
            if (!$response->successful()) {
                return response()->json([
                    'message' => 'Failed to fetch data',
                    'error' => $response->body()
                ], 400);
            }
            $data = $response->json();
            $responseData = [];
            foreach ($data['users'] as $userData) {
                // if we send request again api will fetch same user data again
                // since email is unique it will throw exception
                // so for that case update the user  instead of trying to create user with same email 
                $existingUser = User::where('email', $userData['email'])->first();
                // If user doesn't exist, create new. If exists, update.
                $user = $existingUser ?? new User();

                $user->fill([
                    'first_name' => $userData['firstName'],
                    'last_name' => $userData['lastName'],
                    'phone' => $userData['phone'],
                    'age' => $userData['age'],
                    'height' => $userData['height'],
                    'weight' => $userData['weight'],
                    'gender' => $userData['gender'],
                    'email' => $userData['email'],
                    'password' => bcrypt($userData['password']),
                ]);
                $user->save();
                $responseData[] = $user;
            }
            return response()->json($responseData);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during request',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
