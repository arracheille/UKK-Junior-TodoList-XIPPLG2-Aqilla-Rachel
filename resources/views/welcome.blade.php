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

        <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
    </head>
    <body>
        <div class="container">
            <div class="content">
                <h1>To-Do Form <span>📋</span></h1>
                <form action="{{ route('task.store') }}" method="POST" class="input-group">
                    @csrf

                    <div class="input-container">

                        <label for="task">Nama Task</label>
                        <input type="text" name="task" id="task" placeholder="Masukkan Task Baru" autocomplete="off" required />

                    </div>

                    <div class="input-container">

                        <label for="description">Deskripsi Task (Opsional)</label>
                        <textarea name="description" id="description" ></textarea>

                    </div>

                    <div class="input-container">
                        
                        <label for="priority">Prioritas</label>
                        <select name="priority" id="priority" required>
                            
                            <option value="" disabled selected>
                                -- Pilih Prioritas --
                            </option>
                            <option value="1">Low</option>
                            <option value="2">Medium</option>
                            <option value="3">High</option>

                        </select>
                    </div>

                    <div class="input-container">

                        <label for="due_date">Tanggal</label>
                        <input type="date" name="due_date" id="due_date" required />

                    </div>

                    <input type="hidden" name="status" value="0">

                    <button class="btn">Add</button>
                </form>
            </div>
            <div class="content">
                <div class="content-heading">
                    <h1>My To-Do Lists <span>📋</span></h1>
                    <div class="filter-search">
                        <button class="btn-filter" onclick="ShowFilter()">Filter List <i class="fa-solid fa-caret-down"></i></button>
                        <form action="{{ route('task.index') }}" method="GET" class="filter-form">
                            <div class="filter-container" id="filter-container">
                                <div class="filter-content">
                                    <div class="content-heading">
                                        <p>Filter Berdasarkan..</p>
                                        <p onclick="CloseFilter()" style="cursor: pointer;">&times;</p>
                                    </div>
                                    <div class="filter-inputs">
                                        <select name="filter_status" id="filter_status">
                                            <option value="" disabled selected>-- Berdasarkan Status --</option>
                                            <option value="all" {{ request('filter_status') == 'all' ? 'selected' : '' }}>Semua</option>
                                            <option value="done" {{ request('filter_status') == 'done' ? 'selected' : '' }}>Sudah Selesai</option>
                                            <option value="undone" {{ request('filter_status') == 'undone' ? 'selected' : '' }}>Belum Selesai</option>
                                        </select>
                                    
                                        <select name="filter_priority" id="filter_priority">
                                            <option value="" disabled selected>-- Berdasarkan Prioritas --</option>
                                            <option value="all" {{ request('filter_priority') == 'all' ? 'selected' : '' }}>Semua</option>
                                            <option value="1" {{ request('filter_priority') == '1' ? 'selected' : '' }}>Low</option>
                                            <option value="2" {{ request('filter_priority') == '2' ? 'selected' : '' }}>Medium</option>
                                            <option value="3" {{ request('filter_priority') == '3' ? 'selected' : '' }}>High</option>
                                        </select>
                                    
                                        <button type="submit" class="btn">Filter</button>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="search-input">
                                <input type="text" name="search" id="search" placeholder="Cari Data.." value="{{ request('search') }}" autocomplete="off">
                                <button class="btn search"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <table>
                    @forelse ($tasks as $task)
                    <tr>
                        <td class="number">
                            <span>
                                {{ $loop->iteration }}
                            </span>
                        </td>
                        <td class="check">
                            <span>
                                <form action="{{ route('task.edit', $task->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    @if ($task->status == 1)
                                        <input type="hidden" name="status" value="0">
                                        <button type="submit" class="btn-checkbox" style="background-color: var(--mid-green);" ><i class="fa-solid fa-check"></i></button>
                                        @else
                                        <input type="hidden" name="status" value="1">
                                        <button type="submit" class="btn-checkbox" style="border: solid 2px var(--mid-green);" ></button>
                                    @endif
                                </form>
                            </span>
                        </td>
                        <td class="task">
                            <span>
                                <p class="{{ $task->status == 1 ? 'active' : '' }} title">{{ $task->task }}</p>
                                <p class="text-small">{{ $task->description }}</p>
                            </span>
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
                                        1 => 'low',
                                        2 => 'medium',
                                        3 => 'high'
                                    ][$task->priority] ?? 'default';
                                @endphp

                                <p class="priority {{ $priorityvalue }}">
                                    @if($task->priority == 1) Low
                                    @elseif($task->priority == 2) Medium
                                    @else High
                                    @endif
                                </p>

                                <p class="text-small">Due {{ $task->due_date }}</p>
                            </span>
                        </td>
                        <td class="action">
                            <span>
                                <button class="btn-icon edit" onclick="openEditModal({{ $task->id }})"><i class="fa-solid fa-pen"></i></button>
                                <form action="{{ route('task.delete', $task->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon delete"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </span>
                        </td>
                    </tr>
                    <div id="editTaskModal-{{ $task->id }}" class="modal">
                        <div class="modal-content">
                            <div class="modal-title-close">
                                <h2>Edit Task <span>{{ $task->task }}</span></h2>
                                <span class="close" onclick="closeEditModal('{{ $task->id }}')">&times;</span>
                            </div>
                    
                            <form action="{{ route('task.edit', ['task' => $task->id]) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="input-container">

                                    <label for="task">Nama Task</label>
                                    <input type="text" name="task" id="task" value="{{ $task->task }}" autocomplete="off" required />
            
                                </div>
            
                                <div class="input-container">
            
                                    <label for="description">Deskripsi Task (Opsional)</label>
                                    <textarea name="description" id="description" >{{ $task->description }}</textarea>
            
                                </div>
            
                                <div class="input-container">
                                    
                                    <label for="priority">Prioritas</label>
                                    <select name="priority" id="priority">
                                        
                                        <option value="1" {{ $task->priority == 1 ? 'selected' : '' }}>Low</option>
                                        <option value="2" {{ $task->priority == 2 ? 'selected' : '' }}>Medium</option>
                                        <option value="3" {{ $task->priority == 3 ? 'selected' : '' }}>High</option>

                                    </select>
                                </div>
                                
                                <div class="input-container">
            
                                    <label for="due_date">Tanggal</label>
                                    <input type="date" name="due_date" class="due-date" value="{{ old('due_date', \Carbon\Carbon::parse($task->due_date)->format('Y-m-d')) }}" />
            
                                </div>

                                <input type="hidden" id="editTaskId-{{ $task->id }}" name="id_category">

                                <div class="modal-footer">
                                    <button type="button" class="btn" onclick="closeEditModal('{{ $task->id }}')">
                                        Cancel
                                    </button>
                                    
                                    <button type="submit" class="btn" id="modal-submit-btn">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @empty
                        <p>Tidak ada task!</p>
                    @endforelse
                </table>
            </div>
        </div>
        
        @if(session('success'))
            <script>
                alert("{{ session('success') }}");
            </script>
        @endif
        
        <script>
            document.getElementById('due_date').min = new Date().toISOString().split("T")[0];

            document.querySelectorAll('.due-date').forEach(function(input) {
                input.min = new Date().toISOString().split("T")[0];
            });
            
            function openEditModal(id) {
                document.getElementById('editTaskModal-' + id).style.display = 'block';
                document.getElementById('editTaskId-' + id).value = id;
            }

            function closeEditModal(id) {
                document.getElementById('editTaskModal-' + id).style.display = 'none';
            }

            function ShowFilter() {
                const filterContainer = document.getElementById('filter-container');
                filterContainer.style.display = 'block';
            }

            function CloseFilter() {
                const filterContainer = document.getElementById('filter-container');
                filterContainer.style.display = 'none';
            }

            window.onclick = function(event) {
                const filterContainer = document.getElementById('filter-container');
                if (!event.target.matches('.btn-filter') && !filterContainer.contains(event.target)) {
                    filterContainer.style.display = 'none';
                }
            }
        </script>
    </body>
</html>
