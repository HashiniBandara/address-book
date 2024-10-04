<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    // public function index()
    // {
    //     $customers = Customer::paginate(1); // Display 10 customers per page
    //     return view('admin.customer.index', compact('customers'));
    // }

    // public function index(Request $request)
    // {
    //     $search = $request->input('search');
    //     $customers = Customer::where('name', 'LIKE', "%{$search}%")
    //         ->orWhere('email', 'LIKE', "%{$search}%")
    //         ->get();

    //     return response()->json($customers);
    // }
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Check if a search term has been provided
        if ($search) {
            // Search for customers matching the search term
            $customers = Customer::where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->paginate(10); // Adjust the number of items per page as needed
        } else {
            // Get all customers paginated if no search term is provided
            $customers = Customer::paginate(10); // Display 10 customers per page
        }

        return view('admin.customer.index', compact('customers'));
    }
    // public function index(Request $request)
    // {
    //     $search = $request->get('search');
    //     $customers = Customer::when($search, function($query, $search) {
    //         return $query->where('name', 'LIKE', "%{$search}%")
    //                      ->orWhere('company', 'LIKE', "%{$search}%");
    //     })->get(); // Get all customers or the filtered ones

    //     return response()->json($customers);
    // }


    public function create()
    {
        return view('admin.customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'contact_phone' => 'required',
            'email' => 'required|email|unique:customers',
            'country' => 'required',
            'addresses.*.number' => 'required',
            'addresses.*.street' => 'required',
            'addresses.*.city' => 'required',
            'addresses.*.state' => 'required',
        ]);

        $customer = Customer::create($request->only('name', 'company', 'contact_phone', 'email', 'country'));

        // Create the addresses
        foreach ($request->addresses as $address) {
            $customer->addresses()->create($address);
        }

        if ($request->ajax()) {
            return response()->json(['success' => 'Customer created successfully']);
        }

        return redirect()->route('admin.customer.index')->with('success', 'Customer created successfully');
    }

    public function edit(Customer $customer)
    {
        // Fetch customer with addresses
        $customer->load('addresses');
        return response()->json([
            'customer' => $customer,
            'addresses' => $customer->addresses
        ]);
    }

    //  public function update(Request $request, Customer $customer)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'contact_phone' => 'required',
    //         'email' => 'required|email|unique:customers,email,' . $customer->id,
    //         'country' => 'required',
    //         'addresses.*.number' => 'required',
    //         'addresses.*.street' => 'required',
    //         'addresses.*.city' => 'required',
    //         'addresses.*.state' => 'required',
    //     ]);

    //     // Update customer details
    //     $customer->update($request->only('name', 'company', 'contact_phone', 'email', 'country'));

    //     // Update the addresses only if they exist
    //     if ($request->addresses) {
    //         $customer->addresses()->delete(); // Delete old addresses
    //         foreach ($request->addresses as $address) {
    //             $customer->addresses()->create($address);
    //         }
    //     }

    //     if ($request->ajax()) {
    //         return response()->json(['success' => 'Customer updated successfully']);
    //     }

    //     return redirect()->route('admin.customer.index')->with('success', 'Customer updated successfully');
    // }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required',
            'contact_phone' => 'required',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'country' => 'required',
            'addresses.*.number' => 'required',
            'addresses.*.street' => 'required',
            'addresses.*.city' => 'required',
            'addresses.*.state' => 'required',
        ]);

        // Update customer details
        $customer->update($request->only('name', 'company', 'contact_phone', 'email', 'country'));

        // Update or replace addresses
        if ($request->addresses) {
            // Delete old addresses
            $customer->addresses()->delete();

            // Create new addresses
            foreach ($request->addresses as $address) {
                $customer->addresses()->create($address); // Create each new address
            }
        }

        return response()->json(['success' => 'Customer updated successfully']);
    }


// Toggle Customer Status (Instead of Deleting)
public function toggleStatus(Customer $customer)
{
    // Toggle the deleted_at field
    $customer->deleted_at = $customer->deleted_at ? 0 : 1; // Change to 0 for active, 1 for inactive
    $customer->save();

    return response()->json(['success' => 'Customer status updated']);
}


    public function search(Request $request)
{
    $search = $request->search;

    if($search == ''){
        $customers = Customer::orderby('name','asc')->select('id','name')->limit(5)->get();
    }else{
        $customers = Customer::orderby('name','asc')->select('id','name')->where('name', 'like', '%' .$search . '%')->limit(5)->get();
    }

    $response = array();
    foreach($customers as $customer){
        $response[] = array("id"=>$customer->id,"text"=>$customer->name);
    }

    return response()->json($response);
}

public function getActiveCustomers()
{
    $customers = Customer::where('deleted_at', 0)->get();
    return response()->json(['customers' => $customers]);
}


}
