<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Employee</h2>
    </x-slot>
<style>
    /* Custom Modern Radio Buttons */
    .btn-check:checked + .btn-outline-success { background-color: #198754; color: white; }
    .btn-check:checked + .btn-outline-warning { background-color: #ffc107; color: black; }
    .btn-check:checked + .btn-outline-danger { background-color: #dc3545; color: white; }
    
    /* Mobile Sticky Footer for Save Button */
    .mobile-sticky-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: white;
        padding: 15px;
        box-shadow: 0 -4px 10px rgba(0,0,0,0.05);
        z-index: 1000;
        border-top: 1px solid #dee2e6;
    }
    /* Hide footer on desktop */
    @media (min-width: 768px) {
        .mobile-sticky-footer { display: none; }
        .content-wrapper { padding-bottom: 0 !important; }
    }
    /* Add padding to body on mobile so content isn't hidden behind footer */
    @media (max-width: 767px) {
        .content-wrapper { padding-bottom: 80px; }
    }
</style>

<div class="container-fluid py-4 content-wrapper">
    <form action="{{ route('attendance.store') }}" method="POST">
        @csrf
        
        <div class="row align-items-center mb-4">
            <div class="col-md-6 mb-2 mb-md-0">
                <h4 class="fw-bold text-primary m-0"><i class="fas fa-user-clock me-2"></i>Daily Attendance</h4>
                <p class="text-muted small m-0">Mark attendance for your team today.</p>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-md-end gap-2 align-items-center">
                    <label class="text-muted fw-bold d-none d-md-block">Date:</label>
                    <input type="date" name="date" class="form-control form-control-lg shadow-sm" style="max-width: 200px;" value="{{ $date }}" onchange="window.location.href='{{ route('attendance.index') }}?date='+this.value">
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
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $emp)
                                @php
                                    $att = $emp->attendances->first();
                                    $status = $att ? $att->status : 'present';
                                    $check_in = $att ? $att->check_in : '09:00';
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                                {{ strtoupper(substr($emp->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark">{{ $emp->name }}</h6>
                                                <small class="text-muted">{{ $emp->userProfile->employee_id ?? 'ID-'.$emp->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <input type="radio" class="btn-check" name="attendance[{{ $emp->id }}][status]" value="present" id="d_p_{{ $emp->id }}" {{ $status == 'present' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success btn-sm px-3" for="d_p_{{ $emp->id }}">Present</label>

                                            <input type="radio" class="btn-check" name="attendance[{{ $emp->id }}][status]" value="late" id="d_l_{{ $emp->id }}" {{ $status == 'late' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning btn-sm px-3" for="d_l_{{ $emp->id }}">Late</label>

                                            <input type="radio" class="btn-check" name="attendance[{{ $emp->id }}][status]" value="absent" id="d_a_{{ $emp->id }}" {{ $status == 'absent' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger btn-sm px-3" for="d_a_{{ $emp->id }}">Absent</label>
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <input type="time" class="form-control form-control-sm border-0 bg-light" name="attendance[{{ $emp->id }}][check_in]" value="{{ $check_in }}">
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('attendance.report', $emp->id) }}" class="btn btn-link text-muted btn-sm" title="View History">
                                            <i class="fas fa-history"></i>
                                        </a>
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
            @foreach($employees as $emp)
                @php
                    $att = $emp->attendances->first();
                    $status = $att ? $att->status : 'present';
                    $check_in = $att ? $att->check_in : '09:00';
                @endphp
                <div class="card mb-3 shadow-sm border-0 rounded-3">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                    {{ strtoupper(substr($emp->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold fs-5">{{ $emp->name }}</h6>
                                    <small class="text-muted">{{ $emp->userProfile->employee_id ?? 'ID-'.$emp->id }}</small>
                                </div>
                            </div>
                            <a href="{{ route('attendance.report', $emp->id) }}" class="text-muted"><i class="fas fa-chevron-right"></i></a>
                        </div>
                        
                        <div class="bg-light p-3 rounded-3">
                            <label class="small text-uppercase text-muted fw-bold mb-2 d-block">Mark Status</label>
                            <div class="btn-group w-100 mb-3" role="group">
                                <input type="radio" class="btn-check" name="attendance[{{ $emp->id }}][status]" value="present" id="m_p_{{ $emp->id }}" {{ $status == 'present' ? 'checked' : '' }}>
                                <label class="btn btn-outline-success py-2" for="m_p_{{ $emp->id }}">Present</label>

                                <input type="radio" class="btn-check" name="attendance[{{ $emp->id }}][status]" value="late" id="m_l_{{ $emp->id }}" {{ $status == 'late' ? 'checked' : '' }}>
                                <label class="btn btn-outline-warning py-2" for="m_l_{{ $emp->id }}">Late</label>

                                <input type="radio" class="btn-check" name="attendance[{{ $emp->id }}][status]" value="absent" id="m_a_{{ $emp->id }}" {{ $status == 'absent' ? 'checked' : '' }}>
                                <label class="btn btn-outline-danger py-2" for="m_a_{{ $emp->id }}">Absent</label>
                            </div>
                            
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-clock text-muted"></i>
                                <input type="time" class="form-control border-0 bg-white shadow-none ps-0" name="attendance[{{ $emp->id }}][check_in]" value="{{ $check_in }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mobile-sticky-footer d-md-none">
            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill shadow">
                <i class="fas fa-save me-2"></i> Save All Attendance
            </button>
        </div>

    </form>
</div>
</x-app-layout>