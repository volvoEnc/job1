@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="h-100">Новая заявка</div>
                    </div>

                    <div class="card-body">
                        <h4>Создание заявки</h4>
                        <form method="post" enctype="multipart/form-data" action="{{route('store')}}">
                            @csrf
                            <div class="form-group">
                                <label>Тема</label>
                                <input class="form-control mh-25 @error('subject') is-invalid @enderror" name="subject" value="{{old('subject')}}">
                                @error('subject')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
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
                                <input type="submit" value="Создать" class="btn btn-primary ml-auto">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
