@extends('adminpage.adminlayout.home')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <h2>Payment History</h2>
    <div class="mb-4">
        <label for="fromDate">From:</label>
        <input type="date" id="fromDate" class="form-control d-inline w-auto" style="display: inline-block; width: auto;">
        
        <label for="toDate" class="ml-2">To:</label>
        <input type="date" id="toDate" class="form-control d-inline w-auto" style="display: inline-block; width: auto;">
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1/06/2024</td>
                <td>User4564</td>
                <td>RM400.00</td>
                <td><span class="badge bg-success">Success</span></td>
            </tr>
            <tr>
                <td>15/06/2024</td>
                <td>User87868</td>
                <td>RM350.00</td>
                <td><span class="badge bg-success">Success</span></td>
            </tr>
            <tr>
                <td>28/06/2024</td>
                <td>User22734</td>
                <td>RM500.00</td>
                <td><span class="badge bg-danger">Failed</span></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection