@extends('admin.template.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>Projects List</h3>
            </div>
            <div class="text-right mt-2 mb-2">
                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#addProjectModal"
                    style="background-color:#0C9463!important; padding:5px!important; border-radius: 20%!important">
                    <i class="fas fa-plus text-white" style="font-size: 20px!important;"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Add New Project Modal -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectModalLabel">Add New Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProjectForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Project Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" style="background-color: #FBE3B9;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn text-white" style="background-color: #2D334A;" id="saveProjectBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Project Modal -->
    <div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="editProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProjectModalLabel">Edit Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProjectForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editProjectId" name="id">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Project Name</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editDescription" name="description" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" style="background-color: #FBE3B9;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn text-white"  style="background-color: #2D334A;" id="updateProjectBtn">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Customers Modal -->
    <div class="modal fade" id="addCustomersModal" tabindex="-1" aria-labelledby="addCustomersModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomersModalLabel">Add Customers to Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCustomersForm">
                        @csrf
                        <input type="hidden" id="projectId" name="project_id">

                        <!-- Search Field for Customers -->
                        <div class="mb-3">
                            <input type="text" id="customerSearch" class="form-control"
                                placeholder="Search customers by name or company">
                        </div>

                        <!-- Customer list with checkboxes -->
                        <div class="mb-3">
                            <label for="customers" class="form-label">Select Active Customers</label>
                            <div id="customerList">
                                <!-- populated dynamically via AJAX -->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" style="background-color: #FBE3B9;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn text-white"  style="background-color: #2D334A;" id="saveCustomersBtn">Add Customers</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Display success message --}}
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{-- Projects Table --}}
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Status</th>
            <th width="400px">Action</th>
        </tr>
        @foreach ($projects as $project)
            <tr>
                <td>{{ $project->name }}</td>
                <td>{{ $project->description }}</td>
                <td>
                    @if ($project->deleted_at == 0)
                        <span class="badge" style="background-color: #0C9463;">Active</span>
                    @else
                        <span class="badge" style="background-color: maroon;">Inactive</span>
                    @endif
                </td>
                <td>
                    <button class="btn text-white btn-sm editProjectBtn" style="background-color: #0C9463;" data-id="{{ $project->id }}">Edit</button>
                    <button class="btn btn-sm toggleStatusBtn" style="background-color: #FAB696;" data-id="{{ $project->id }}">
                        {{ $project->deleted_at ? 'Activate' : 'Deactivate' }}
                    </button>
                    <button class="btn btn-sm toggle-customerDetails"  style="background-color: #FBE3B9;"  data-id="{{ $project->id }}">View
                        Customers</button>
                    <button class="btn text-white btn-sm addCustomersBtn" data-id="{{ $project->id }}"
                        data-bs-toggle="modal" data-bs-target="#addCustomersModal" style="background-color: #2D334A;" >Add Customers</button>

                </td>

            </tr>
            @foreach ($project->customers as $customer)
                <tr class="customerDetails customer-{{ $project->id }}" style="display: none;">
                    <td></td>
                    <td> <strong style="color: #2D334A">Customer Details:</strong></td>
                    <td>Name: {{ $customer->name }} </td>
                    <td>Company: {{ $customer->company }}</td>
                </tr>
            @endforeach
        @endforeach
    </table>

    {{-- Pagination --}}
    <div class="pagination justify-content-left">
        {{ $projects->links() }}
    </div>

    <!-- jQuery Script to Toggle Address Details -->
    <script>
        $(document).ready(function() {
            // Handle the click event for toggling the customer details
            $('.toggle-customerDetails').on('click', function() {
                var id = $(this).data('id');
                $('.customer-' + id).toggle();
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Fetch and filter customers dynamically
            $('#customerSearch').on('keyup', function() {
                var searchText = $(this).val().toLowerCase();

                // Filter customers based on search text
                $('#customerList .form-check').each(function() {
                    var customerName = $(this).text().toLowerCase();
                    if (customerName.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Open the Add Customers modal and fetch active customers
            $(document).on('click', '.addCustomersBtn', function() {
                var projectId = $(this).data('id');
                $('#projectId').val(projectId);

                // Fetch the list of active customers via AJAX
                $.ajax({
                    url: '/admin/customers/active',
                    type: 'GET',
                    success: function(response) {
                        var customerListHtml = '';
                        response.customers.forEach(function(customer) {
                            customerListHtml += `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="customers[]" value="${customer.id}" id="customer${customer.id}">
                            <label class="form-check-label" for="customer${customer.id}">
                                ${customer.name} (${customer.company})
                            </label>
                        </div>`;
                        });
                        $('#customerList').html(customerListHtml);
                    },
                    error: function(xhr) {
                        alert('Failed to load active customers');
                    }
                });

                // Show the modal
                $('#addCustomersModal').modal('show');
            });

            // Handle saving the selected customers to the project
            $('#saveCustomersBtn').on('click', function(e) {
                e.preventDefault();
                var formData = $('#addCustomersForm').serialize();

                $.ajax({
                    url: '/admin/project/add-customers',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addCustomersModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Failed to add customers');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Set CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Save New Project
            $('#saveProjectBtn').on('click', function(e) {
                e.preventDefault();
                let formData = $('#addProjectForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.project.store') }}',
                    data: formData,
                    success: function(response) {
                        $('#addProjectModal').modal('hide');
                        location.reload(); // Reload the page to show the updated project list
                    },
                    error: function(xhr) {
                        $('#errorMessage').removeClass('d-none').text(xhr.responseJSON.message);
                    }
                });
            });

            // Open the Edit Project modal and populate the form
            $(document).on('click', '.editProjectBtn', function() {
                var projectId = $(this).data('id');

                // Make an AJAX request to get the project data
                $.ajax({
                    url: '/admin/project/' + projectId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        $('#editProjectId').val(response.project.id);
                        $('#editName').val(response.project.name);
                        $('#editDescription').val(response.project.description);

                        // Open the modal
                        $('#editProjectModal').modal('show');
                    },
                    error: function() {
                        alert('Error fetching project data');
                    }
                });
            });

            // Update Project functionality
            $('#updateProjectBtn').on('click', function(e) {
                e.preventDefault();

                let projectId = $('#editProjectId').val();
                let formData = $('#editProjectForm').serialize();

                $.ajax({
                    url: '/admin/project/' + projectId,
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        $('#editProjectModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        $('#errorMessage').removeClass('d-none').text(xhr.responseJSON.message);
                    }
                });
            });

            // Toggle Project status (Activate/Deactivate)
            $(document).on('click', '.toggleStatusBtn', function() {
                var projectId = $(this).data('id');

                $.ajax({
                    url: '/admin/project/' + projectId + '/toggle-status',
                    type: 'POST',
                    data: {},
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Error updating project status');
                    }
                });
            });
        });
    </script>
@endsection
