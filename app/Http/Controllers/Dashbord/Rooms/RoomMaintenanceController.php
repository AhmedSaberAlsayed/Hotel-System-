<?php

namespace App\Http\Controllers\Rooms\Dashboard;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RoomMaintenanceRequest;
use App\RepositoryInterface\RoomMaintenanceRepositoryInterface;

class RoomMaintenanceController extends Controller
{
    protected $roomMaintenanceRepo;

    // Inject the repository via the constructor
    public function __construct(RoomMaintenanceRepositoryInterface $roomMaintenanceRepo)
    {
        $this->roomMaintenanceRepo = $roomMaintenanceRepo;
    }

    // Display a listing of room maintenance
    public function index()
    {
        $maintenances = $this->roomMaintenanceRepo->all(10);
        return response()->json($maintenances);
    }

    // Store a new maintenance record
    public function store(RoomMaintenanceRequest $request)
    {
        $maintenance = $this->roomMaintenanceRepo->create($request->all());
        
        return response()->json(['message' => 'Maintenance record created', 'maintenance' => $maintenance]);
    }

    // Show a specific maintenance record
    public function show($id)
    {
        $maintenance = $this->roomMaintenanceRepo->find($id);

        if (!$maintenance) {
            return response()->json(['message' => 'Maintenance record not found'], 404);
        }

        return response()->json($maintenance);
    }

    // Update a specific maintenance record
    public function update(RoomMaintenanceRequest $request, $id)
    {
        $maintenance = $this->roomMaintenanceRepo->find($id);

        if (!$maintenance) {
            return response()->json(['message' => 'Maintenance record not found'], 404);
        }
        $this->roomMaintenanceRepo->update($maintenance, $request->all());
        return response()->json(['message' => 'Maintenance record updated', 'maintenance' => $maintenance]);
    }

    // Remove a specific maintenance record
    public function destroy($id)
    {
        $this->roomMaintenanceRepo->delete($id);
        
        return response()->json(['message' => 'Maintenance record deleted']);
    }
}
