<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Http\Requests\UpdateTicketStatusRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tickets = Ticket::query()->with('customer')
        ->when($request->filled('status'), function($query) use ($request){
            $query->where('status', $request->status);
        })
        ->when($request->filled('phone'), function($query) use ($request){
            $query->whereHas('customer', function($customerQuery) use ($request){
                $customerQuery->where('phone', 'like', '%' . $request->phone . '%');
            });
        })
        ->when($request->filled('email'), function($query) use ($request){
            $query->whereHas('customer', function($customerQuery) use ($request){
                $customerQuery->where('email', 'like', '%' . $request->email . '%');
            });
        })
        ->when($request->filled('date_from'), function($query) use ($request){
            $query->whereDate('created_at', '>=', $request->date_from);
        })
        ->when($request->filled('date_to'), function($query) use ($request){
            $query->whereDate('created_at', '<=', $request->date_to);
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('admin.tickets.index', compact('tickets'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load('customer', 'media');
        return view('admin.tickets.show', compact('ticket'));
    }


    /**
     * Update the Ticket status.
     */
    public function updateStatus(UpdateTicketStatusRequest $request, Ticket $ticket):RedirectResponse
    {
        $ticket->update([
            'status' => $request->validated('status'),
            'manager_replied_at' => Carbon::now(),
        ]);

        return redirect()
            ->route('admin.tickets.show', $ticket)
            ->with('success', 'Ticket status updated successfully');
    }

   
}
