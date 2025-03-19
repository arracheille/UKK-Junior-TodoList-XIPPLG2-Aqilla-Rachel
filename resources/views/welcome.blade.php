<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>To-Do List</title>

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet"
        />

        <script src="https://kit.fontawesome.com/1a293db120.js" crossorigin="anonymous"></script>

        <style>
        :root {
            --cream: #f5f3c1;
            --light-green: #27e1c1;
            --mid-green: #0ea293;
            --dark-blue: #2f0f5d;

            --dark-01: rgb(47, 15, 93, 0.1);
            --dark-02: rgb(47, 15, 93, 0.2);
            --dark-03: rgb(47, 15, 93, 0.3);
            --dark-05: rgba(48, 15, 93, 0.5);
            --dark-08: rgba(48, 15, 93, 0.8);
        }
        body {
            background: linear-gradient(
            135deg,
            var(--cream),
            var(--light-green)
            );
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
            color: var(--dark-blue);
        }
        .container {
            display: flex;
            justify-content: center;
            gap: 20px;
            width: 100%;
        }
        .content {
            box-shadow: 0 4px 6px var(--dark-01);
            background: white;
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            max-height: 70vh;
            overflow-y: auto;
        }
        .content:first-child{
            max-width: 22vw;
        }
        .content:last-child{
            max-width: 53vw;
        }
        h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark-blue);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        h1 span {
            margin-left: 10px;
        }
        .input-group {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .input-group input,
        .input-group select {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid var(--dark-02);
            color: var(--dark-blue);
            border-radius: 5px;
            outline: none;
        }
        .input-group input::placeholder {
            color: var(--dark-03);
        }
        .input-group button {
            background: var(--mid-green);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .input-group button:hover {
            background: #0c8377;
        }
        table{
            width: 100%;
        }
        td span{
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 10px;
        }
        td.action span{
            justify-content: flex-end;
        }
        td.number span{
            padding-right: 10px;
            font-weight: 600;
        }
        td span .due-date {
            color: var(--dark-05);
            font-size: 14px;
        }
        td span .priority, 
        td span .btn-done,
        td span .btn-undone,
        td span .btn-complete{
            font-size: 12px;
            padding: 1px 5px;
            border-radius: 5px;
            display: inline-block;
            font-weight: 600;
            text-align: center;
        }
        td span .btn-complete{
            padding: 3px 5px;
        }
        td span .high, 
        td span .btn-undone { 
            background: red; 
            color: var(--cream); 
        }
        td span .medium { 
            background: orange;
            color: var(--cream);
         }
        td span .low { 
            background: var(--cream);
            color: #0c8377;
        }
        td span .btn-done, 
        td span .btn-complete{
            background: var(--mid-green);
            color: var(--cream);
        }
        td span .btn-complete:hover{
            color: var(--cream);
            background-color: #0c8377;
        }
        tr td span button {
            background: none;
            border: none;
            color: var(--dark-05);
            cursor: pointer;
            font-size: 16px;
            transition: color 0.3s;
            transition: background 0.3s, color 0.3s;
        }
        tr td span button:hover {
            color: var(--dark-08);
        }
        tr td span button i{
            color: var(--cream);
        }
        .active {
            text-decoration: active;
            color: var(--dark-05);
            text-decoration: line-through;
        }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <h1>To-Do List <span>📋</span></h1>
                <form action="{{ route('task.store') }}" method="POST" class="input-group">
                    @csrf

                    <input type="text" name="task" placeholder="Judul Task" />

                    <select name="priority" id="priority">
                        
                        <option value="" disabled selected>
                            Choose Priority
                        </option>
                        <option value="1">High</option>
                        <option value="2">Medium</option>
                        <option value="3">Low</option>

                    </select>

                    <input type="date" name="due_date" id="due_date" />

                    <input type="hidden" name="status" value="0">

                    <button>Add</button>
                </form>
            </div>
            <div class="content">
                <h1>My To-Do Lists <span>📋</span></h1>
                <table>
                    @forelse ($tasks as $task)
                    <tr>
                        <td class="number">
                            <span>{{ $loop->iteration }}</span>
                        </td>
                        <td class="status">
                            <span>
                                @if ($task->status == 1)
                                    <p type="submit" class="btn-done">Selesai</p>
                                @else
                                    <p type="submit" class="btn-undone">Belum Selesai</p>
                                @endif
                                @php
                                    $priorityvalue = [
                                        1 => 'high',
                                        2 => 'medium',
                                        3 => 'low'
                                    ][$task->priority] ?? 'default';
                                @endphp

                                <p class="priority {{ $priorityvalue }}">
                                    @if($task->priority == 1) High
                                    @elseif($task->priority == 2) Medium
                                    @else Low
                                    @endif
                                </p>

                                <p class="due-date">Due {{ $task->due_date }}</p>
                            </span>
                        </td>
                        <td class="task">
                            <span>
                                <p class="{{ $task->status == 1 ? 'active' : '' }}">{{ $task->task }}</p>
                            </span>
                        </td>
                        <td class="action">
                            <span>
                                <form action="{{ route('task.update', $task->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    @if ($task->status == 1)
                                    @else
                                        <button type="submit" class="btn-complete" title="Selesaikan"><i class="fa-solid fa-check"></i>  Selesai</button>
                                    @endif
                                </form>
                                <form action="{{ route('task.delete', $task->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus">&times;</button>
                                </form>
                            </span>
                        </td>
                    </tr>
                    @empty
                        <p>Anda belum menambahkan Task!</p>
                    @endforelse
                </table>
            </div>
        </div>
        @if(session('success'))
            <script>
                alert("{{ session('success') }}");
            </script>
        @endif
    </body>
</html>
