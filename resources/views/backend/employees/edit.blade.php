<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Edit Employee</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('employees.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-12 d-flex align-items-center gap-3">
                                @if($user->profile->profile_image)
                                    <div>
                                        <label class="form-label d-block">Current Image</label>
                                        <img src="{{ asset('img/profile/'.$user->profile->profile_image) }}" width="100" class="rounded border">
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <label class="form-label">Change Profile Image</label>
                                    <input type="file" name="profile_image" class="form-control">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Emp ID</label>
                                <input type="text" name="employee_id" class="form-control" value="{{ $user->profile->employee_id ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-select">
                                    <option value="Employee" {{ ($user->profile->role ?? '') == 'Employee' ? 'selected' : '' }}>Employee</option>
                                    <option value="Manager" {{ ($user->profile->role ?? '') == 'Manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="Admin" {{ ($user->profile->role ?? '') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Blood Group</label>
                                <input type="text" name="blood_group" class="form-control" value="{{ $user->profile->blood_group ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contact</label>
                                <input type="text" name="contact_number" class="form-control" value="{{ $user->profile->contact_number ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Emergency Contact</label>
                                <input type="text" name="emergency_contact_number" class="form-control" value="{{ $user->profile->emergency_contact_number ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">DOB</label>
                                <input type="date" name="dob" class="form-control" value="{{ $user->profile->dob ?? '' }}">
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>