@extends('layouts.app')

@section('content')
<div class="flex flex-col lg:flex-row min-h-screen bg-gray-100">
    <div class="w-full lg:w-64 bg-white p-4 lg:fixed lg:h-screen lg:overflow-y-auto">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">TaskMaster</h2>
        <nav class="mb-4">
            <ul class="space-y-2">
                <li>
                    <a href="#" class="flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-purple-100 hover:text-purple-700 transition duration-300">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-purple-100 hover:text-purple-700 transition duration-300">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                        </path>
                    </svg>
                        Profile
                    </a>
                </li>
            </ul>
        </nav>
        <hr class="my-4 border-gray-200" />
        <div class="mt-4">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Quick Stats</h3>
            <div class="space-y-3">
                <div class="bg-purple-100 rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <span class="text-purple-700">Todo</span>
                        <span id="todo-tasks" class="text-2xl font-bold text-purple-700">{{ $tasks->where('status', 'todo')->count() }}</span>
                    </div>
                </div>
                <div class="bg-amber-100 rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <span class="text-amber-700">In Progress</span>
                        <span id="in-progress-tasks" class="text-2xl font-bold text-amber-700">{{ $tasks->where('status', 'in progress')->count() }}</span>
                    </div>
                </div>
                <div class="bg-green-100 rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <span class="text-green-700">Completed</span>
                        <span id="completed-tasks" class="text-2xl font-bold text-green-700">{{ $tasks->where('status', 'done')->count() }}</span>
                    </div>
                </div>
                <div class="bg-blue-100 rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <span class="text-blue-700">Total Tasks</span>
                        <span id="total-tasks" class="text-2xl font-bold text-blue-700">{{ $tasks->count() }}</span>
                    </div>
                </div>
            </div>
            <hr class="my-4 border-gray-200" />
            <div class="mt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-gray-700 rounded-lg hover:bg-red-100 hover:text-red-700 transition duration-300">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="flex-grow lg:ml-64 p-4 lg:overflow-y-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Task Master</h1>
            <button onclick="openModal()" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition duration-300 ease-in-out flex items-center shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create Task
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach(['todo' => 'Todo', 'in progress' => 'In Progress', 'done' => 'Completed'] as $status => $title)
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <h2 class="text-xl font-semibold mb-4 @if($status == 'todo') text-purple-600 @elseif($status == 'in progress') text-amber-500 @else text-emerald-500 @endif">{{ $title }}</h2>
                <div class="space-y-4" id="{{ $status }}">
                    @foreach($tasks->where('status', $status) as $task)
                    @include('tasks.partials.task-card', ['task' => $task])
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div id="createTaskModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-8 w-full max-w-md">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-900">Create New Task</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="createTaskForm" method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" id="title" name="title" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="3" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-purple-500"></textarea>
            </div>
            <div class="mb-4">
                <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                <input type="date" id="due_date" name="due_date" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-purple-500">
                    <option value="todo">Todo</option>
                    <option value="in progress">In Progress</option>
                    <option value="done">Completed</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                <select id="priority" name="priority" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-purple-500">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition duration-300 ease-in-out">Create Task</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('createTaskModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('createTaskModal').classList.add('hidden');
    }

    function updateTaskStatus(taskId, status) {
        console.log(`Updating task ${taskId} to status ${status}`);
        fetch(`/tasks/${taskId}/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    status: status
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response:', data);
                if (data.success) {
                    const taskElement = document.querySelector(`div[data-task-id="${taskId}"]`);
                    const newSection = document.getElementById(status);
                    newSection.appendChild(taskElement);
                    updateQuickStats(data.stats);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function updateQuickStats(stats) {
        console.log('Updating quick stats:', stats);
        document.getElementById('total-tasks').textContent = stats.total;
        document.getElementById('completed-tasks').textContent = stats.completed;
        document.getElementById('in-progress-tasks').textContent = stats.in_progress;
        document.getElementById('todo-tasks').textContent = stats.todo; // Added this line to update the todo tasks count
    }

    document.getElementById('createTaskForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        console.log('Submitting form data:', formData);
        fetch('{{ route('tasks.store') }}', { // Removed spaces within the route helper
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
            .then(response => response.json())
            .then(data => {
                console.log('Response:', data);
                if (data.success) {
                    const statusColumn = document.getElementById(data.task.status);
                    statusColumn.insertAdjacentHTML('afterbegin', data.html);
                    closeModal();
                    this.reset();
                    updateQuickStats(data.stats);
                }
            })
            .catch(error => console.error('Error:', error));
    });

    // New function to handle task editing
    function editTask(taskId) {
        const taskElement = document.querySelector(`div[data-task-id="${taskId}"]`);
        const statusSelect = taskElement.querySelector('select[name="status"]');
        const newStatus = statusSelect.value;

        console.log(`Editing task ${taskId} to new status ${newStatus}`);
        fetch(`/tasks/${taskId}/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    status: newStatus
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response:', data);
                if (data.success) {
                    const newSection = document.getElementById(newStatus);
                    newSection.appendChild(taskElement);
                    updateQuickStats(data.stats);
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>

<style>
    .task-description {
        background-color: rgba(0, 0, 0, 0.05);
        padding: 0.5rem;
        border-radius: 0.25rem;
    }
</style>
@endsection