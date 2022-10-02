<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $listings  = Listing::where('is_active', true)->with('tags')->latest()->get();
        $tags = Tag::orderBy('name')->get();
        // dd($tags);
        if ($request->has('s') && $request->get('s') != null) {
            $query = strtolower($request->get('s'));
            $listings = $listings->filter(
                function ($listing) use ($query) {
                    if (Str::contains(strtolower($listing->title), $query))
                        return true;

                    if (Str::contains(strtolower($listing->company), $query))
                        return true;

                    if (Str::contains(strtolower($listing->location), $query))
                        return true;

                    if (Str::contains(strtolower($listing->content), $query))
                        return true;

                    return false;
                }
            );
        }


        if ($request->has('tag') && $request->get('tag') != null) {
            $tag = strtolower($request->get('tag'));
            $listings = $listings->filter(function ($listing) use ($tag) {
                return $listing->tags->contains('slug', $tag);
            });
        }

        return view('home' , compact('listings', 'tags'));
    }

    public function profile()
    {
        $user = User::find(Auth::id());
        $listings = $user->listings()->get();

        return view('listing.profile' , compact('listings'));
    }
}
