<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .employee-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .employee-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .employee-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e9ecef;
        }
        
        .employee-avatar-sm {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-active {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-inactive {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .action-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
        }
        
        .action-btn:hover {
            transform: scale(1.1);
        }
        
        .search-box {
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 10px 15px;
        }
        
        .filter-btn {
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: white;
        }
        
        .table-responsive-custom {
            border-radius: 12px;
            overflow: hidden;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #64748b;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px 12px;
            background-color: #f8fafc;
        }
        
        .table td {
            padding: 15px 12px;
            vertical-align: middle;
        }
        
        .barcode-preview {
            height: 40px;
            width: auto;
            border-radius: 4px;
            background: white;
            padding: 3px;
            border: 1px solid #e2e8f0;
        }
        
        .role-badge {
            background-color: #e0f2fe;
            color: #0369a1;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .mobile-employee-card {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 16px;
            margin-bottom: 16px;
            background: white;
        }
        
        @media (max-width: 768px) {
            .desktop-table {
                display: none;
            }
            
            .mobile-cards {
                display: block;
            }
        }
        
        @media (min-width: 769px) {
            .mobile-cards {
                display: none;
            }
            
            .desktop-table {
                display: block;
            }
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }
        
        .empty-state-icon {
            font-size: 64px;
            color: #cbd5e1;
            margin-bottom: 16px;
        }
    </style>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-1">Employee Management</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-0">Manage your team members and their information</p>
            </div>
            <a href="{{ route('employees.create') }}" class="btn btn-primary d-flex align-items-center">
                <i class="fas fa-plus me-2"></i> Add Employee
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Filters and Search -->
            <div class="card employee-card mb-4">
                <div class="card-body">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 search-box" placeholder="Search employees...">
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-md-end">
                            <div class="d-flex gap-2">
                                <button class="btn filter-btn d-flex align-items-center">
                                    <i class="fas fa-filter me-2"></i> Filter
                                </button>
                                <button class="btn filter-btn d-flex align-items-center">
                                    <i class="fas fa-sort me-2"></i> Sort
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop Table View -->
            <div class="card employee-card desktop-table">
                <div class="card-header bg-white border-bottom-0 pb-0">
                    <h5 class="card-title mb-0">All Employees ({{ count($employees) }})</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive table-responsive-custom">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Employee</th>
                                    <th>Employee ID</th>
                                    <th>Role</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employees as $emp)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($emp->profile && $emp->profile->profile_image)
                                                <img src="{{ asset('img/profile/'.$emp->profile->profile_image) }}" class="employee-avatar-sm me-3" alt="{{ $emp->name }}">
                                            @else
                                                <div class="employee-avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-3">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-semibold">{{ $emp->name }}</div>
                                                <small class="text-muted">{{ $emp->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ $emp->profile->employee_id ?? 'N/A' }}</div>
                                        @if($emp->profile && $emp->profile->barcode_image)
                                            <img src="{{ asset('img/barcodes/'.$emp->profile->barcode_image) }}" class="barcode-preview mt-1" alt="barcode">
                                        @endif
                                           <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ route('profile.public', $emp->profile->uid) }}" alt="QR" width="50">
                                    </td>
                                    <td>
                                        <span class="role-badge">{{ $emp->profile->role ?? 'Not Set' }}</span>
                                    </td>
                                    <td>
                                        <div>{{ $emp->profile->contact_number ?? '-' }}</div>
                                        @if($emp->profile && $emp->profile->uid)
                                        <small class="text-muted">UID: {{ $emp->profile->uid }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge status-active">Active</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('employees.edit', $emp->id) }}" class="action-btn btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('profile.public', $emp->profile->uid) }}" class="action-btn btn btn-sm btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="action-btn btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <h5 class="text-muted">No employees found</h5>
                                            <p class="text-muted mb-4">Get started by adding your first employee</p>
                                            <a href="{{ route('employees.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i> Add Employee
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Mobile Cards View -->
            <div class="mobile-cards">
                @forelse($employees as $emp)
                <div class="mobile-employee-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                            @if($emp->profile && $emp->profile->profile_image)
                                <img src="{{ asset('img/profile/'.$emp->profile->profile_image) }}" class="employee-avatar-sm me-3" alt="{{ $emp->name }}">
                            @else
                                <div class="employee-avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="fas fa-user text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <div class="fw-semibold">{{ $emp->name }}</div>
                                <small class="text-muted">{{ $emp->email }}</small>
                            </div>
                        </div>
                        <span class="status-badge status-active">Active</span>
                    </div>
                    
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <small class="text-muted">Employee ID</small>
                            <div class="fw-medium">{{ $emp->profile->employee_id ?? 'N/A' }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Role</small>
                            <div><span class="role-badge">{{ $emp->profile->role ?? 'Not Set' }}</span></div>
                        </div>
                    </div>
                    
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <small class="text-muted">Contact</small>
                            <div>{{ $emp->profile->contact_number ?? '-' }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Barcode</small>
                            <div>
                                @if($emp->profile && $emp->profile->barcode_image)
                                    <img src="{{ asset('img/barcodes/'.$emp->profile->barcode_image) }}" class="barcode-preview" alt="barcode">
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <a href="{{ route('employees.edit', $emp->id) }}" class="action-btn btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="action-btn btn btn-sm btn-outline-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="card employee-card">
                    <div class="card-body">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h5 class="text-muted">No employees found</h5>
                            <p class="text-muted mb-4">Get started by adding your first employee</p>
                            <a href="{{ route('employees.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i> Add Employee
                            </a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination (if applicable) -->
            @if($employees->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }} of {{ $employees->total() }} entries
                </div>
                <div>
                    {{ $employees->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('.search-box');
            
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    
                    // Search in desktop table
                    const tableRows = document.querySelectorAll('.desktop-table tbody tr');
                    tableRows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                    
                    // Search in mobile cards
                    const mobileCards = document.querySelectorAll('.mobile-employee-card');
                    mobileCards.forEach(card => {
                        const text = card.textContent.toLowerCase();
                        card.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }
        });
    </script>
</x-app-layout>