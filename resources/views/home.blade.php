@extends('layouts.app')
@section('title', "Home")
@section('content')
    <div class="modal fade" id="new-attachment-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('New Attachment') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <new-attachment-form screen="{{$screen->id ?? ''}}">
                        </new-attachment-form>
                </div>
            </div>
        </div>
    </div>
<div class="container-fluid mt--6">
  <div class="modal fade" id="new-message-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('New Message') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pt-0">
          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="true">{{ __('New Message') }}</a>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
              <form action="{{ route('messages.store') }}" method="post">
                @csrf
                <div class="form-group">
                  <label for="message-text">{{ __('Text') }}</label>
                  <input type="text" name="text" value="{{ old('text') }}" class="form-control" id="message-text">
                </div>
                <div class="form-group">
                  <label for="">Add to all screens?</label>
                  <label class="custom-toggle mx-2">
                    <input type="checkbox" name="all_screens" id="all-screens-value">
                    <span class="custom-toggle-slider rounded-circle" id="all-screens-check" data-label-off="No" data-label-on="Yes"></span>
                  </label>
                </div>
                <div class="form-group row justify-content-center">
                  <div class="col-md-5"><button class="btn btn-primary btn-block" type="submit">{{ __('Save') }}</button></div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="new-screen-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('New Screen') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="new-screen-form" action="{{ route('screens.store') }}" method="post">
            @csrf
            <div class="form-group">
              <label for="screen-title">{{ __('Title') }}</label>
              <input type="text" class="form-control" name="title" value="{{old('title')}}" placeholder="reference title">
            </div>
            <div class="form-group">
              <label for="screen-title">{{ __('Location') }}</label>
              <input type="text" class="form-control" name="location" value="{{ old('location') }}" placeholder="physical location">
            </div>
            <div class="form-group">
              <label for="">{{ __('Show a message bar') }}?</label>
              <label class="custom-toggle mx-2">
                <input type="checkbox" name="has_message_bar" id="hmb-value" value="1">
                <span class="custom-toggle-slider rounded-circle" id="hmb-check" data-label-off="No" data-label-on="Yes"></span>
              </label>
            </div>
            <div class="form-group">
              <label for="">{{ __('Presentation Mode') }}</label>
              <select class="form-control mx-2" id="exampleFormControlSelect1">
                <option value="standard">{{ __('Standard') }}</option>
                <option value="theater">{{ __('theater') }}</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
          <button type="button" class="btn btn-primary" id="new-screen-submit">{{ __('Save changes') }}</button>
        </div>
      </div>
    </div>
  </div>
  @foreach($screens as $screen)
  <div class="modal fade" id="edit-screen-{{$screen->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Screen "{{$screen->title}}"</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="edit-screen-{{$screen->id}}-form" action="{{ route('screens.update', $screen->id) }}" method="post">
            @method('PATCH')
            @csrf
            <div class="form-group">
              <label for="screen-title">{{ __('Title') }}</label>
              <input type="text" class="form-control" name="title" value="{{old('title', $screen->title)}}" placeholder="reference title">
            </div>
            <div class="form-group">
              <label for="screen-title">{{ __('Location') }}</label>
              <input type="text" class="form-control" name="location" value="{{ old('location', $screen->location) }}" placeholder="physical location">
            </div>
            <div class="form-group">
              <label for="">Has a message bar?</label>
              <label class="custom-toggle mx-2">
                <input type="checkbox" name="has_message_bar" id="hmb-value" @if($screen->has_message_bar) checked @endif>
                <span class="custom-toggle-slider rounded-circle" id="hmb-check" data-label-off="No" data-label-on="Yes"></span>
              </label>
            </div>
            <div class="form-group">
              <label for="">{{ __('Presentation Mode') }}</label>
              <select class="form-control mx-2" name="presentation_mode" id="exampleFormControlSelect1">
                <option @if($screen->presentation_mode == 'standard') selected @endif value="standard">{{ __('Standard') }}</option>
                <option @if($screen->presentation_mode == 'theater') selected @endif value="theater">{{ __('theater') }}</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
          <button type="button" class="btn btn-primary edit-screen-submit" data-id="{{$screen->id}}">{{ __('Save changes') }}</button>
        </div>
      </div>
    </div>
  </div>
  @endforeach
  <div class="row">
    <div class="col-xl-8">
      <div class="card">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0 rtl">{{ __('Screens') }}</h3>
            </div>
            <div class="col text-right">
              <button type="button" data-toggle="modal" data-target="#new-screen-modal" class="btn btn-sm btn-primary {{ config('app.locale') === 'ar' ? 'float-left' : '' }}"><i class="fa fa-plus"></i></button>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <!-- Projects table -->
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">{{ __('Title') }}</th>
                <th scope="col">{{ __('Location') }}</th>
                <th scope="col">{{ __('Attachment Count') }}</th>
                <th scope="col">{{ __('Actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse($screens as $screen)
              <tr>
                <th scope="row">
                  {{ $screen->title }}
                </th>
                <td>
                  {{ $screen->location }}
                </td>
                <td>
                  {{ count($screen->attachments)}}
                </td>
                <td>
                  <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('showScreen', $screen->id) }}" class="btn btn-outline-success"><i class="fa fa-tv"></i></a>
                    <a href="{{ route('screens.show', $screen->id) }}" class="btn btn-outline-primary"><i class="fa fa-eye"></i></a>
                    <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#edit-screen-{{$screen->id}}">
                      <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger delete-screen-btn" data-id="{{ $screen->id }}"><i class="fa fa-trash"></i></button>
                    <form id="delete-screen-form-{{$screen->id}}" action="{{ route('screens.destroy', $screen->id)}}" method="post">
                      @csrf
                      @method('DELETE')
                    </form>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <th colspan="4" scope="row">
                  <h4 class="text-center">{{ __('no data') }}</h4>
                </th>
              </tr>
              @endforelse
            </tbody>
          </table>
            {{ $screens->links('argon_paginator') }}
        </div>
      </div>
      <div class="card">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0 rtl">{{ __('Attachments') }}</h3>
            </div>
            <div class="col text-right">
              <button type="button" data-toggle="modal" data-target="#new-attachment-modal" class="btn btn-sm btn-primary {{ config('app.locale') === 'ar' ? 'float-left' : '' }}"><i class="fa fa-plus"></i></button>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <!-- Projects table -->
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">{{ __('Title') }}</th>
                <th scope="col">{{ __('Type') }}</th>
                <th scope="col">{{ __('Duration') }}</th>
                <th scope="col">{{ __('Actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse($attachments as $attachment)
              <tr>
                <th scope="row">
                  {{ $attachment->title }}
                </th>
                <td>
                  {{ $attachment->type }}
                </td>
                <td>
                  {{ $attachment->duration }}
                </td>
                <td>
                  <div class="btn-group" role="group" aria-label="Basic example">
                    <form action="{{ route('attachments.destroy', $attachment->id)}}" method="post">
                      @csrf
                      @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger delete-screen-btn"><i class="fa fa-trash"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <th colspan="4" scope="row">
                  <h4 class="text-center">{{ __('no data') }}</h4>
                </th>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
          <div class="card-footer">
              {{ $attachments->links('argon_paginator') }}
          </div>
      </div>
    </div>
    <div class="col-xl-4">
      <div class="card">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0 rtl">{{ __('Messages') }}</h3>
            </div>
            <div class="col text-right">
              <button data-target="#new-message-modal" data-toggle="modal" class="btn btn-sm btn-primary {{ config('app.locale') === 'ar' ? 'float-left' : '' }}">{{ __('New Message') }}</button>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <!-- Projects table -->
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">{{ __('Text') }}</th>
                <th scope="col">{{ __('Delete') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse($messages as $message)
              <tr>
                <th scope="row">{{ Str::limit($message->text, 30, "...") }}</th>
                <td>
                  <form action="{{route('messages.destroy', $message->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger" type="submit"><i class="fa fa-trash"></i></button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <th scope="row" colspan="2">
                  <h4 class="text-center">{{ __('No messages') }}</h4>
                </th>
              </tr>
              @endforelse
            </tbody>
          </table>
            {{ $messages->links('argon_paginator') }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script>
  $(document).ready(function() {

    $("#new-screen-submit").click(function() {
      $("#new-screen-form").submit();
    });

    $(".edit-screen-submit").click(function() {
      var screenID = $(this).attr('data-id');
      $("#edit-screen-" + screenID + "-form").submit();
    });

    $("#all-screens-check").click(function(e) {
      e.preventDefault();
      const hmbCheckbox = $("#all-screens-value");
      if (hmbCheckbox.attr('checked')) {
        hmbCheckbox.attr('checked', false);
        hmbCheckbox.attr('value', 0);
      } else {
        hmbCheckbox.attr('checked', true);
        hmbCheckbox.attr('value', 1);
      }
    });

    $(".delete-screen-btn").click(function() {
      var screenID = $(this).attr('data-id');
      $("#delete-screen-form-" + screenID).submit();
    })
  });
</script>
@endsection
