@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Список заявок</div>

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Тема</th>
                                <th scope="col">Менеджер</th>
                                <th scope="col">Статус</th>
                                <div class="dropdown show mb-1">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Фильтр
                                    </a>
                                    <a type="button" class="btn btn-primary" href="{{route('m-list')}}">
                                        <span class="oi" data-glyph="loop-circular" aria-hidden="true"></span>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        @if (app('request')->input('filter') == 'close')
                                            <a class="dropdown-item" href="{{route('m-list', ['filter' => 'open'])}}">Закрытые / незакрытые</a>
                                        @else
                                            <a class="dropdown-item" href="{{route('m-list', ['filter' => 'close'])}}">Закрытые / незакрытые</a>
                                        @endif

                                        @if (app('request')->input('filter') == 'no-view')
                                            <a class="dropdown-item" href="{{route('m-list', ['filter' => 'view'])}}">Просмотренные / непросмотренные</a>
                                        @else
                                            <a class="dropdown-item" href="{{route('m-list', ['filter' => 'no-view'])}}">Просмотренные / непросмотренные</a>
                                        @endif

                                        @if (app('request')->input('filter') == 'no-view')
                                            <a class="dropdown-item" href="{{route('m-list', ['filter' => 'answered'])}}">Отвеченные / неотвеченные</a>
                                        @else
                                            <a class="dropdown-item" href="{{route('m-list', ['filter' => 'no-answered'])}}">Отвеченные / неотвеченные</a>
                                        @endif
                                    </div>
                                </div>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($applications as $application)
                            <tr class="
                            {{$application->view == false && $application->status == 'open' ? 'table-info' : ''}}
                            {{$application->status == 'close' ? 'table-dark' : ''}}
                                ">
                                <th scope="row">{{$application->id}}</th>
                                <td> <a href="{{route('m-show', ['application' => $application->id, 'preview-page' => app('request')->input('page')])}}">{{$application->subjectForList()}}</a></td>
                                <td>{{empty($application->manager) ? 'Нет' : $application->manager->email }}</td>
                                <td>{{$application->status == 'open' ? 'открыта' : 'закрыта'}}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row justify-content-center">
                            <div class="col-auto">{{$applications->withQueryString()->links()}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
