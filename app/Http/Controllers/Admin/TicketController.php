<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Http\Requests\UpdateTicketStatusRequest;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }


    /**
     * Update the Ticket status.
     */
    public function updateStatus(UpdateTicketStatusRequest $request, Ticket $ticket)
    {
        //
    }

   
}
