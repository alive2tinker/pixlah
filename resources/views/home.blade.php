@extends('layouts.app')

@section('content')
<div class="container-fluid mt--6">
  <div class="modal fade" id="new-message-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pt-0">
          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="true">new message</a>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
              <form action="{{ route('messages.store') }}" method="post">
                @csrf
                <div class="form-group">
                  <label for="message-text">Text</label>
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
                  <div class="col-md-5"><button class="btn btn-primary btn-block" type="submit">Save</button></div>
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
          <h5 class="modal-title" id="exampleModalLabel">New Screen</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="new-screen-form" action="{{ route('screens.store') }}" method="post">
            @csrf
            <div class="form-group">
              <label for="screen-title">Title</label>
              <input type="text" class="form-control" name="title" value="{{old('title')}}" placeholder="reference title">
            </div>
            <div class="form-group">
              <label for="screen-title">Location</label>
              <input type="text" class="form-control" name="location" value="{{ old('location') }}" placeholder="physical location">
            </div>
            <div class="form-group">
              <label for="">Has a message bar?</label>
              <label class="custom-toggle mx-2">
                <input type="checkbox" name="has_message_bar" id="hmb-value">
                <span class="custom-toggle-slider rounded-circle" id="hmb-check" data-label-off="No" data-label-on="Yes"></span>
              </label>
            </div>
            <div class="form-group">
              <label for="">Presentation Mode</label>
              <select class="form-control mx-2" id="exampleFormControlSelect1">
                <option value="standard">Standard</option>
                <option value="theater">theater</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="new-screen-submit">Save changes</button>
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
              <label for="screen-title">Title</label>
              <input type="text" class="form-control" name="title" value="{{old('title', $screen->title)}}" placeholder="reference title">
            </div>
            <div class="form-group">
              <label for="screen-title">Location</label>
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
              <label for="">Presentation Mode</label>
              <select class="form-control mx-2" name="presentation_mode" id="exampleFormControlSelect1">
                <option @if($screen->presentation_mode == 'standard') selected @endif value="standard">Standard</option>
                <option @if($screen->presentation_mode == 'theater') selected @endif value="theater">theater</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary edit-screen-submit" data-id="{{$screen->id}}">Save changes</button>
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
              <h3 class="mb-0">Screens</h3>
            </div>
            <div class="col text-right">
              <button type="button" data-toggle="modal" data-target="#new-screen-modal" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <!-- Projects table -->
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">Title</th>
                <th scope="col">Location</th>
                <th scope="col">Attachment Count</th>
                <th scope="col">Actions</th>
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
                  <h4 class="text-center">no data</h4>
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
              <h3 class="mb-0">Attachments</h3>
            </div>
            <div class="col text-right">
              <button type="button" data-toggle="modal" data-target="#new-screen-modal" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <!-- Projects table -->
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">Title</th>
                <th scope="col">Type</th>
                <th scope="col">Duration</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($attachments as $attachment)
              <tr>
                <th scope="row">
                  {{ $attachment->title }}
                </th>
                <td>
                  {{ $attachment->location }}
                </td>
                <td>
                  {{ $attachment->duration }}
                </td>
                <td>
                  <div class="btn-group" role="group" aria-label="Basic example">
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
                  <h4 class="text-center">no data</h4>
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
              <h3 class="mb-0">Messages</h3>
            </div>
            <div class="col text-right">
              <button data-target="#new-message-modal" data-toggle="modal" class="btn btn-sm btn-primary">New Message</button>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <!-- Projects table -->
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">Text</th>
                <th scope="col">Delete</th>
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
                  <h4 class="text-center">No messages</h4>
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
              <h3 class="mb-0">Widgets</h3>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <!-- Projects table -->
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                  <th scope="row"><i class="fa fa-cloud"></i> Weather</th>
                  <td><button class="btn btn-outline-success">Enable</button></td>
                </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <footer class="footer pt-0">
    <div class="row align-items-center justify-content-lg-between">
      <div class="col-lg-6">
        <div class="copyright text-center  text-lg-left  text-muted">
          &copy; 2020 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Creative Tim</a>
        </div>
      </div>
      <div class="col-lg-6">
        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
          <li class="nav-item">
            <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
          </li>
          <li class="nav-item">
            <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
          </li>
          <li class="nav-item">
            <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
          </li>
          <li class="nav-item">
            <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md" class="nav-link" target="_blank">MIT License</a>
          </li>
        </ul>
      </div>
    </div>
  </footer>
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