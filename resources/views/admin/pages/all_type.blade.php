@extends('admin.pages_layout')

@section('content')

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <a href="#" type="button" class="btn btn-inverse-success">Add Property</a>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">All Type</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Type Name</th>
                                    <th>Type Icon</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($type as $key => $value )
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $value->type_name }}</td>
                                    <td>{{ $value->type_icon }}</td>
                                    <td>
                                        <a href="#" type="button" class="btn btn-inverse-success">Edit</a>
                                        <button type="button" class="btn btn-inverse-danger">Delete</button>
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
