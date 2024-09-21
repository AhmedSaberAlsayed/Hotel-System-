<?php

namespace App\Http\Controllers\Dashbord;

use App\Http\Controllers\Controller;
use App\Http\Traits\Api_designtrait;
use App\Http\Requests\FeedbackRequest;
use App\Http\Resources\FeedbackResource;
use App\RepositoryInterface\FeedbackRepositoryInterface;

class FeedbackController extends Controller
{
    use Api_designtrait;
    protected $feedbackRepository;

    public function __construct(FeedbackRepositoryInterface $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    public function index()
    {
        $feedbacks = $this->feedbackRepository->all();
        return $this->api_design(200, 'All feedbacks', new FeedbackResource($feedbacks));
    }

    public function store(FeedbackRequest $request)
    {
        $userID = auth()->user()->id;
        $feedback = $this->feedbackRepository->create([
            'GuestID' => $userID,
            'ServiceID' => $request->ServiceID,
            'Rating' => $request->Rating,
            'Comments' => $request->Comments
        ]);

        return $this->api_design(200, ' feedback Added succesfuly', new FeedbackResource($feedback));
    }

    public function show($id)
    {
        $feedback = $this->feedbackRepository->find($id);
        if ($feedback) {
            return $this->api_design(200, 'feedback', new FeedbackResource($feedback));
        }
        return $this->api_design(404, 'Feedback not found',null,);
    }

    public function update(FeedbackRequest $request, $id)
    {
        $feedback = $this->feedbackRepository->update($id, $request->validated());
        if ($feedback) {
            return $this->api_design(200, 'Feedback updated successfully', new FeedbackResource($feedback));
        }
        return $this->api_design(404, 'Feedback update failed', null);
    }

    public function destroy($id)
    {
        $feedback = $this->feedbackRepository->delete($id);
        if ($feedback) {
            return $this->api_design(200, 'Feedback deleted successfully', new FeedbackResource($feedback));
        }
        return $this->api_design(500, 'Feedback deletion failed', null);
    }
}
