@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="h-100">Заявка №{{$application->id}} @if($application->status == 'close') (закрыта) @endif</div>
                        <a class="btn btn-outline-primary" href="{{route('m-list', ['page' => app('request')->input('preview-page')])}}">Назад</a>
                    </div>

                    <div class="card-body">
                        <h4>{{$application->subject}}</h4>
                        <div class="d-flex flex-column">
                            @foreach($application->messages as $message)
                                @if ($message->user->role == 'user')
                                    <div class="bg-primary col-10 my-2 p-2 rounded text-light">
                                        <div class="mb-1">{{$message->message}}</div>
                                        <div class="d-flex justify-content-between">
                                            <div class="font-weight-bold text-white-50 small">{{$message->created_at}}</div>
                                            <div class="dropdown">
                                                @if ($message->files->count() > 0)
                                                    <a class="font-weight-bold text-white small" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Вложений ({{$message->files->count()}})
                                                    </a>
                                                @endif
                                                <div class="dropdown-menu drop" aria-labelledby="dropdownMenuLink">
                                                    <h6 class="dropdown-header">Вложения</h6>
                                                    @foreach($message->files as $file)
                                                        <a class="dropdown-item" href="{{'/storage/'.$file->path}}" target="_blank">{{$file->name}}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-primary offset-2 col-10 my-2 p-2 rounded text-light">
                                        <div class="mb-1">{{$message->message}}</div>
                                        <div class="d-flex justify-content-between">
                                            <div class="font-weight-bold text-white-50 small">{{$message->created_at}}</div>
                                            <div class="dropdown">
                                                @if ($message->files->count() > 0)
                                                    <a class="font-weight-bold text-white small" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Вложений ({{$message->files->count()}})
                                                    </a>
                                                @endif
                                                <div class="dropdown-menu drop" aria-labelledby="dropdownMenuLink">
                                                    <h6 class="dropdown-header">Вложения</h6>
                                                    @foreach($message->files as $file)
                                                        <a class="dropdown-item" href="{{'/storage/'.$file->path}}" target="_blank">{{$file->name}}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        @if($application->status == 'open')
                            <hr>
                            <form method="post" enctype="multipart/form-data" action="{{route('update', ['application' => $application->id])}}">
                                @csrf
                                <input type="hidden" name="page" value="{{app('request')->input('preview-page')}}">
                                <div class="form-group">
                                    <label>Текст сообщения</label>
                                    <textarea class="form-control mh-25 @error('message') is-invalid @enderror" name="message">{{old('message')}}</textarea>
                                    @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Вложения</label>
                                    <input type="file" name="attachments[]" multiple class="form-control-file @error('attachments') is-invalid @enderror">
                                    @error('attachments')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-between">

                                    <a class="btn btn-danger" href="{{route('close', [ 'application' => $application->id, 'page' => app('request')->input('page') ])}}">Закрыть</a>
                                    <input type="submit" value="Отправить" class="btn btn-primary ml-auto">
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
