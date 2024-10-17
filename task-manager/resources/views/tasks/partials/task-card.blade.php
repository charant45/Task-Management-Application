<div class="bg-gray-100 rounded-lg p-4 relative shadow-sm hover:shadow-md transition duration-300 ease-in-out" data-task-id="{{ $task->id }}">
    <div class="flex justify-between items-start mb-2">
        <span class="text-xs px-2 py-1 rounded-full font-semibold 
            @if($task->priority == 'high') text-red-700 bg-red-100 
            @elseif($task->priority == 'medium') text-yellow-700 bg-yellow-100 
            @else text-green-700 bg-green-100 
            @endif">
            {{ ucfirst($task->priority) }}
        </span>
        <div class="relative">
            <select onchange="updateTaskStatus({{ $task->id }}, this.value)" 
                    class="appearance-none bg-transparent border border-gray-300 text-gray-700 py-1 px-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 text-sm">
                <option value="todo" @if($task->status == 'todo') selected @endif>Todo</option>
                <option value="in progress" @if($task->status == 'in progress') selected @endif>In Progress</option>
                <option value="done" @if($task->status == 'done') selected @endif>Completed</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </div>
        </div>
    </div>
    <h3 class="font-semibold text-gray-800 mb-2">{{ $task->title }}</h3>
    <p class="text-sm text-gray-600 mb-3">{{ $task->description }}</p>
    <div class="flex items-center text-xs text-gray-500">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        {{ \Carbon\Carbon::parse($task->created_at)->format('M d, Y') }}
    </div>
</div>