@extends('layouts.app')
@section('content')
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
              <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">{{ __('from database') }}</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">{{ __('new message') }}</a>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">{{ __('Text') }}</th>
                <th scope="col">{{ __('Action') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse($userMessages as $message)
                <tr>
                  <th scope="row">{{ $message->text }}</th>
                  <td><a href="{{ route('assignMessage', [$screen->id, $message->id]) }}" class="btn btn-success">{{ __('Add Message') }}</a></td>
                </tr>
              @empty
              <tr>
                  <th scope="row" colspan="2"><h4 class="text-center">{{ __('No messages') }}</h4></th>
                </tr>
              @endforelse
            </tbody>
            </table>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
              <form action="{{ route('messages.store') }}" method="post">
                @csrf
                <div class="form-group">
                  <label for="message-text">{{ __('Text') }}</label>
                  <input type="text" name="text" value="{{ old('text') }}" class="form-control" id="message-text">
                </div>
                <input type="hidden" name="screen" value="{{ $screen->id }}">
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
  <div class="modal fade" id="new-attachment-upload-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('New Attachment') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pt-0">
          <new-attachment-form screen="{{$screen->id}}">
            </new-attachment-formscreen>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="new-attachment-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('Attachments') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pt-0">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">{{ __('Title') }}</th>
                <th scope="col">{{ __('Type') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse($userAttachments as $attachment)
              <tr>
                <th scope="row">
                  <a href="{{ route('assignAttachment', [$screen->id, $attachment->id])}}">{{ $attachment->title }}</a>
                </th>
                <td>
                  {{ $attachment->type }}
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
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-8">
      <div class="card">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0 {{ config('app.locale') === 'ar' ? 'rtl' : '' }}">Screen "{{ $screen->title }}"</h3>
            </div>
            <div class="col  {{ config('app.locale') === 'ar' ? 'text-left' : 'text-right' }}">
              <button type="button" data-toggle="modal" data-target="#new-attachment-upload-modal" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button>
              <button type="button" data-toggle="modal" data-target="#new-attachment-modal" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>{{ __(' from gallery') }}</button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form class="form-inline" action="{{ route('screens.update', $screen->id) }}" method="post">
            @method('PATCH')
            @csrf
            <div class="form-group">
              <label for="">{{ __('Has a message bar?') }}</label>
              <label class="custom-toggle mx-2">
                <input type="checkbox" name="has_message_bar" id="hmb-value" @if($screen->has_message_bar) checked value="1" @endif>
                <span class="custom-toggle-slider rounded-circle" id="hmb-check" data-label-off="No" data-label-on="Yes"></span>
              </label>
            </div>
            <div class="form-group">
              <label for="">{{ __('Presentation Mode') }}</label>
              <select class="form-control mx-2" name="presentation_mode">
                <option @if($screen->presentation_mode === "standard") selected @endif value="standard">{{ __('Standard') }}</option>
                <option @if($screen->presentation_mode === "theater") selected @endif value="theater">{{ __('theater') }}</option>
              </select>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">{{ __('Update') }}</button>
            </div>
          </form>
        </div>
        <div class="table-responsive">
          <!-- Projects table -->
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">{{ __('Title') }}</th>
                <th scope="col">{{ __('Type') }}</th>
                <th scope="col">{{ __('Created At') }}</th>
                <th scope="col">{{ __('Actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse($screen->attachments as $attachment)
              <tr>
                <th scope="row">
                  {{ $attachment->title }}
                </th>
                <td>
                  {{ $attachment->type }}
                </td>
                <td>
                  {{ $attachment->created_at }}
                </td>
                <td>
                  <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('screen.detach', [$screen->id, $attachment->id, 'attachment']) }}" class="btn btn-outline-danger"><i class="fa fa-trash"></i></a>
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
      </div>
      <div class="card">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0 {{ config('app.locale') === 'ar' ? 'rtl' : '' }}">{{ __('Orders') }}</h3>
            </div>
            <div class="col  {{ config('app.locale') === 'ar' ? 'text-left' : 'text-right' }}">
              <button type="button" data-toggle="modal" data-target="#new-order-modal" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button>
            </div>
          </div>
        </div>
        <div class="card-body">
        </div>
        <div class="table-responsive">
          <!-- Projects table -->
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">{{ __('Number') }}</th>
                <th scope="col">{{ __('Status') }}</th>
                <th scope="col">{{ __('Actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse($orders as $order)
              <tr>
                <th scope="row">
                  {{ $order->number }}
                </th>
                <td>
                  {{ $order->status }}
                </td>
                <td>
                  <div class="btn-group" role="group" aria-label="Basic example">
                    @if($order->status === 'serving')
                    <a href="{{ route('orderIsServed', $order->id) }}" class="btn btn-success">{{ __('Mark Order Served') }}</a>
                    @else
                    <a href="{{ route('orderIsServing', $order->id) }}" class="btn btn-warning">{{ __('Mark Order Serving') }}</a>
                    @endif
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
      </div>
    </div>
    <div class="col-xl-4">
      <div class="card">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0 {{ config('app.locale') === 'ar' ? 'rtl' : '' }}">{{ __('Messages') }}</h3>
            </div>
            <div class="col  {{ config('app.locale') === 'ar' ? 'text-left' : 'text-right' }}">
              <button data-toggle="modal" data-target="#new-message-modal" class="btn btn-sm btn-primary">{{ __('New Message') }}</button>
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
            @forelse($screen->messages as $message)
                <tr>
                  <th scope="row">{{ Str::limit($message->text, 30, "...") }}</th>
                  <td>
                    <a href="{{ route('screen.detach', [$screen->id, $message->id, 'message']) }}" class="btn btn-outline-danger"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
              @empty
              <tr>
                  <th scope="row" colspan="2"><h4 class="text-center">{{ __('No messages') }}</h4></th>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="card">
        <color-picker></color-picker>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script>
  $().ready(function() {
    $("#hmb-check").click(function(e) {
      e.preventDefault();
      const hmbCheckbox = $("#hmb-value");
      if (hmbCheckbox.attr('checked')) {
        hmbCheckbox.attr('checked', false);
        hmbCheckbox.attr('value', 0);
      } else {
        hmbCheckbox.attr('checked', true);
        hmbCheckbox.attr('value', 1);
      }
    });

    $(".delete-attachment-btn").click(function() {
      var attachmentID = $(this).attr('data-id');
      $("#delete-attachment-form-" + attachmentID).submit();
    })
  })
</script>
@endsection
