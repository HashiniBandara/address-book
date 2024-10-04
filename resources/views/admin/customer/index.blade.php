@extends('admin.template.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>Customers List</h3>
            </div>
            <div class="text-right mt-2 mb-2">
            </div>
        </div>
    </div>

    <!-- Add New Customer Button -->
    <div class="text-right mt-2 mb-2">
        <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#addCustomerModal"
            style="background-color:#0C9463!important; padding:5px!important; border-radius: 20%!important">
            <i class="fas fa-plus text-white" style="font-size: 20px!important;"></i>
        </button>
    </div>

    <!-- Add New Customer Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCustomerForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" class="form-control" id="company" name="company">
                        </div>
                        <div class="mb-3">
                            <label for="contact_phone" class="form-label">Contact Phone</label>
                            <input type="text" class="form-control" id="contact_phone" name="contact_phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country" name="country" required>
                        </div>

                        <!-- Address Section -->
                        <div id="addresses">
                            <div class="mb-3 address-item">
                                <label for="address1" class="form-label">Address 1</label>
                                <input type="text" class="form-control mt-2" name="addresses[0][number]"
                                    placeholder="Number" required>
                                <input type="text" class="form-control mt-2" name="addresses[0][street]"
                                    placeholder="Street" required>
                                <input type="text" class="form-control mt-2" name="addresses[0][city]" placeholder="City"
                                    required>
                                <input type="text" class="form-control mt-2" name="addresses[0][state]"
                                    placeholder="State" required>
                            </div>
                        </div>

                        <button type="button" class="btn text-white btn-sm" style="background-color: #2D334A;" id="addAddressBtn">Add Address</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" style="background-color: #FBE3B9;"  data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn text-white" style="background-color: #2D334A;" id="saveCustomerBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Customer Modal -->
    <div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCustomerModalLabel">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCustomerForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editCustomerId">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCompany" class="form-label">Company</label>
                            <input type="text" class="form-control" id="editCompany" name="company">
                        </div>
                        <div class="mb-3">
                            <label for="editContactPhone" class="form-label">Contact Phone</label>
                            <input type="text" class="form-control" id="editContactPhone" name="contact_phone"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCountry" class="form-label">Country</label>
                            <input type="text" class="form-control" id="editCountry" name="country" required>
                        </div>

                        <!-- Address Section -->
                        <div id="editAddresses">
                            <!-- Address items will be appended here dynamically -->
                        </div>

                        <button type="button" class="btn text-white btn-sm" style="background-color: #2D334A;" id="addEditAddressBtn">Add
                            Address</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn " style="background-color: #FBE3B9;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn text-white" style="background-color: #2D334A;" id="updateCustomerBtn">Update</button>
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

    {{-- Customers Table --}}
    {{-- <table class="table table-bordered"> --}}
    <table class="table">
        <tr>
            {{-- <th>No</th> --}}
            <th>Name</th>
            <th>Company</th>
            <th>Contact Phone</th>
            <th>Email</th>
            <th>Country</th>
            <th>Status</th>
            <th width="300px">Action</th>
        </tr>
        @foreach ($customers as $customer)
            <tr>
                {{-- <td>{{ $loop->iteration }}</td> --}}
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->company }}</td>
                <td>{{ $customer->contact_phone }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->country }}</td>
                <!-- Status Field: Check deleted_at -->
                <td>
                    @if ($customer->deleted_at == 0)
                        <span class="badge" style="background-color: #0C9463;">Active</span>
                    @else
                        <span class="badge" style="background-color: maroon;">Inactive</span>
                    @endif
                </td>
                <td>

                    <button class="btn text-white btn-sm editCustomerBtn" style="background-color: #0C9463;" data-id="{{ $customer->id }}">Edit</button>
                    <button class="btn  btn-sm toggleStatusBtn" style="background-color: #FAB696;" data-id="{{ $customer->id }}">
                        {{ $customer->deleted_at ? 'Activate' : 'Deactivate' }}
                    </button>
                    <button class="btn text-white btn-sm toggle-address" style="background-color: #2D334A;" data-id="{{ $customer->id }}">View
                        Address</button>
                </td>
            </tr>
            <!-- Hidden Address Details Row -->

            {{-- <td colspan="6"> --}}

            @foreach ($customer->addresses as $address)
                <tr class="address-details address-{{ $customer->id }}" style="display: none;">
                    <td></td>
                    <td></td>
                    <td> <strong style="color: #2D334A">Address:</strong></td>
                    <td>Number: {{ $address->number }}</td>
                    <td>Street: {{ $address->street }}</td>
                    <td>City: {{ $address->city }}</td>
                    <td>State: {{ $address->state }}</td>
                </tr>
            @endforeach
            </tr>
        @endforeach
    </table>


    {{-- Pagination --}}
    <div class="pagination justify-content-left">
        {{ $customers->links() }}
    </div>

    <!-- jQuery Script to Toggle Address Details -->
    <script>
        $(document).ready(function() {
            // Handle the click event for toggling the address details
            $('.toggle-address').on('click', function() {
                var id = $(this).data('id');
                $('.address-' + id).toggle();
            });
        });
    </script>

    <!-- jQuery Script for Address Management -->

    <script>
        $('#saveCustomerBtn').on('click', function(e) {
            e.preventDefault();

            let formData = $('#addCustomerForm').serialize();

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.customer.store') }}',
                data: formData,
                success: function(response) {
                    // Close the modal
                    $('#addCustomerModal').modal('hide');

                    location.reload(); // Reload the page to show the updated customer list
                },
                error: function(response) {
                    // Handle validation errors
                    alert('Error adding customer');
                }
            });
        });
    </script>



    <script>
        let addressCount = 1;

        // Ensure that the event handler for adding addresses is bound once
        $(document).ready(function() {
            // Handle adding address in the "Create" modal
            $('#addAddressBtn').off('click').on('click', function() {
                addAddressForm('#addresses', addressCount); // Add address form
                addressCount++;
            });

            // Handle adding address in the "Edit" modal
            $('#addEditAddressBtn').off('click').on('click', function() {
                addAddressForm('#editAddresses', addressCount, true); // Add address form
                addressCount++;
            });
        });

        function addAddressForm(container, index, isEdit = false) {
            let prefix = isEdit ? 'addresses[' + index + ']' : 'editAddresses[' + index + ']';
            let addressHtml = `
        <div class="mb-3 address-item">
            <label class="form-label">Address ${index + 1}</label>
            <input type="text" class="form-control mt-2" name="${prefix}[number]" placeholder="Number" required>
            <input type="text" class="form-control mt-2" name="${prefix}[street]" placeholder="Street" required>
            <input type="text" class="form-control mt-2" name="${prefix}[city]" placeholder="City" required>
            <input type="text" class="form-control mt-2" name="${prefix}[state]" placeholder="State" required>
            <button type="button" class="btn btn-danger btn-sm removeAddressBtn mt-2">Remove</button>
        </div>
    `;
            $(container).append(addressHtml);
        }


        $(document).on('click', '.removeAddressBtn', function() {
            $(this).closest('.address-item').remove(); // Removes the address form
        });


        // Open the Edit Customer modal and populate the form
        $(document).on('click', '.editCustomerBtn', function() {
            var customerId = $(this).data('id');
            addressCount = 0; // Reset the address count for the Edit form

            // Make an AJAX request to get the customer data, including addresses
            $.ajax({
                url: '/admin/customer/' + customerId + '/edit',
                type: 'GET',
                success: function(response) {
                    // Populate customer fields
                    $('#editCustomerId').val(response.customer.id);
                    $('#editName').val(response.customer.name);
                    $('#editCompany').val(response.customer.company);
                    $('#editContactPhone').val(response.customer.contact_phone);
                    $('#editEmail').val(response.customer.email);
                    $('#editCountry').val(response.customer.country);

                    // Clear and populate the addresses
                    $('#editAddresses').empty();
                    response.addresses.forEach((address, index) => {
                        addAddressForm('#editAddresses', index,
                            true); // Add address form with edit flag
                        addressCount = index + 1; // Update the count

                        // Fill in the values for each address
                        $(`#editAddresses .address-item:eq(${index})`).find(
                            'input[name*="[number]"]').val(address.number);
                        $(`#editAddresses .address-item:eq(${index})`).find(
                            'input[name*="[street]"]').val(address.street);
                        $(`#editAddresses .address-item:eq(${index})`).find(
                            'input[name*="[city]"]').val(address.city);
                        $(`#editAddresses .address-item:eq(${index})`).find(
                            'input[name*="[state]"]').val(address.state);
                    });

                    // Open the modal
                    $('#editCustomerModal').modal('show');
                },
                error: function() {
                    alert('Error fetching customer data');
                }
            });
        });
    </script>



    <script>
        $('#updateCustomerBtn').on('click', function(e) {
            e.preventDefault();

            let customerId = $('#editCustomerId').val(); // Get customerId from hidden input
            let formData = $('#editCustomerForm').serialize(); // Serialize the form data

            console.log(formData); // Log the form data for debugging

            $.ajax({
                url: '/admin/customer/' + customerId, // URL for the update request
                type: 'PUT',
                data: formData, // Pass the serialized form data
                success: function(response) {
                    $('#editCustomerModal').modal('hide'); // Close the modal on success
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log error details for debugging
                    alert('Error updating customer');
                }
            });
        });
    </script>

      <script>
        $(document).on('click', '.toggleStatusBtn', function() {
    var customerId = $(this).data('id');

    $.ajax({
        url: '/admin/customer/' + customerId + '/toggle-status',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}', // Ensure CSRF token is sent
        },
        success: function(response) {
            location.reload();
        },
        error: function() {
            alert('Error updating customer status');
        }
    });
});

    </script>
@endsection
