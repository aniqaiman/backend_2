<?php

namespace App\Http\Controllers\Api;

use App\Feedback;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;

class FeedbackController extends Controller
{
    public function getFeedbacks($type)
    {
        if ($type === 'buyer') {
            $feedbacks = Feedback::whereHas('order', function ($order) {
                $order->where('user_id', JWTAuth::parseToken()->authenticate()->id);
            });
        } else if ($type === 'supplier') {
            $feedbacks = Feedback::whereHas('stock', function ($stock) {
                $stock->where('user_id', JWTAuth::parseToken()->authenticate()->id);
            });
        }

        return response()->json([
            'data' => $feedbacks->get(),
        ]);
    }

    public function getUnreadFeedbacks($type)
    {
        if ($type === 'buyer') {
            $feedbacks = Feedback::whereHas('order', function ($order) {
                $order->where('user_id', JWTAuth::parseToken()->authenticate()->id);
            });
        } else if ($type === 'supplier') {
            $feedbacks = Feedback::whereHas('stock', function ($stock) {
                $stock->where('user_id', JWTAuth::parseToken()->authenticate()->id);
            });
        }

        return response()->json([
            'data' => $feedbacks->where('has_read', 0)->get(),
        ]);
    }

    public function getSingleFeedback($type, $id)
    {
        if ($type === 'buyer') {
            $feedbacks = Feedback::whereHas('order', function ($order) {
                $order->where('user_id', JWTAuth::parseToken()->authenticate()->id);
            });
        } else if ($type === 'supplier') {
            $feedbacks = Feedback::whereHas('stock', function ($stock) {
                $stock->where('user_id', JWTAuth::parseToken()->authenticate()->id);
            });
        }

        return response()->json([
            'data' => $feedbacks->find($id),
        ]);
    }

    public function setReadFeedback($type, $id)
    {
        if ($type === 'buyer') {
            $feedbacks = Feedback::whereHas('order', function ($order) {
                $order->where('user_id', JWTAuth::parseToken()->authenticate()->id);
            });
        } else if ($type === 'supplier') {
            $feedbacks = Feedback::whereHas('stock', function ($stock) {
                $stock->where('user_id', JWTAuth::parseToken()->authenticate()->id);
            });
        }

        $feedback = $feedbacks->find($id);
        $feedback->has_read = 1;
        $feedback->save();

        return response()->json([
            'data' => $feedback,
        ]);
    }

    public function updateResponseFeedback(Request $request, $type, $id)
    {
        if ($type === 'buyer') {
            $feedbacks = Feedback::whereHas('order', function ($order) {
                $order->where('user_id', JWTAuth::parseToken()->authenticate()->id);
            });
        } else if ($type === 'supplier') {
            $feedbacks = Feedback::whereHas('stock', function ($stock) {
                $stock->where('user_id', JWTAuth::parseToken()->authenticate()->id);
            });
        }

        $feedback = $feedbacks->find($id);
        $feedback->response = $request->response;
        $feedback->save();

        return response()->json([
            'data' => $feedback,
        ]);
    }

}
