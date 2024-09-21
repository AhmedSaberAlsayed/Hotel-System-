<?php

namespace App\Repository;

use App\Models\Guest;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\GuestResource;
use Laravel\Socialite\Facades\Socialite;
use App\RepositoryInterface\GuestRepositoryInterface;

class GuestRepository implements GuestRepositoryInterface
{
    public function all($paginate)
    {
        $guests = Guest::paginate($paginate);
        $data = [
            'guests' => GuestResource::collection($guests),
            'pagination' => [
                'total' => $guests->total(),
                'count' => $guests->count(),
                'per_page' => $guests->perPage(),
                'current_page' => $guests->currentPage(),
                'total_pages' => $guests->lastPage(),
                'first_page_url' => $guests->url(1),
                'last_page_url' => $guests->url($guests->lastPage()),
                'next_page_url' => $guests->nextPageUrl(),
                'prev_page_url' => $guests->previousPageUrl(),
                'path' => $guests->path(),
            ]
        ];
        return $data;
    }

    public function find($id)
    {
        return Guest::find($id);
    }
    public function findBySocialID($id)
    {
        return Guest::where('socialID',$id)->first();
    }

    public function create(array $data)
    {
        $data['Password'] = Hash::make($data['Password']);
        return Guest::create($data);
    }

    public function update($id, array $data)
    {
        $Guest = Guest::find($id);
        if ($Guest) {
            $data['Password'] = Hash::make($data['Password']);
            $Guest->update($data);
        }
        return $Guest;
    }

    public function delete($id)
    {
        $Guest = Guest::find($id);
        if ($Guest) {
            $Guest->delete();
        }
        return $Guest;
    }

    public function findByEmail($email)
    {
        return Guest::where('Email', $email)->first();
    }
      public function redirect() {
        return  Socialite::driver('google')->stateless()->redirect();
    }
    public function handleCallback($request ,$sid)
{
    try {
    $googleUser = Socialite::driver('google')->stateless()->user();

         $findUser =$this->findBySocialID($sid);
        if ($findUser) {
            $deviceName = $request->userAgent();
            $token = $findUser->createToken($deviceName)->plainTextToken;
            return $token;
        } else {
            $newGuest = Guest::create([
                'FirstName' => $googleUser->user['given_name'] ?? 'First Name',
                'LastName' => $googleUser->user['family_name'] ?? 'Last Name',
                'Email' => $googleUser->email,
                'Password' => Hash::make('12345678'),
                'Phone' => "21413535",
                'Address' => "Haram",
                'DateOfBirth' => '2003-02-02',
                'socialID' => $googleUser->id,
            ]);

            $deviceName = $request->userAgent();
            $token = $newGuest->createToken($deviceName)->plainTextToken;
            $data = [
                'token' => $token,
                'Guest' => $newGuest
            ];
            return $data;
        }
    } catch (\Throwable $th) {
        // return $this->api_design(500, 'Error during Google login', null, [
        //     'error' => $th->getMessage()
        // ]);
        }
    }
}
