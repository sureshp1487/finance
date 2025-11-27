<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Employee</h2>
    </x-slot>
<style>
    /* --- CSS Grid Calendar Styles --- */
    .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; }
    .calendar-day {
        aspect-ratio: 1/1; 
        border: 1px solid #f0f0f0; border-radius: 6px;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        background: #fff; font-size: 0.85rem; position: relative;
    }
    .cal-header { font-size: 0.75rem; font-weight: bold; text-align: center; color: #6c757d; padding-bottom: 5px; }
    
    /* Status Colors (Shared) */
    .bg-present { background-color: #d1e7dd; color: #0f5132; border-color: #badbcc; }
    .bg-absent  { background-color: #f8d7da; color: #842029; border-color: #f5c2c7; }
    .bg-late    { background-color: #fff3cd; color: #664d03; border-color: #ffecb5; }
    .bg-empty   { background-color: #f8f9fa; }
</style>

<div class="container-fluid py-3">
    
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body p-2">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('attendance.index') }}" class="btn btn-light btn-sm rounded-circle shadow-sm">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h6 class="fw-bold m-0 text-dark">{{ $user->name }}</h6>
                        <small class="text-muted">{{ $user->employee_id ?? 'ID: '.$user->id }}</small>
                    </div>
                </div>

                <form action="{{ route('attendance.report', $user->id) }}" method="GET" class="d-flex gap-1 flex-wrap">
                    
                    <select name="view_type" class="form-select form-select-sm bg-light fw-bold border-0 text-primary" style="width: auto;" onchange="this.form.submit()">
                        <option value="calendar" {{ $viewType == 'calendar' ? 'selected' : '' }}>📅 Calendar View</option>
                        <option value="table" {{ $viewType == 'table' ? 'selected' : '' }}>📄 List View</option>
                    </select>

                    <select name="month" class="form-select form-select-sm border-secondary border-opacity-25" style="width: auto;" onchange="this.form.submit()">
                        @for($m=1; $m<=12; $m++)
                            <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                {{ date('M', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endfor
                    </select>

                    <select name="year" class="form-select form-select-sm border-secondary border-opacity-25" style="width: auto;" onchange="this.form.submit()">
                        @for($y=date('Y'); $y>=2023; $y--)
                            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </form>

            </div>
        </div>
    </div>

    <div class="row g-2 mb-3">
        <div class="col-4">
            <div class="p-2 rounded border border-success bg-success bg-opacity-10 text-center">
                <small class="text-success fw-bold text-uppercase" style="font-size:0.7rem;">Present</small>
                <div class="h5 fw-bold text-success m-0">{{ $present }}</div>
            </div>
        </div>
        <div class="col-4">
            <div class="p-2 rounded border border-danger bg-danger bg-opacity-10 text-center">
                <small class="text-danger fw-bold text-uppercase" style="font-size:0.7rem;">Absent</small>
                <div class="h5 fw-bold text-danger m-0">{{ $absent }}</div>
            </div>
        </div>
        <div class="col-4">
            <div class="p-2 rounded border border-warning bg-warning bg-opacity-10 text-center">
                <small class="text-warning fw-bold text-uppercase text-dark" style="font-size:0.7rem;">Late</small>
                <div class="h5 fw-bold text-dark m-0">{{ $late }}</div>
            </div>
        </div>
    </div>

    @if($viewType == 'calendar')
        
        <div class="card shadow-sm border-0">
            <div class="card-body p-2">
                <div class="calendar-grid mb-2">
                    <div class="cal-header text-danger">Sun</div>
                    <div class="cal-header">Mon</div>
                    <div class="cal-header">Tue</div>
                    <div class="cal-header">Wed</div>
                    <div class="cal-header">Thu</div>
                    <div class="cal-header">Fri</div>
                    <div class="cal-header">Sat</div>
                </div>

                <div class="calendar-grid">
                    @for ($i = 0; $i < $dateObj->copy()->startOfMonth()->dayOfWeek; $i++)
                        <div class="calendar-day bg-empty"></div>
                    @endfor

                    @for ($day = 1; $day <= $dateObj->daysInMonth; $day++)
                        @php
                            $currentDate = $dateObj->copy()->day($day)->format('Y-m-d');
                            $record = $attendances[$currentDate] ?? null;
                            $statusClass = '';
                            if($record) {
                                if($record->status == 'present') $statusClass = 'bg-present';
                                elseif($record->status == 'absent') $statusClass = 'bg-absent';
                                elseif($record->status == 'late') $statusClass = 'bg-late';
                            }
                        @endphp

                        <div class="calendar-day {{ $statusClass }}">
                            <span class="fw-bold small">{{ $day }}</span>
                            @if($record)
                                <small style="font-size: 0.65rem;" class="mt-1">
                                    {{ $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format('H:i') : ucfirst(substr($record->status,0,1)) }}
                                </small>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
        </div>

    @else

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary small">
                        <tr>
                            <th class="ps-3 py-2">Date</th>
                            <th>Status</th>
                            <th>Check In</th>
                            <th class="text-end pe-3">Day</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($day = 1; $day <= $dateObj->daysInMonth; $day++)
                            @php
                                $dateIter = $dateObj->copy()->day($day);
                                $dateStr = $dateIter->format('Y-m-d');
                                $record = $attendances[$dateStr] ?? null;
                            @endphp
                            <tr>
                                <td class="ps-3 fw-bold" style="font-size:0.9rem;">
                                    {{ $dateIter->format('d M') }}
                                </td>
                                
                                <td>
                                    @if($record)
                                        @if($record->status == 'present')
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success px-2">Present</span>
                                        @elseif($record->status == 'late')
                                            <span class="badge bg-warning bg-opacity-10 text-dark border border-warning px-2">Late</span>
                                        @elseif($record->status == 'absent')
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-2">Absent</span>
                                        @endif
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                <td class="small text-muted">
                                    {{ ($record && $record->check_in) ? \Carbon\Carbon::parse($record->check_in)->format('h:i A') : '--:--' }}
                                </td>
                                
                                <td class="text-end pe-3 text-muted small">
                                    {{ $dateIter->format('l') }}
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

    @endif
</div>
</x-app-layout>