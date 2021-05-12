<?php

namespace App\Http\Controllers;

use App\Events\MessageAttached;
use App\Events\MessageDetached;
use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Models\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMessageRequest $request)
    {
        $message = Auth::user()->messages()->create([
            'text' => $request->input('text')
        ]);

        if($request->has('screen')){
            $screen = Screen::findOrFail($request->input('screen'));
            $screen->messages()->attach($message);

            event(new MessageAttached($screen, $message));
        }else if($request->has('all_screens')){
            $screens = Screen::all();
            foreach($screens as $screen){
                $screen->messages()->attach($message);
                event(new MessageAttached($screen, $message));
            }
        }
        return redirect()->back()
            ->with('success', "message created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        foreach($message->screens as $screen){
            $message->screens()->detach($screen);
            event(new MessageDetached($screen, $message));
        }

        $message->delete();

        return redirect()->back()
            ->with('success', "Message deleted successfully");
    }
}
