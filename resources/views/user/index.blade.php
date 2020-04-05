@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @error('alert-danger')
                <div class="alert alert-danger" role="alert">
                    {{$message}}
                </div>
                @enderror
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="h-100">Список заявок</div>
                        <a type="button" class="btn btn-primary pb-1" href="{{route('create')}}">
                            <span class="oi" data-glyph="plus" aria-hidden="true"></span>
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($applications->isEmpty())
                            Заявок нет
                        @else
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Тема</th>
                                <th scope="col">Менеджер</th>
                                <th scope="col">Статус</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($applications as $index => $application)
                                <tr class="
                            {{$application->lastMessageFromManager() == true && $application->status == 'open' ? 'table-info' : ''}}
                                {{$application->status == 'close' ? 'table-dark' : ''}}
                                    ">
                                    <th scope="row">{{$index + 1}}</th>
                                    <td> <a href="{{route('show', ['application' => $application->id, 'preview-page' => app('request')->input('page')])}}">{{$application->subjectForList()}}</a></td>
                                    <td>{{empty($application->manager) ? 'Нет' : $application->manager->email }}</td>
                                    <td>{{$application->status == 'open' ? 'открыта' : 'закрыта'}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                            <div class="row justify-content-center">
                                <div class="col-auto">{{$applications->withQueryString()->links()}}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
