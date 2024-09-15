<?php

namespace App\Repository;

use App\Models\Feedback;
use Illuminate\Support\Carbon;
use App\ReposatoryInterface\FeedbackRepositoryInterface;

class FeedbackRepository implements FeedbackRepositoryInterface
{
    public function all()
    {
        return Feedback::all();
    }

    public function create(array $data)
    {
        $data['FeedbackDate'] = Carbon::now();
        return Feedback::create($data);
    }

    public function find($id)
    {
        return Feedback::find($id);
    }

    public function update($id, array $data)
    {
        $feedback = Feedback::find($id);
        if ($feedback) {
            $feedback->update($data);
        }
        return $feedback;
    }

    public function delete($id)
    {
        $feedback = Feedback::find($id);
        if ($feedback) {
            $feedback->delete();
        }
        return $feedback;
    }
}
