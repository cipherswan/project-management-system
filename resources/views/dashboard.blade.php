@extends('layouts.app')

@section('content')
<div class="container">
    {{-- new project modal --}}
    <div class="modal fade" id="newProjModal" tabindex="-1" role="dialog" aria-labelledby="newProjModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'ProjectsController@store', 'method' => 'POST']) !!}
                        <div class="form-group">
                            {{ Form::text('project', '', ['class' => 'form-control', 'placeholder' => 'My Project'])}}
                        </div>
                        <div class="form-group">
                            {{ Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => 'Description'])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('due_date', 'Due')}}
                            {{ Form::date('due_date', \Carbon\Carbon::now(), ['class' => 'form-control', 'placeholder' => 'Due date'])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('priority', 'Priority')}}
                            {{ Form::select('priority', ['High priority' => 'High', 'Medium priority' => 'Medium', 'Low priority' => 'Low'], 'S', ['class' => 'form-control']) }}
                        </div>
                        {{ Form::submit('Submit', ['class' => 'btn btn-global'])}}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-8 dashboardProjectsColumn">
            <h3 class="my-4">My projects
                <button type="button" class="btn btn-global btn-sm ml-1" data-toggle="modal" data-target="#newProjModal">Add new project</button>
            </h3>
            @if (count($projects) > 0)   
                @foreach ($projects as $proj)
                    <a href="/projects/{{$proj->id}}">
                        <div class="globalCard projectCard mb-2">
                            <div class="projectCard-title">
                                <h5>{{$proj->name}}</h5>
                                <div class="d-flex">
                                    <priority-component priority="{{$proj->priority}}"></priority-component>

                                    {!! Form::open(['action' => ['ProjectsController@destroy', $proj->id], 'method' => 'POST']) !!}
                                        {{ Form::hidden('_method', 'DELETE')}}
                                        <button type="submit" class="btn btn-outline-danger btn-sm ml-1"><i class="fas fa-trash-alt"></i></button>
                                    {!! Form::close() !!}

                                </div>
                            </div>
                            @php
                                $today = date("Y-m-d");
                                $dueDate = date("Y-m-d", strtotime($proj->due_date));
                                $due = false;

                                $date1=date_create($today);
                                $date2=date_create($dueDate);
                                $diff=date_diff($date1,$date2);
                        
                                if ((int)$diff->format("%r%a") >= 0 && (int)$diff->format("%r%a") <=5 ) {
                                    $due = true;
                                }
                            @endphp
                                
                            <task-due duedate="{{date('Y-m-d', strtotime($proj->due_date))}}" isdue={{$due}}></task-due>
                            <span class="badge">
                                @php
                                    if ((int)$diff->format("%r%a") < 0) {
                                        echo 'Past deadline';
                                    }
                                    else{
                                        echo $diff->format("%d days");
                                    }
                                @endphp         
                            </span>
                            
                            <div class="progress mt-4" style="height: 15px">
                                <div class="progress-bar" role="progressbar" aria-valuenow="{{$proj->getProjectProgress()}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$proj->getProjectProgress()}}%; font-weight: bold"></div>
                            </div>
                        </div>   
                    </a>
                @endforeach  
            @else
                <p>No projects yet</p>
            @endif 
        </div>

        <div class="col-lg-4 dashboardCheckColumn">
            <h3 class="my-4">My personal checklist</h3>
            {!! Form::open(['action' => 'ChecklistsController@store', 'method' => 'POST']) !!}
                <div class="form-group">
                    {{ Form::text('checklist_title', '', ['class' => 'form-control globalInput', 'placeholder' => 'Add your task here...'])}}
                </div>
                <div class="form-group">
                    {{ Form::hidden('is_done', '0', ['class' => 'form-control']) }}
                </div>
                {{-- {{ Form::submit('Submit', ['class' => 'btn btn-global btn-sm'])}} --}}
            {!! Form::close() !!}

                @foreach ($checklists as $c)

                    <div class="globalCard mb-2">
                        <div class="checklistHolder">
                            <global-status-component taskname="{{$c->checklist_title}}" status="{{$c->is_done}}"></global-status-component>
                            {!! Form::model($c, [
                                'method' => 'PATCH',
                                'route' => ['checklists.update', $c->id]
                            ]) !!}
    
                            <div class="d-flex">
                            @if ($c->is_done == 0)
                                <div class="form-group mb-0"> 
                                    {{ Form::hidden('is_done', '1', ['class' => 'form-control'])}}
                                </div>
                                <button type="submit" class="btn btn-global btn-sm"><i class="fas fa-check"></i></button>
                            @else
                                <div class="form-group mb-0"> 
                                    {{ Form::hidden('is_done', '0', ['class' => 'form-control'])}}
                                </div>
                                <button type="submit" class="btn btn-global btn-sm" style="padding: 0.25rem 0.65rem"><i class="fas fa-times"></i></button>                           
                            @endif
                            {!! Form::close() !!}

                            {!! Form::open(['action' => ['ChecklistsController@destroy', $c->id], 'method' => 'POST']) !!}
                                {{ Form::hidden('_method', 'DELETE')}}
                                <button type="submit" class="btn btn-outline-danger btn-sm ml-2"><i class="fas fa-trash-alt"></i></button>
                            {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    
                    
                @endforeach
                
        </div>

    </div>

</div>
@endsection
