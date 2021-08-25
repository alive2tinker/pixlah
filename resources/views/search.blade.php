@extends('layouts.app')
@section('content')
    <div class="container-fluid mt--6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Search Results') }}</h3>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home">{{ __('screens ') }}<span class="badge badge-info">{{ count($screens) }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu1">{{ __('attachments ') }}<span class="badge badge-info">{{ count($attachments) }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu2">{{ __('messages ') }}<span class="badge badge-info">{{ count($messages) }}</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane active"><br>
                        <div class="list-group">
                            @forelse($screens as $screen)
                                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $screen->title }}</h5>
                                        <small>{{ $screen->created_at }}</small>
                                    </div>
                                </a>
                            @empty
                                <h4 class="text-center">{{ __('No data') }}</h4>
                            @endforelse
                            {{ $screens->links() }}
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade"><br>
                        <div class="list-group">
                            @forelse($attachments as $attachment)
                                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $attachment->title }}</h5>
                                        <small>{{ $attachment->created_at }}</small>
                                    </div>
                                    <ul>
                                        <li>type: {{ $attachment->type }}</li>
                                        <li>screens: {{ count($attachment->screens) }}</li>
                                    </ul>
                                </a>
                            @empty
                                <h4 class="text-center">{{ __('No data') }}</h4>
                            @endforelse
                            {{ $attachments->links() }}
                        </div>
                    </div>
                    <div id="menu2" class="tab-pane fade"><br>
                        @forelse($messages as $message)
                            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $message->text }}</h5>
                                    <small>{{ $message->created_at }}</small>
                                </div>
                            </a>
                        @empty
                            <h4 class="text-center">{{ __('No data') }}</h4>
                        @endforelse
                        {{ $messages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
