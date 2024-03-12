@extends('admin.pages_layout')

@section('content')
    <div class="row profile-body">
        <!-- left wrapper start -->
        <div class="d-none d-md-block col-md-4 col-xl-4 left-wrapper">
            <div class="card rounded">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div>
                            <img class="wd-100 rounded-circle" src="{{ (!empty($profileData->photo)) ? url('images/admin_images/'.$profileData->photo) : url('images/no_image.jpg') }}" alt="profile">
                            <span class="h4 ms-3 text-capitalize">{{ $profileData->username }}</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Name:</label>
                        <p class="text-muted">{{ $profileData->name }}</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                        <p class="text-muted">{{ $profileData->email }}</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Phone:</label>
                        <p class="text-muted">{{ $profileData->phone }}</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Address:</label>
                        <p class="text-muted">{{ $profileData->address }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- left wrapper end -->
        <!-- middle wrapper start -->
        <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Update Admin Profile</h6>
                        <form class="forms-sample" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" value="{{ $profileData->username }}" id="" autocomplete="off"
                                    placeholder="Username">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $profileData->name }}" id="" autocomplete="off"
                                    placeholder="Name">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Email address</label>
                                <input type="email" class="form-control" name="email" value="{{ $profileData->email }}" id="" placeholder="Email">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Phone</label>
                                <input type="tel" class="form-control" name="phone" value="{{ $profileData->phone }}" id="" placeholder="Phone">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" value="{{ $profileData->phone }}" id="" placeholder="Phone">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Photo</label>
                                <input type="file" class="form-control" name="photo" id="image">
                            </div>
                            <div class="mb-3">
                                <img id="showImage" class="wd-80 rounded-circle" src="{{ (!empty($profileData->photo)) ? url('images/admin_images/'.$profileData->photo) : url('images/no_image.jpg') }}" alt="profile">
                            </div>
                            <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                            {{-- <button class="btn btn-secondary">Cancel</button> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- middle wrapper end -->
    </div>
@endsection

@push('custom-scripts')

<script>
    $(document).ready(function() {
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>

@endpush
