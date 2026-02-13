<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Employee Attendance</h2>
    </x-slot>

    <style>
        /* Custom Modern Radio Buttons */
        .btn-check:checked+.btn-outline-success {
            background-color: #198754;
            color: white;
        }

        .btn-check:checked+.btn-outline-warning {
            background-color: #ffc107;
            color: black;
        }

        .btn-check:checked+.btn-outline-danger {
            background-color: #dc3545;
            color: white;
        }

        /* Mobile Sticky Footer */
        .mobile-sticky-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: white;
            padding: 12px;
            box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            border-top: 1px solid #dee2e6;
        }

        /* Layout Adjustments */
        @media (min-width: 768px) {
            .mobile-sticky-footer {
                display: none;
            }

            .content-wrapper {
                padding-bottom: 0 !important;
            }
        }

        @media (max-width: 767px) {
            .content-wrapper {
                padding-bottom: 70px;
            }

            /* Space for footer */
        }
    </style>

    <div class="container-fluid py-4 content-wrapper">
        <form action="{{ route('attendance.store') }}" method="POST">
            @csrf

            <div class="row align-items-center mb-4">
                <div class="col-md-6 mb-2 mb-md-0">
                    <h4 class="fw-bold text-primary m-0"><i class="fas fa-calendar-check me-2"></i>Daily Attendance</h4>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between justify-content-md-end gap-2 align-items-center">
                        <span class="text-muted fw-bold d-md-none">{{ count($employees) }} Employees</span>
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted fw-bold d-none d-md-block">Date:</label>
                            <input type="date" name="date" class="form-control shadow-sm"
                                style="max-width: 160px;" value="{{ $date }}"
                                onchange="window.location.href='{{ route('attendance.index') }}?date='+this.value">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 d-none d-md-block">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-uppercase text-secondary small">
                                <tr>
                                    <th class="ps-4 py-3">Employee</th>
                                    <th class="text-center">Status</th>
                                    <th>Check In</th>
                                    <th class="text-end pe-4">History</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $emp)
                                    @php
                                        $att = $emp->attendances->first();
                                        $status = $att ? $att->status : 'present';
                                        $check_in = $att ? $att->check_in : '09:00';
                                    @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex align-items-center justify-content-center me-3"
                                                    style="width: 40px; height: 40px;">
                                                    {{ strtoupper(substr($emp->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold text-dark">{{ $emp->name }}</h6>
                                                    <small
                                                        class="text-muted">{{ $emp->userProfile->employee_id ?? 'ID-' . $emp->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <input type="radio" class="btn-check"
                                                    name="attendance[{{ $emp->id }}][status]" value="present"
                                                    id="d_p_{{ $emp->id }}"
                                                    {{ $status == 'present' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-success btn-sm px-3"
                                                    for="d_p_{{ $emp->id }}">Present</label>

                                                <input type="radio" class="btn-check"
                                                    name="attendance[{{ $emp->id }}][status]" value="late"
                                                    id="d_l_{{ $emp->id }}"
                                                    {{ $status == 'late' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-warning btn-sm px-3"
                                                    for="d_l_{{ $emp->id }}">Late</label>

                                                <input type="radio" class="btn-check"
                                                    name="attendance[{{ $emp->id }}][status]" value="absent"
                                                    id="d_a_{{ $emp->id }}"
                                                    {{ $status == 'absent' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-danger btn-sm px-3"
                                                    for="d_a_{{ $emp->id }}">Absent</label>
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <input type="time" class="form-control form-control-sm border-0 bg-light"
                                                name="attendance[{{ $emp->id }}][check_in]"
                                                value="{{ $check_in }}">
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('attendance.report', $emp->id) }}"
                                                class="btn btn-link text-muted btn-sm">
                                                <i class="fas fa-history"></i>
                                            </a>
                                            <button type="button"
                                                class="btn btn-link text-muted btn-sm open-note-modal"
                                                data-emp="{{ $emp->id }}" data-name="{{ $emp->name }}">
                                                <i class="fas fa-sticky-note text-primary"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white p-3 text-end">
                    <button type="submit" class="btn btn-primary px-5 fw-bold rounded-pill">
                        <i class="fas fa-save me-2"></i> Save Changes
                    </button>
                </div>
            </div>

            <div class="d-md-none">
                @foreach ($employees as $emp)
                    @php
                        $att = $emp->attendances->first();
                        $status = $att ? $att->status : 'present';
                        $check_in = $att ? $att->check_in : '09:00';
                    @endphp

                    <div class="card mb-2 shadow-sm border-0 rounded-3">
                        <div class="card-body p-2">

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="avatar rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex align-items-center justify-content-center me-2"
                                        style="width: 35px; height: 35px; font-size: 0.9rem;">
                                        {{ strtoupper(substr($emp->name, 0, 1)) }}
                                    </div>
                                    <div style="line-height: 1.2;">
                                        <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.95rem;">
                                            {{ $emp->name }}</h6>
                                        <small class="text-muted"
                                            style="font-size: 0.7rem;">{{ $emp->userProfile->employee_id ?? $emp->id }}</small>
                                    </div>
                                </div>
                                <a href="{{ route('attendance.report', $emp->id) }}" class="text-secondary p-2">
                                    <i class="fas fa-history"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-light border open-note-modal"
                                    data-emp="{{ $emp->id }}" data-name="{{ $emp->name }}"
                                    style="font-size:0.8rem;">
                                    <i class="fas fa-sticky-note text-primary"></i>
                                </button>

                            </div>

                            <div class="d-flex align-items-center justify-content-between bg-light rounded-2 p-1">

                                <div class="btn-group btn-group-sm" role="group">
                                    <input type="radio" class="btn-check"
                                        name="attendance[{{ $emp->id }}][status]" value="present"
                                        id="m_p_{{ $emp->id }}" {{ $status == 'present' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-success fw-bold"
                                        style="font-size: 0.75rem; padding: 0.25rem 0.6rem;"
                                        for="m_p_{{ $emp->id }}">P</label>

                                    <input type="radio" class="btn-check"
                                        name="attendance[{{ $emp->id }}][status]" value="late"
                                        id="m_l_{{ $emp->id }}" {{ $status == 'late' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-warning fw-bold text-dark"
                                        style="font-size: 0.75rem; padding: 0.25rem 0.6rem;"
                                        for="m_l_{{ $emp->id }}">L</label>

                                    <input type="radio" class="btn-check"
                                        name="attendance[{{ $emp->id }}][status]" value="absent"
                                        id="m_a_{{ $emp->id }}" {{ $status == 'absent' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-danger fw-bold"
                                        style="font-size: 0.75rem; padding: 0.25rem 0.6rem;"
                                        for="m_a_{{ $emp->id }}">A</label>
                                </div>

                                <div class="d-flex align-items-center bg-white border rounded px-1">
                                    <i class="fas fa-clock text-muted me-1" style="font-size: 0.7rem;"></i>
                                    <input type="time"
                                        class="form-control form-control-sm border-0 shadow-none p-0"
                                        style="width: 75px; font-size: 0.85rem;"
                                        name="attendance[{{ $emp->id }}][check_in]"
                                        value="{{ $check_in }}">
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mobile-sticky-footer d-md-none">
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill shadow">
                    <i class="fas fa-save me-2"></i> Save All
                </button>
            </div>

        </form>
    </div>
    <!-- Notes Modal -->
    <div class="modal fade" id="noteModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-sticky-note me-2"></i>
                        Employee Notes - <span id="modalEmployeeName"></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="modalEmpId">

                    <!-- Notes History -->
                    <div id="notesHistory" style="max-height:300px; overflow-y:auto;">
                        <div class="text-center text-muted py-3">
                            Loading notes...
                        </div>
                    </div>

                    <hr>

                    <!-- Add New Note -->
                    <textarea id="newNoteText" class="form-control" rows="3" placeholder="Write new note..."></textarea>

                    <button type="button" class="btn btn-primary mt-2" id="saveModalNote">
                        <i class="fas fa-save me-1"></i> Save Note
                    </button>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let noteModal = new bootstrap.Modal(document.getElementById('noteModal'));

            // OPEN MODAL
            document.querySelectorAll('.open-note-modal').forEach(btn => {
                btn.addEventListener('click', function() {

                    let userId = this.dataset.emp;
                    let userName = this.dataset.name;

                    document.getElementById('modalEmpId').value = userId;
                    document.getElementById('modalEmployeeName').innerText = userName;

                    loadNotes(userId);

                    noteModal.show();
                });
            });

            // LOAD NOTES
            function loadNotes(userId) {
                fetch(`/attendance/notes/${userId}`)
                    .then(res => res.json())
                    .then(data => {

                        let html = '';

                        if (data.length === 0) {
                            html = `<div class="text-muted text-center">No notes found</div>`;
                        } else {
                            data.forEach(note => {
                                html += `
                        <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">
                            <div>
                                <small class="text-muted">${note.note}</small>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-danger delete-note" 
                                    data-id="${note.id}">
                                    <i class="fas fa-trash"></i>
                                </button>

                            </div>
                        </div>
                    `;
                            });
                        }

                        document.getElementById('notesHistory').innerHTML = html;

                        // Attach view event
                        // document.querySelectorAll('.view-note').forEach(btn => {
                        //     btn.addEventListener('click', function() {
                        //         alert(this.dataset.note);
                        //     });
                        // });

                        // Attach delete event
                        document.querySelectorAll('.delete-note').forEach(btn => {
                            btn.addEventListener('click', function() {

                                let noteId = this.dataset.id;

                                if (!confirm('Delete this note?')) return;

                                fetch(`/attendance/notes/delete/${noteId}`, {
                                        method: "POST",
                                        headers: {
                                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                        }
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            loadNotes(document.getElementById('modalEmpId')
                                                .value);
                                        }
                                    });

                            });
                        });


                    });
            }

            // SAVE NOTE
            document.getElementById('saveModalNote').addEventListener('click', function() {

                let userId = document.getElementById('modalEmpId').value;
                let noteText = document.getElementById('newNoteText').value;

                if (noteText.trim() === '') {
                    alert('Enter note');
                    return;
                }

                fetch(`/attendance/notes/store`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            user_id: userId,
                            note: noteText
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('newNoteText').value = '';
                        loadNotes(userId);
                    });

            });

        });
    </script>


</x-app-layout>
