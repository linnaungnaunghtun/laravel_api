<?php

namespace App\Http\Controllers\ECommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\GoogleLoginRequest;
use App\Http\Resources\ECommerceAuthenticatedUserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Google\Client as GoogleClient;
use Google\Service\Oauth2 as GoogleOauth2;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login(GoogleLoginRequest $request)
    {
        $accessToken = $request->input('access_token');

        // Initialize Google Client
        $client = new GoogleClient();
        $client->setAccessToken($accessToken);

        // Fetch user info from Google's userinfo endpoint
        $oauth2 = new \Google\Service\Oauth2($client);
        $userInfo = $oauth2->userinfo->get();

        // Extract user information
        $googleId = $userInfo->getId();
        $email = $userInfo->getEmail();
        $name = $userInfo->getName();
        $profileImageUrl = $userInfo->getPicture();

        // Check if the user already exists
        $user = User::where('email', $email)->where('google_id', $googleId)->with("addresses", "customer")->first();

        if (!$user) {
            // Download and store the profile image
            $profileImagePath = $this->storeProfileImage($profileImageUrl, $email);

            // Create a new user
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'profile_image' => $profileImagePath,
                'password' => Hash::make("customer_default_password"),
                'role' => 'customer',
                'google_id' => $googleId
            ]);
        }

        // Log in the user
        Auth::login($user);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => new ECommerceAuthenticatedUserResource($user)]);
    }

    protected function storeProfileImage($url, $email)
    {
        try {
            $contents = file_get_contents($url);
            if ($contents === false) {
                throw new \Exception("Failed to download image from URL");
            }

            // Generate a unique filename
            $filename = 'profile_images/' . md5($email . time()) . '.jpg';

            // Store the file in the public disk (you can change this to 's3' or other disks)
            Storage::disk('minio')->put($filename, $contents);

            // Return the path that can be stored in the database
            // return $filename;
            return asset(Storage::url($filename));
        } catch (\Exception $e) {
            // Log the error and return null or a default image path
            Log::error('Failed to store profile image: ' . $e->getMessage());
            return null;
        }
    }
}
