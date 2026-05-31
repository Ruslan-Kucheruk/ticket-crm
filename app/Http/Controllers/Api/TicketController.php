<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Http\Resources\TicketStatisticsResource;
use App\Models\Customer;
use App\Models\Ticket;

class TicketController extends Controller
{
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $validated = $request->validated();

        $hasRecentTicket = Ticket::query()->forDay()->whereHas('customer', function($query) use ($validated){
            $query->where('email', $validated['email'])->
            orWhere('phone', $validated['phone']);
        })->exists();

        if($hasRecentTicket){
            return response()->json([
                'message'=>'You can send only one request per one day',
            ], 429);
        }
        
        $customer = Customer::firstOrCreate(
            [
                'email' => $validated['email']
            ],
            [
                'name' => $validated['name'],
                'phone' => $validated['phone'],
            ]);

        $ticket = Ticket::create([
            'customer_id' => $customer->id,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        if($request->hasFile('files')){
            foreach($request->file('files') as $file){
                $ticket->addMedia($file)->toMediaCollection('attachments', 'public');
            }
        }
        return new TicketResource($ticket->load('customer'));
    }

    /**
     * Ticket statistic
     */
    public function statistics(): TicketStatisticsResource
    {
        $statistics = [
            'day' => Ticket::query()->forDay()->count(),
            'week' => Ticket::query()->forWeek()->count(),
            'month' => Ticket::query()->forMonth()->count(),
        ];

        return new TicketStatisticsResource($statistics);
    }

    
}
