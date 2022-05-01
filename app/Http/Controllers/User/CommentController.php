<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\StoreRequest;
use App\Http\Requests\Comments\UpdateRequest;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentRepo;
    protected $productRepo;
    protected $userRepo;

    public function __construct(
        CommentRepositoryInterface $commentRepo,
        ProductRepositoryInterface $productRepo,
        UserRepositoryInterface $userRepo,
    ) {
        $this->commentRepo = $commentRepo;
        $this->productRepo = $productRepo;
        $this->userRepo = $userRepo;
    }

    public function comment(StoreRequest $request)
    {
        $product = $this->productRepo->find($request->product_id);
        $allowComment = false;

        if ($request->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', __("cannot comment by other account"));
        }
        $user = $this->userRepo->getUserByOrderDelivered(Auth::user()->id);
        foreach ($user->orders as $order) {
            foreach ($order->products as $p) {
                if ($p->id == $request->product_id) {
                    $allowComment = true;
                    foreach ($product->comments as $comment) {
                        if ($comment->product_id == $request->id && $comment->user_id == Auth::user()->id) {
                            $allowComment = false;
                            break;
                        }
                    }
                }
            }
        }
        if ($allowComment == false) {
            return redirect()->back()->with('error', __("cannot comment"));
        } else {
            $this->commentRepo->create($request->all());
    
            return redirect()->back()->with('success', __('rating success'));
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        $comment = $this->commentRepo->find($id);
        if (!$comment || $comment && $comment->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', __('cannot update comment'));
        }
        $comment->update($request->only('content'));

        return redirect()->back()->with('success', __('update comment success'));
    }

    public function destroy($id)
    {
        $comment = $this->commentRepo->find($id);
        if (!$comment || $comment && $comment->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', __('cannot delete comment'));
        }
        $comment->delete();

        return redirect()->back();
    }
}
