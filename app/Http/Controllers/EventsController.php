<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Event;
use App\Models\Eve_part;
use App\Http\Resources\EventResource;

class EventsController extends Controller
{
    /**
     * GET /api/events
     */
    public function index()
    {
        $events = Event::with('participants')->latest()->get();

        return EventResource::collection($events);
    }

    /**
     * POST /api/events
     */
    public function search(Request $request)
    {
        $query = $request->query('q'); 
    
        if (!$query) {
            return response()->json([
                'message' => 'Search query is required'
            ], Response::HTTP_BAD_REQUEST);
        }
    
        $events = Event::where('event_name', 'LIKE', "%{$query}%")
            ->orWhere('category', 'LIKE', "%{$query}%")
            ->orderBy('event_date', 'asc')
            ->get();
    
        return response()->json([
            'message' => 'Search results',
            'total_results' => $events->count(),
            'events' => $events
        ], Response::HTTP_OK);
    }

public function store(Request $request)
{
    // Laravel automatically handles validation and returns 422 if it fails
    $validated = $request->validate([ 
        'event_name' => 'required|string|max:255',
        'category'   => 'required|string',
        'event_date' => 'required|date_format:Y-m-d H:i:s',
        'location'   => 'required|string|max:255',
    ]);

    // Create the event
    $event = Event::create($validated);

    // Return the model directly with a 201 Created status
    return response()->json($event, 201);
}

    /**
     * GET /api/events/{id}
     */
    public function show(string $id)
    {
        $event = Event::with('participants')->find($id);

        if (!$event) {
            return response()->json([
                'status' => 'error',
                'message' => 'Event not found',
                'errors' => null
            ], Response::HTTP_NOT_FOUND);
        }

        return new EventResource($event);
    }

    /**
     * PUT/PATCH /api/events/{id}
     */
    public function update(Request $request, string $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'status' => 'error',
                'message' => 'Event not found',
                'errors' => null
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'event_name' => 'sometimes|required|string|max:255',
            'category'   => 'sometimes|required|string',
            'event_date' => 'sometimes|required|date',
            'location'   => 'sometimes|required|string|max:255',
        ]);

        $event->update($validated);

        return new EventResource($event);
    }

    /**
     * DELETE /api/events/{id}
     */
    public function destroy(string $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'status' => 'error',
                'message' => 'Event not found',
                'errors' => null
            ], Response::HTTP_NOT_FOUND);
        }

        $event->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Event deleted successfully',
            'data' => null
        ], Response::HTTP_OK);
    }

    /**
     * POST /api/events/{id}/participants
     */
    public function registerParticipant(Request $request, string $id)
    {
        $data = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $event = Event::find($id);
        if (! $event) {
            return response()->json([
                'status' => 'error',
                'message' => 'Event not found',
                'errors' => null
            ], Response::HTTP_NOT_FOUND);
        }

        $alreadyRegistered = Eve_part::where('event_id', $event->id)
            ->where('user_id', $data['user_id'])
            ->exists();

        if ($alreadyRegistered) {
            return response()->json([
                'status' => 'error',
                'message' => 'User is already registered for this event',
                'errors' => null
            ], Response::HTTP_CONFLICT);
        }

        // Limit to 10 participants
        $currentCount = Eve_part::where('event_id', $event->id)->count();

        if ($currentCount >= 10) {
            return response()->json([
                'status' => 'error',
                'message' => 'Event already reached maximum of 10 participants.',
                'errors' => null
            ], Response::HTTP_BAD_REQUEST);
        }

        $participant = Eve_part::create([
            'event_id' => $event->id,
            'user_id'  => $data['user_id'],
        ]);

        // Reload event with participants
        $event->load('participants');

        return (new EventResource($event))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}