<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScreenRequest;
use App\Http\Resources\ScreenResource;
use App\Models\Attachment;
use App\Models\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\AttachmentAttached;
use App\Events\AttachmentDetached;
use App\Events\MessageAttached;
use App\Events\MessageDetached;
use App\Events\ScreenUpdated;
use App\Models\Message;
use App\Models\Order;

class ScreenController extends Controller
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
    public function store(StoreScreenRequest $request)
    {
        $screen = Auth::user()->screens()->create($request->only('title', 'location', 'presentation_mode', 'has_message_bar'));

        return redirect()->back()
            ->with('success', trans("screen created successfully"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Screen  $screen
     * @return \Illuminate\Http\Response
     */
    public function show(Screen $screen)
    {
        $orders = Order::where([
            ['screen_id', $screen->id],
            ['status', '!=', "served"]
        ])->orderByRaw("FIELD(status , 'serving','waiting') ASC")->paginate(8);

        $userAttachments = Auth::user()->attachments;
        $userMessages = Auth::user()->messages;
        return view('screens.show', [
            'screen' => $screen,
            'userAttachments' => $userAttachments,
            'userMessages' => $userMessages,
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Screen  $screen
     * @return \Illuminate\Http\Response
     */
    public function edit(Screen $screen)
    {
        //asc
    }

    /**asc
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Screen  $screen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Screen $screen)
    {
        $screen->update([
            'title' => $request->has('title') ? $request->input('title') : $screen->title,
            'location' => $request->has('location') ? $request->input('location') : $screen->location,
            'has_message_bar' => $request->has('has_message_bar') ? 1 : 0,
            'presentation_mode' => $request->input('presentation_mode')
        ]);
        event(new ScreenUpdated($screen));
        return redirect()->back()
            ->with('success', trans("screen updated successfully"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Screen  $screen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Screen $screen)
    {
        $screen->delete();

        return redirect()->back()
            ->with('success', trans("screen updated successfully"));
    }

    public function assignAttachment(Screen $screen, Attachment $attachment)
    {
        $screen->attachments()->attach($attachment);

        event(new AttachmentAttached($screen, $attachment));

        return redirect()->back()
            ->with('success', trans("attachment linked successfully"));
    }

    public function assignMessage(Screen $screen, Message $message)
    {
        $screen->messages()->attach($message);

        event(new MessageAttached($screen, $message));

        return redirect()->back()
            ->with('success', trans("message linked successfully"));
    }

    public function showScreen(Screen $screen)
    {
        return view('screens.showScreen', [
            'screen' => $screen
        ]);
    }

    public function resource(Screen $screen)
    {
        return response()->json(new ScreenResource($screen));
    }

    public function detach(Screen $screen, $object, $type)
    {
        switch ($type) {
            case 'attachment':
                $attachment = Attachment::findOrFail($object);
                $screen->attachments()->detach($attachment);
                event(new AttachmentDetached($screen, $attachment));
                return redirect()->back()
                    ->with('success', trans("attachment detached successfully"));
                break;
            case 'message':
                $message = Message::findOrFail($object);
                $screen->messages()->detach($message);

                event(new MessageDetached($screen, $message));

                return redirect()->back()
                    ->with('success', trans("message detached successfully"));
                break;
        }
    }
}
