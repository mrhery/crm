<?php

namespace App\Http\Controllers;

use App\Zoom;
use Illuminate\Http\Request;
use App\Services\ZoomService;

class ZoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $webinars = Zoom::paginate(10);

        return view('zoom.index', compact('webinars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('zoom.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'topic' => 'required|min:3',
            'start' => 'required|min:3',
            'end' => 'required|min:3',
            'password' => 'required|min:3',
            'duration' => 'required'
        ]);

        $webinarDetails = ZoomService::createWebinar($request);

        // dd($webinarDetails);

        $webinar_id = $webinarDetails->id;

        $start_url = $webinarDetails->start_url;

        $join_url = $webinarDetails->join_url;

        $webinar = new Zoom();
        $webinar->topic = $validated['topic'];
        $webinar->start_time = $validated['start'];
        $webinar->end_time = $validated['end'];
        $webinar->password = $validated['password'];
        $webinar->duration = $validated['duration'];
        $webinar->webinar_id = $webinar_id;
        $webinar->start_url = $start_url;
        $webinar->join_url = $join_url;
        
        $webinar->save();

        return redirect('/zoom');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Zoom  $zoom
     * @return \Illuminate\Http\Response
     */
    public function showParticipants($webinarId)
    {
        // dd($webinarId);
        $webinarDetails = ZoomService::getListRegistree($webinarId);

        $participants = $webinarDetails->registrants;

        return view('zoom.participants', compact('participants'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Zoom  $zoom
     * @return \Illuminate\Http\Response
     */
    public function edit(Zoom $zoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Zoom  $zoom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zoom $zoom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Zoom  $zoom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zoom $zoom)
    {
        //
    }
}
