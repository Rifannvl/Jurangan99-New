<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\View\View;

class RecipeController extends Controller
{
    public function index(): View
    {
        $recipes = Recipe::query()
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('recipes.index', compact('recipes'));
    }
}
