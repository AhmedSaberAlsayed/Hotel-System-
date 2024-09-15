<?php

namespace App\Http\Controllers\Dashbord\Auth;

use App\Models\Guest;
use Illuminate\Http\Request;
use App\Http\Requests\GuestRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\Api_designtrait;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\GuestResource;
use App\ReposatoryInterface\GuestRepositoryInterface;

class GuestController extends Controller
{
    use Api_designtrait;
    protected $guestRepository;

    public function __construct(GuestRepositoryInterface $guestRepository)
    {
        $this->guestRepository = $guestRepository;
    }

    public function index()
    {
        $guests = $this->guestRepository->all(10);
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
        return $this->api_design(200, "All Guests", $data);
    }

    public function register(GuestRequest $request)
    {
        $Guest = $this->guestRepository->create($request->all());
        return $this->api_design(201, 'Guest registered successfully', new GuestResource($Guest));
    }

    public function store(Request $request)
    {
        $Guest = $this->guestRepository->findByEmail($request->Email);

        if ($Guest && Hash::check($request->Password, $Guest->Password)) {
            $deviceName = $request->userAgent();
            $token = $Guest->createToken($deviceName)->plainTextToken;

            return $this->api_design(200, 'Login successful', ['token' => $token, 'Guest' => new GuestResource($Guest)]);
        }

        return $this->api_design(401, 'Invalid credentials');
    }

    public function show($id)
    {
        $Guest = $this->guestRepository->find($id);
        return $this->api_design(200, 'Selected Guest', new GuestResource($Guest));
    }

    public function update(GuestRequest $request, $id)
    {
        $Guest = $this->guestRepository->update($id, $request->all());

        if ($Guest) {
            return $this->api_design(200, 'Guest updated successfully', new GuestResource($Guest));
        }

        return $this->api_design(500, 'Guest update failed');
    }

    public function destroy($id)
    {
        $Guest = $this->guestRepository->delete($id);
        return $this->api_design(200, 'Guest deleted successfully', new GuestResource($Guest));
    }
}
