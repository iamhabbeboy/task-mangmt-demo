<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Task Management</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<!-- component -->
<body class="antialiased bg-slate-200 text-slate-700 mx-2">
<div class="max-w-xl mx-auto my-10 bg-white p-8 rounded-xl shadow shadow-slate-300">
    <div class="flex flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-medium">Task Management</h1>
        </div>
        <div class="inline-flex space-x-2 items-center">
            <button class="bg-indigo-500 p-2 rounded-md text-white text-sm" id="add-task">Add Task</button>
        </div>
    </div>
    <p class="text-slate-500">Hello, here are your latest tasks</p>
    @if (session('success'))
        <div class="p-2 text-sm bg-blue-400 rounded-md text-white">
            {{ session('success') }}
        </div>
    @endif
    <div id="tasks" class="my-5">
        <label>
            <select class="p-2 ml-3" id="existing-project">
                <option value="">Select project</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}"
                            @if($project->id == $projectId)
                            selected="true"
                        @endif
                    > {{ $project->name }}</option>
                @endforeach
            </select>
        </label>
        <div id="task-form"
             class="flex hidden justify-between items-center border-b border-slate-200 py-3 px-2 border-l-4  border-l-transparent">
            <div class="inline-flex items-center space-x-2">
                <div class="text-slate-500">
                    <label class="flex justify-between">
                        <input type="text" class="border w-40 text-sm p-2 outline-none" placeholder="New Project Name"
                               id="project-name">
                        &nbsp;
                        <input type="text" class="border w-32 text-sm p-2 outline-none" placeholder="Task Name"
                               id="task-name"/>
                        &nbsp;
                        <input type="number" class="border w-14 text-sm p-2 outline-none" placeholder="Priority"
                               id="task-priority"/>
                    </label>
                </div>
            </div>
            <div>
                <button class="bg-indigo-500 p-2 rounded-md text-white text-sm" id="add-new-task">Add+</button>
            </div>
        </div>
        <ul id="sortable">
            @forelse($tasks as $task)
                <li id="task-priority-{{ $task->id }}">
                    <div id="task" data-id="{{ $task->id }}" title="Double click to edit"
                         class="task-elem flex justify-between items-center border-b border-slate-200 py-3 px-2 border-l-4  border-l-transparent bg-gradient-to-r from-transparent to-transparent hover:from-slate-100 transition ease-linear duration-150">
                        <div class="inline-flex items-center space-x-2 w-10/12">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor"
                                     class="w-6 h-6 text-slate-500 hover:text-indigo-600 hover:cursor-pointer">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="task" data-id="{{$task->id}}">#<span class="task-id-{{ $task->id }}">{{ $task->priority }}</span> {{ $task->name }}</div>
                            <div class="hidden task-show-{{ $task->id }}">
                                <label>
                                    <input type="text" class="border text-sm p-2 task-text-{{ $task->id }}"
                                           value="{{ $task->name }}"/>
                                </label>
                            </div>
                        </div>
                        <div>
                            <div class="flex task-show-{{ $task->id }} hidden" data-id="{{ $task->id }}">
                                <button class="bg-indigo-500 p-2 rounded-md text-white text-sm update">Update</button>
                                <button class="ml-2 bg-red-400 p-2 rounded-md text-white text-sm task-cancel">Cancel
                                </button>
                            </div>
                            <div id="task-icon-{{ $task->id }}" class="delete">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor"
                                     class="w-4 h-4 text-slate-500 hover:text-slate-700 hover:cursor-pointer">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <h1>No Task found </h1>
            @endforelse
        </ul>
        <div class="d-flex justify-content-center mt-3">
            {!! $tasks->links() !!}
        </div>
    </div>
</div>

<form id="form">
    @csrf
    <input type="hidden" name="_method" id="method"/>
</form>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
{{--<script src="https://code.jquery.com/jquery-3.7.0.slim.min.js"--}}
{{--        integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>--}}
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
@vite('resources/js/app.js')
</html>
