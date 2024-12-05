@extends('layouts.app')
@section('content')

    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Dashboard
        </h3>

    </div>
    <div class="row">
        @role('Admin')
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Projects <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-5">{{ $projectCount }}</h2>

                    </div>
                </div>
            </div>
        @else
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Tasks <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-5">{{ $totalTask }}</h2>

                    </div>
                </div>
            </div>
        @endrole
        @role('Admin')
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Users <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-5">{{ $userCount }}</h2>

                    </div>
                </div>
            </div>
        @else
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Pending Tasks <i
                                class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-5">{{ $pendingTask }}</h2>

                    </div>
                </div>
            </div>
        @endrole

        {{-- <div class="col-md-4 stretch-card grid-margin">
                    <div class="card bg-gradient-success card-img-holder text-white">
                        <div class="card-body">
                            <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                            <h4 class="font-weight-normal mb-3">Visitors Online <i class="mdi mdi-diamond mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5">95,5741</h2>
                            <h6 class="card-text">Increased by 5%</h6>
                        </div>
                    </div>
                </div> --}}
    </div>

    @role('Admin')
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Recent Tickets</h4>
                        <div class="table-responsive">

                            <select name="project" id="projects" class="form-control">
                                <option value="">Select Project</option>
                                @foreach ($allProjects as $project)
                                    <option value="{{ $project->id }}">{{ $project->title }}</option>
                                @endforeach
                            </select>
                            <br>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Assigned to</th>
                                        <th>Todo</th>
                                        <th>Completed</th>
                                        <th>Deployed</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="teamTasksBody">
                                    <tr>
                                        <td colspan="6" class="text-center">No data available. Please select a
                                            project.</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole

    {{-- <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Recent Tickets</h4>
                            <div class="table-responsive">

                                <select name="project" id="projects" class="form-control">
                                    <option value="">Select Project</option>
                                </select>
                                <br>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            @role('Admin')
                                                <th> Assigned to </th>
                                            @endrole
                                            <th> Project </th>
                                            <th> Task </th>
                                            <th> Status </th>
                                            <th> Due Date </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentTasks as $tasks)
                                            <tr>
                                                @role('Admin')
                                                    <td>
                                                        {{ $tasks->user->name }}
                                                    </td>
                                                @endrole
                                                <td>
                                                    {{ $tasks->projects->title }}
                                                </td>
                                                <td> {{ $tasks->title }} </td>
                                                <td>
                                                    @if ($tasks->status == 'to-do')
                                                        <label class="badge badge-gradient-primary">TO DO</label>
                                                    @elseif ($tasks->status == 'Done')
                                                        <label class="badge badge-gradient-warning">DONE</label>
                                                    @elseif ($tasks->status == 'deployed')
                                                        <label class="badge badge-gradient-info">DEPLOYED</label>
                                                    @elseif ($tasks->status == 'in-progress')
                                                        <label class="badge badge-gradient-danger">IN PROGRESS</label>
                                                    @elseif ($tasks->status == 'completed')
                                                        <label class="badge badge-gradient-success">COMPLETED</label>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($tasks->deadline >= date('Y-m-d'))
                                                        <label class="badge badge-gradient-success"> {{ $tasks->deadline }} </label>
                                                    @else
                                                        <label class="badge badge-gradient-danger"> {{ $tasks->deadline }} </label>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
    {{-- <div class="row">
                <div class="col-md-7 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="clearfix">
                                <h4 class="card-title float-left">Visit And Sales Statistics</h4>
                                <div id="visit-sale-chart-legend" class="rounded-legend legend-horizontal legend-top-right float-right">
                                </div>
                            </div>
                            <canvas id="visit-sale-chart" class="mt-4"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Traffic Sources</h4>
                            <canvas id="traffic-chart"></canvas>
                            <div id="traffic-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}


    {{-- <div class="row">
                <div class="col-md-7 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Project Status</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> Name </th>
                                            <th> Due Date </th>
                                            <th> Progress </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> 1 </td>
                                            <td> Herman Beck </td>
                                            <td> May 15, 2015 </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> 2 </td>
                                            <td> Messsy Adam </td>
                                            <td> Jul 01, 2015 </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> 3 </td>
                                            <td> John Richards </td>
                                            <td> Apr 12, 2015 </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> 4 </td>
                                            <td> Peter Meggik </td>
                                            <td> May 15, 2015 </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> 5 </td>
                                            <td> Edward </td>
                                            <td> May 03, 2015 </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> 5 </td>
                                            <td> Ronald </td>
                                            <td> Jun 05, 2015 </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-white">Todo</h4>
                            <div class="add-items d-flex">
                                <input type="text" class="form-control todo-list-input" placeholder="What do you need to do today?">
                                <button class="add btn btn-gradient-primary font-weight-bold todo-list-add-btn" id="add-task">Add</button>
                            </div>
                            <div class="list-wrapper">
                                <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
                                    <li>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox"> Meeting with Alisa
                                            </label>
                                        </div>
                                        <i class="remove mdi mdi-close-circle-outline"></i>
                                    </li>
                                    <li class="completed">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox" checked> Call John
                                            </label>
                                        </div>
                                        <i class="remove mdi mdi-close-circle-outline"></i>
                                    </li>
                                    <li>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox"> Create invoice
                                            </label>
                                        </div>
                                        <i class="remove mdi mdi-close-circle-outline"></i>
                                    </li>
                                    <li>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox"> Print Statements
                                            </label>
                                        </div>
                                        <i class="remove mdi mdi-close-circle-outline"></i>
                                    </li>
                                    <li class="completed">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox" checked> Prepare for
                                                presentation </label>
                                        </div>
                                        <i class="remove mdi mdi-close-circle-outline"></i>
                                    </li>
                                    <li>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="checkbox" type="checkbox"> Pick up kids from
                                                school </label>
                                        </div>
                                        <i class="remove mdi mdi-close-circle-outline"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}


    <script>
        document.getElementById('projects').addEventListener('change', function() {
            const projectId = this.value;

            const teamTasksBody = document.getElementById('teamTasksBody');

            teamTasksBody.innerHTML = '<tr><td colspan="6" class="text-center">Loading...</td></tr>';

            if (projectId) {
                fetch(`/projects/${projectId}/team-tasks`)
                    .then(response => response.json())
                    .then(data => {
                        updateTable(data);
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        teamTasksBody.innerHTML =
                            '<tr><td colspan="6" class="text-center text-danger">Error loading data.</td></tr>';
                    });
            } else {
                teamTasksBody.innerHTML =
                    '<tr><td colspan="6" class="text-center">No data available. Please select a project.</td></tr>';
            }
        });

        function updateTable(data) {
            const teamTasksBody = document.getElementById('teamTasksBody');

            if (!data || data.team.length === 0) {
                teamTasksBody.innerHTML =
                    '<tr><td colspan="6" class="text-center">No team members found for this project.</td></tr>';
                return;
            }

            // Populate table rows
            teamTasksBody.innerHTML = '';
            data.team.forEach(member => {
                if (member.tasks.length > 0) {
                    member.tasks.forEach(task => {
                        const currentDate = new Date();
                        const taskDeadline = new Date(task.deadline);
                        const isOverdue = task.deadline && taskDeadline < currentDate;

                        const deadlineStyle = isOverdue ? 'color: red;' : '';

                        const statusBadge = task.status === 'completed' ?
                            '<span class="text-success">Completed</span>' :
                            task.status === 'deployed' ?
                            '<span class="text-info">Deployed</span>' :
                            task.status === 'to-do' ?
                            '<span class="text-danger">To Do</span>' :
                            '-';

                        const row = `
                    <tr>
                        <td>${member.name}</td>
                        <td>${member.taskCounts.todo}</td>
                        <td>${member.taskCounts.completed}</td>
                        <td>${member.taskCounts.deployed}</td>
                        <td style="${deadlineStyle}">${task.deadline || '-'}</td>
                        <td>${statusBadge}</td>
                    </tr>
                `;
                        teamTasksBody.innerHTML += row;
                    });
                } else {
                    const row = `
                <tr>
                    <td>${member.name}</td>
                    <td>${member.taskCounts.todo}</td>
                    <td>${member.taskCounts.completed}</td>
                    <td>${member.taskCounts.deployed}</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
            `;
                    teamTasksBody.innerHTML += row;
                }
            });
        }
    </script>

@endsection
