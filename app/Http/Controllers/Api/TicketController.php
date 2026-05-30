<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
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
                $ticket->addMedia($file)->toMediaCollection('attachments');
            }
        }
        return new TicketResource($ticket->load('customer'));
    }

    /**
     * Ticket statistic
     */
    public function statistics()
    {
        //
    }

    
}
