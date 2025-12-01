<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Employee</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <h5 class="border-bottom pb-2">Profile Image</h5>
                            <div class="col-md-12">
                                <label class="form-label">Upload Photo</label>
                                <input type="file" name="profile_image" class="form-control">
                            </div>

                            <h5 class="border-bottom pb-2 mt-4">Account Details</h5>
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <h5 class="border-bottom pb-2 mt-4">Profile Details</h5>
                            <div class="col-md-4">
                                <label class="form-label">Employee ID (Barcode will be generated from this)</label>
                                <input type="text" name="employee_id" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-select">
                                    <option value="Collection Staff">Collection Staff</option>
                                    <option value="Employee">Employee</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Branch Manager">Branch Manager</option>
                                    <option value="Accounts Manager">Accounts Manager</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Blood Group</label>
                                <input type="text" name="blood_group" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contact No</label>
                                <input type="text" name="contact_number" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Emergency Contact</label>
                                <input type="text" name="emergency_contact_number" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control">
                            </div>
                            
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>