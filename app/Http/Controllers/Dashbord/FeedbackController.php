<?php

namespace App\Http\Controllers\Dashbord;

use auth;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackRequest;

class FeedbackController extends Controller
{
    public function index(){}
    public function store(FeedbackRequest $request ){
        $userID = auth()->user()->id;
        Feedback::create([
            'GuestID' =>$userID,
            'ServiceID' => $request->ServiceID ,
            'Rating' => $request->Rating ,
            'Comments' => $request->Comments ,
            'FeedbackDate' => Carbon::now()
        ]);
    }
    public function update(){}
    public function destroy(){}


}
