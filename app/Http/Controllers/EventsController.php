<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Event;
use App\Models\Eve_part;

class EventsController extends Controller
{
    /**
     * GET /api/events
     */
 
public function index()
{
   $events = Event::with('participants')->latest()->get();

   return response()->json([
       'message' => 'Events retrieved successfully',
       'total_events' => $events->count(),
       'events' => $events,
   ], Response::HTTP_OK);

}
    /**
     * POST /api/events
     */
 

public function store(Request $request)
{
    try {
        // Validate the incoming request
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'category'   => 'required|string',
            'event_date' => 'required|date',
            'location'   => 'required|string|max:255',
        ]);

        // Create the event
        $event = Event::create($validated);

        // Return success response
        return response()->json([
            'message' => 'Event created successfully',
            'data' => $event
        ], Response::HTTP_CREATED);

    } catch (\Exception $e) {
        // Catch any internal server errors
        return response()->json([
            'message' => 'Internal Server Error',
            'error' => $e->getMessage() // optional: include for debugging
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

    /**
     * GET /api/events/{id}
     */
    public function show(string $id)
    {
        $event = Event::with('participants')->find($id);

        if (!$event) {
            return response()->json([
                'message' => 'Event not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($event, Response::HTTP_OK);
    }

    /**
     * PUT/PATCH /api/events/{id}
     */
    public function update(Request $request, string $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'message' => 'Event not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'event_name' => 'sometimes|required|string|max:255',
            'category'   => 'sometimes|required|string',
            'event_date' => 'sometimes|required|date',
            'location'   => 'sometimes|required|string|max:255',
        ]);

        $event->update($validated);

        return response()->json([
            'message' => 'Event updated successfully',
            'data' => $event
        ], Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'message' => 'Event not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $event->delete();

        return response()->json([
            'message' => 'Event deleted successfully'
        ], Response::HTTP_OK);
    }

    public function registerParticipant(Request $request, string $id)
{
 
    $data = $request->validate([
        'user_id' => 'required|integer|exists:users,id',
    ]);

    $event = Event::find($id);
    if (! $event) {
        return response()->json([
            'message' => 'Event not found',
        ], Response::HTTP_NOT_FOUND);
    }

    $alreadyRegistered = Eve_part::where('event_id', $event->id)
        ->where('user_id', $data['user_id'])
        ->exists();

    if ($alreadyRegistered) {
        return response()->json([
            'message' => 'User is already registered for this event',
        ], Response::HTTP_CONFLICT);
    }

 
    $participant = Eve_part::create([
        'event_id' => $event->id,
        'user_id'  => $data['user_id'],
    ]);

    return response()->json([
        'message' => 'Participant registered successfully',
        'data'    => $participant,
    ], Response::HTTP_CREATED);
}

  
}