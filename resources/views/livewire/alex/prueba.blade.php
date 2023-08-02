<div>
    <h1>Todo List</h1>

    <ul>
        @foreach ($tasks as $task)
            <li>{{ $task }}</li>
        @endforeach
    </ul>

    <form wire:submit.prevent="addTask">
        <label for="newTask">New task:</label>
        <input type="text" id="newTask" wire:model="newTask">
        <button type="submit">Add</button>
    </form>
</div>