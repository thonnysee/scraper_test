<?php

namespace App\Http\Controllers;

use App\Jobs\ScrapeLinksJob;
use App\Models\Site;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SitesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites = auth()->user()->sites()->paginate(10);
        return view("dashboard",['sites' => $sites]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $owner_id = auth()->user()->id;
        $url = $request['url'];

        // Dispatch the job with the requested url and the authenticated user
        ScrapeLinksJob::dispatch($url, $owner_id);

        // Obtain all the sites
        $sites = auth()->user()->sites()->paginate(10);
        return view("dashboard",['sites' => $sites]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Site $site)
    {
        $links = $site->links()->paginate(10);
        return view(
            "show",
            [
                'site' => $site, 
                'links' => $links
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $site)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Site $site)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Site $site)
    {
        $site->delete();
        $sites = auth()->user()->sites()->paginate(10);
        return view("dashboard",['sites' => $sites]);
    }

}
