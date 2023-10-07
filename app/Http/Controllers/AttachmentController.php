<?php

namespace App\Http\Controllers;

use App\Events\AttachmentAttached;
use App\Events\AttachmentDetached;
use App\Http\Requests\StoreAttachmentRequest;
use App\Models\Attachment;
use App\Models\Screen;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Log;
use Atymic\Twitter\Facade\Twitter;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
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
    public function store(StoreAttachmentRequest $request)
    {
        $attachment = null;
        switch($request->input('type'))
        {
            case 'image':
                $attachment = Auth::user()->attachments()->create([
                    'type' => $request->input('type'),
                    'title' => $request->file('attachment')->getClientOriginalName(),
                    'duration' => $request->input('duration'),
                    'link' => "/storage/" . $request->file('attachment')->storeAs('attachments',$request->file('attachment')->getClientOriginalName(),[
                        'disk' => "public"
                    ])
                ]);
                break;
            case 'quote':
                $attachment = Auth::user()->attachments()->create([
                    'type' => $request->input('type'),
                    'title' => $request->file('attachment')->getClientOriginalName(),
                    'duration' => $request->input('duration'),
                    'quote_text' => $request->input('text'),
                    'link' => "/storage/" . $request->file('attachment')->storeAs('attachments',$request->file('attachment')->getClientOriginalName(),[
                        'disk' => "public"
                    ])
                ]);
                break;
            case 'video':
                $getID3 = new \getID3;
                $file = $getID3->analyze($request->file('attachment'));
                $attachment = Auth::user()->attachments()->create([
                    'type' => $request->input('type'),
                    'title' => $request->file('attachment')->getClientOriginalName(),
                    'duration' => $file['playtime_seconds'],
                    'link' => "/storage/" . $request->file('attachment')->storeAs('attachments',$request->file('attachment')->getClientOriginalName(),[
                        'disk' => "public"
                    ])
                ]);
                break;
            case 'twitter':
                $link = explode('/', $request->input('link'));
                $tweetId = end($link);
                $tweetId = explode('?', $tweetId)[0];
                $tweet = Twitter::getTweet($tweetId, ['tweet_mode' => "extended"]);
                $tweetUserInfo = ['profileImage' => $tweet->user->profile_image_url, 'user' => $tweet->user->name] ;
                $tweetImages = [];
                if(isset($tweet->extended_entities->media)) {
                    foreach ($tweet->extended_entities->media as $key => $media) {
                        $image = file_get_contents($media->media_url);
                        $filename = $tweet->user->name . time() .".jpg";
                        Storage::disk('public')->put("/attachments/" . $filename,$image);
                        $path = url('/') . '/storage/attachments/' . $filename;
                        array_push($tweetImages, $path);
                    }
                }

                $attachment = Auth::user()->attachments()->create([
                    'title' => $tweet->user->name,
                    'type' => $request->input('type'),
                    'quote_text' => $tweet->full_text,
                    'tweet_info' => ['user' => $tweetUserInfo, 'images' => $tweetImages]
                ]);
                break;
            case 'youtube':
                $youtubeID = explode('/', $request->input('link'));
                $youtubeID = end($youtubeID);
                $attachment = Auth::user()->attachments()->create([
                    'title' => 'Youtube-' . time(),
                    'type' => $request->input('type'),
                    'sm_link' => $youtubeID,
                    'duration' => $request->input('duration')
                ]);
                break;
        }

        $screen = Screen::findOrFail($request->input('screen'));
        $screen->attachments()->attach($attachment);

        event(new AttachmentAttached($screen, $attachment));

        return response()->json("attachment saved successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function show(Attachment $attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(Attachment $attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attachment $attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attachment $attachment, Request $request)
    {
        foreach($attachment->screens as $screen){
            $attachment->screens()->detach($screen);
            event(new AttachmentDetached($screen, $attachment));
        }
        //delete file before deleting attachment
        Storage::disk('public')->delete("attachments/{$attachment->title}");
        $attachment->delete();
        return redirect()->back()
        ->with('success', "attachment deleted successfully");
    }
}
