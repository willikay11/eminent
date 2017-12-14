<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 12/14/17
 * Time: 12:59 PM
 */

namespace App\Http\Controllers;


use App\Jobs\PostFeedBack;
use eminent\Models\UserFeedback;
use eminent\UserFeedBack\UserFeedBackRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedBackController extends Controller
{
    /**
     * @var UserFeedBackRepository
     */
    private $userFeedBackRepository;

    public function __construct(UserFeedBackRepository $userFeedBackRepository)
    {

        $this->userFeedBackRepository = $userFeedBackRepository;
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $input['user_id'] = Auth::id();

        $feedback = $this->userFeedBackRepository->store($input);

        if ($feedback)
        {
            $this->dispatch(new PostFeedBack($feedback));

            return self::toResponse(null, [
                'success' => true,
                'message' => 'Feedback posted successfully!'
            ]);
        }

        return self::toResponse(null, [
            'success' => false,
            'message' => 'Oops! An error occurred'
        ]);
    }

    public function toResponse($request = null, $data)
    {
        return response($data);
    }
}