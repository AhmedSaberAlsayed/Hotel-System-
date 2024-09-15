<?php

namespace App\Repository;

use App\Models\Guest;
use Illuminate\Support\Facades\Hash;
use App\ReposatoryInterface\GuestRepositoryInterface;

class GuestRepository implements GuestRepositoryInterface
{
    public function all($paginate)
    {
        return Guest::paginate($paginate);
    }

    public function find($id)
    {
        return Guest::find($id);
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
}
