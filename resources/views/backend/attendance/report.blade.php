<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Attendance Report</h2>
    </x-slot>

    <style>
        /* --- Compact Calendar Grid --- */
        .calendar-grid { 
            display: grid; 
            grid-template-columns: repeat(7, 1fr); 
            gap: 4px; /* Tight gap */
        }
        
        .calendar-day {
            aspect-ratio: 1/1; 
            border: 1px solid #e9ecef; 
            border-radius: 6px;
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center;
            background: #fff; 
            font-size: 0.9rem; 
            position: relative;
            min-height: 50px; /* Ensure visibility on all devices */
        }
        
        .cal-header { 
            font-size: 0.75rem; 
            font-weight: 700; 
            text-align: center; 
            color: #6c757d; 
            padding-bottom: 4px;
            text-transform: uppercase;
        }

        /* Stats Card Styling */
        .stat-card {
            border-left: 4px solid;
            background-color: #fff;
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); }

        /* Status Colors */
        .bg-present { background-color: #d1e7dd; color: #0f5132; border-color: #badbcc; }
        .bg-absent  { background-color: #f8d7da; color: #842029; border-color: #f5c2c7; }
        .bg-late    { background-color: #fff3cd; color: #664d03; border-color: #ffecb5; }
        .bg-empty   { background-color: #f8f9fa; }
        
        /* Mobile Specific Overrides */
        @media (max-width: 576px) {
            .mobile-stack { flex-direction: column; align-items: stretch !important; }
            .mobile-full-width { width: 100% !important; margin-bottom: 5px; }
            .calendar-day { font-size: 0.75rem; min-height: 40px; border-radius: 4px; }
            .cal-status-text { font-size: 0.65rem; }
        }
    </style>

    <div class="container-fluid py-3" style="max-width: 1200px;">
        
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body p-2">
                <div class="d-flex justify-content-between align-items-center gap-3 mobile-stack">
                    
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('attendance.index') }}" class="btn btn-light btn-sm rounded-circle shadow-sm border" style="width: 32px; height: 32px; display: grid; place-items: center;">
                            <i class="fas fa-arrow-left fa-sm"></i>
                        </a>
                        <div style="line-height: 1.2;">
                            <h6 class="fw-bold m-0 text-dark">{{ $user->name }}</h6>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ $user->employee_id ?? 'ID: '.$user->id }}</small>
                        </div>
                    </div>

                    <form action="{{ route('attendance.report', $user->id) }}" method="GET" class="d-flex gap-2 flex-wrap mobile-stack">
                        
                        <div class="btn-group btn-group-sm mobile-full-width" role="group">
                            <input type="radio" class="btn-check" name="view_type" value="calendar" id="v_cal" onchange="this.form.submit()" {{ $viewType == 'calendar' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary" for="v_cal"><i class="fas fa-calendar-alt me-1"></i>Calendar</label>

                            <input type="radio" class="btn-check" name="view_type" value="table" id="v_tab" onchange="this.form.submit()" {{ $viewType == 'table' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary" for="v_tab"><i class="fas fa-list me-1"></i>List</label>
                        </div>

                        <div class="d-flex gap-1 mobile-full-width">
                            <select name="month" class="form-select form-select-sm border-secondary border-opacity-25 shadow-none" style="min-width: 80px;" onchange="this.form.submit()">
                                @for($m=1; $m<=12; $m++)
                                    <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>{{ date('M', mktime(0, 0, 0, $m, 1)) }}</option>
                                @endfor
                            </select>

                            <select name="year" class="form-select form-select-sm border-secondary border-opacity-25 shadow-none" style="min-width: 70px;" onchange="this.form.submit()">
                                @for($y=date('Y'); $y>=2023; $y--)
                                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row g-2 mb-3">
            <div class="col-4 col-md-4">
                <div class="card stat-card border-success shadow-sm h-100">
                    <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                        <small class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem;">Present</small>
                        <div class="h5 fw-bold text-success m-0">{{ $present }}</div>
                    </div>
                </div>
            </div>
            <div class="col-4 col-md-4">
                <div class="card stat-card border-danger shadow-sm h-100">
                    <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                        <small class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem;">Absent</small>
                        <div class="h5 fw-bold text-danger m-0">{{ $absent }}</div>
                    </div>
                </div>
            </div>
            <div class="col-4 col-md-4">
                <div class="card stat-card border-warning shadow-sm h-100">
                    <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                        <small class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem;">Late</small>
                        <div class="h5 fw-bold text-dark m-0">{{ $late }}</div>
                    </div>
                </div>
            </div>
        </div>

        @if($viewType == 'calendar')
            
            <div class="card shadow-sm border-0">
                <div class="card-body p-3"> <div class="calendar-grid mb-2">
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
                            <div class="calendar-day bg-empty border-0"></div>
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
                                <span class="fw-bold" style="line-height:1;">{{ $day }}</span>
                                @if($record)
                                    <small class="cal-status-text mt-1 fw-bold text-muted">
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
                    <table class="table table-sm table-hover align-middle mb-0" style="font-size: 0.9rem;">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th class="ps-3 py-2">Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Check-in</th>
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
                                    <td class="ps-3 fw-bold">{{ $dateIter->format('d M') }}</td>
                                    
                                    <td class="text-center">
                                        @if($record)
                                            @if($record->status == 'present')
                                                <span class="badge bg-success text-white px-2 rounded-1">Present</span>
                                            @elseif($record->status == 'late')
                                                <span class="badge bg-warning text-dark px-2 rounded-1">Late</span>
                                            @elseif($record->status == 'absent')
                                                <span class="badge bg-danger text-white px-2 rounded-1">Absent</span>
                                            @endif
                                        @else
                                            <span class="text-muted opacity-25">-</span>
                                        @endif
                                    </td>

                                    <td class="text-center text-muted">
                                        {{ ($record && $record->check_in) ? \Carbon\Carbon::parse($record->check_in)->format('h:i A') : '--' }}
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