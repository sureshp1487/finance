<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Employee List</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-between mb-4">
                            <h4>Employees</h4>
                            <a href="{{ route('employees.create') }}" class="btn btn-primary">Add New</a>
                        </div>
                        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

                        <table class="table table-bordered align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Image</th>
                                    <th>Name / Email</th>
                                    <th>Emp ID & Barcode</th>
                                    <th>Role</th>
                                    <th>Contact</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $emp)
                                <tr>
                                    <td class="text-center">
                                        @if($emp->profile && $emp->profile->profile_image)
                                            <img src="{{ asset('img/profile/'.$emp->profile->profile_image) }}" width="60" height="60" class="rounded-circle" style="object-fit:cover">
                                        @else
                                            <span class="text-muted">No Img</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $emp->name }}</strong><br>
                                        <small>{{ $emp->email }}</small>
                                    </td>
                                    <td>
                                        ID: {{ $emp->profile->employee_id ?? 'N/A' }} <br>
                                        @if($emp->profile && $emp->profile->barcode_image)
                                            <img src="{{ asset('img/barcodes/'.$emp->profile->barcode_image) }}" alt="barcode" style="height: 30px; width: auto;">
                                        @endif
                                        
    <!-- <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ route('profile.public', $emp->profile->uid) }}" alt="QR" width="50"> -->

                                    </td>
                                    <td>{{ $emp->profile->role ?? '-' }}</td>
                                    <td>{{ $emp->profile->contact_number ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('employees.edit', $emp->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Sure?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Del</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>