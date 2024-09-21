<?php

namespace App\Repository;

use App\Models\Service;
use App\RepositoryInterface\ServiceRepositoryInterface;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function create(array $data)
    {
        return Service::create($data);
    }

    public function find($id)
    {
        return Service::find($id);
    }

    public function update($id, array $data)
    {
        $service = Service::find($id);
        if ($service) {
            $service->update($data);
        }
        return $service;
    }

    public function delete($id)
    {
        $service = Service::find($id);
        if ($service) {
            $service->delete();
        }
        return $service;
    }
}
