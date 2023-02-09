<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request  $request
     * @return CategoryResource
     */
    public function index(Request $request): CategoryResource
    {
        $limit = $request->input('limit') ?? 25;

        return new CategoryResource(
            Category::with('items')
                ->orderBy('position')
                ->paginate($limit)
        );
    }

    /**
     * Return active items based on user
     *
     * @param User $user
     * @return void
     */
    public function currentAvatarItems(User $user): JsonResponse
    {
        $items =  $user->activeItems()->with('category')->get();

        return response()->json([
            'status' => 'ok',
            'data' => $items
        ]);
    }

    /**
     * Buy the item per the user
     *
     * @param User $user
     * @param Item $item
     * @return JsonResponse
     */
    public function buy(User $user, Item $item): JsonResponse
    {
        if ($user->balance < $item->price) {
            return response()->json([
                'status' => 'error',
                'message' => 'User does not have sufficient amount to purchase.'
            ]);
        }

        DB::transaction(function () use ($user, $item) {
            $user->balance = $user->balance - $item->price;
            $user->save();
            $user->items()->attach($item->id);
        });

        return response()->json([
            'status' => 'ok',
            'message' => 'Item successfully purchased'
        ]);
    }

    /**
     * Dress up with a new set of items fo the user
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function activateItems(Request $request, User $user): JsonResponse
    {
        $validatedData = $request->validate([
            'items' => ['required', 'array'],
        ]);

        $items = $validatedData['items'];
        $unlockedItems = $user->items;

        /** Deactivate the all unlocked existing items */
        $unlockedItemIds = $unlockedItems->pluck('id');
        $user->items()->syncWithPivotValues($unlockedItemIds, ['active' => false]);

        $order = 0;
        foreach ($items as $item) {

            $isUnlocked = $unlockedItems->where('id', $item);

            if ($isUnlocked->isNotEmpty()) {
                $order++;
                $user->items()->updateExistingPivot($item, [
                    'active' => true,
                    'order' => $order
                ]);
            }
        }

        return response()->json([
            'status' => 'ok',
            'message' => sprintf('%s items successfully updated', $order),
        ]);
    }
}
