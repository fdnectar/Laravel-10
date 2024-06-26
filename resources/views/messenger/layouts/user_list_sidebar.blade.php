<div class="wsus__user_list">
    <div class="wsus__user_list_header">
        <h3>
            <span>
                <img src="/assets/images/chat_list_icon.png" alt="Chat" class="img-fluid">
            </span>
            MESSAGES
        </h3>
        <span class="setting" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fas fa-user-cog"></i>
        </span>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <form action="#" class="profile-form" enctype="multipart/form-data">
                            @csrf
                            <div class="file" style="height: 150px !important; width: 150px !important; object-fit: cover !important;">
                                <img src="{{ asset(auth()->user()->avatar) }}" alt="Upload" class="img-fluid profile-image-preview" style="height: 130px !important; width: 130px !important; object-fit: cover !important;">
                                <label for="select_file"><i class="fal fa-camera-alt"></i></label>
                                <input id="select_file" type="file" hidden name="avator">
                            </div>
                            <p>Edit information</p>
                            <input type="text" placeholder="Name" value="{{ auth()->user()->name }}" name="name">
                            <input type="email" placeholder="Email" value="{{ auth()->user()->email }}" name="email">
                            <input type="text" placeholder="User Id" value="{{ auth()->user()->username }}" name="username">
                            <p>Change password</p>
                            <div class="row mb-3">
                                <div class="col-xl-6">
                                    <input type="password" placeholder="Current Password" name="current_password">
                                </div>
                                <div class="col-xl-6">
                                    <input type="password" placeholder="New Password" name="password">
                                </div>
                                <div class="col-xl-12">
                                    <input type="password" placeholder="Confirm Password" name="password_confirmation">
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary cancel"
                                    data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary save profile-save">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Search Bar --}}
    @include('messenger.layouts.search')

    <div class="wsus__favourite_user">
        <div class="top">favourites</div>
        <div class="row favourite_user_slider">
            <div class="col-xl-3">
                <a href="#" class="wsus__favourite_item">
                    <div class="img">
                        <img src="/assets/images/author_img_1.jpg" alt="User" class="img-fluid">
                        <span class="inactive"></span>
                    </div>
                    <p>mr hasin</p>
                </a>
            </div>
        </div>
    </div>

    <div class="wsus__save_message">
        <div class="top">your space</div>
        <div class="wsus__save_message_center">
            <div class="icon">
                <i class="far fa-bookmark"></i>
            </div>
            <div class="text">
                <h3>Saved Messages</h3>
                <p>Save messages secretly</p>
            </div>
            <span>you</span>
        </div>
    </div>

    <div class="wsus__user_list_area">
        <div class="top">All Messages</div>
        <div class="wsus__user_list_area_height">
            <div class="wsus__user_list_item">
                <div class="img">
                    <img src="/assets/images/author_img_1.jpg" alt="User" class="img-fluid">
                    <span class="active"></span>
                </div>
                <div class="text">
                    <h5>Jubaydul islam</h5>
                    <p><span>You</span> Hi, What"s your name</p>
                </div>
                <span class="time">10m ago</span>
            </div>
        </div>

        <!-- <div class="wsus__user_list_liading">
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div> -->

    </div>
</div>

@push('custom-scripts')

<script>
    $(document).ready(function() {
        $('.profile-form').on('submit', function(e) {
            e.preventDefault();
            // notyf.success('Your changes have been successfully saved!');
            let saveBtn = $('.profile-save');
            let formData = new FormData(this);
            $.ajax({
                method: 'POST',
                url: '{{ route("profile.update") }}',
                data: formData,
                processData:false,
                contentType:false,
                beforeSend: function() {
                    saveBtn.text('Saving...');
                    saveBtn.prop("disabled", true);
                },
                success: function(data) {
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    // console.log(xhr);
                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function(index, value){
                        notyf.error(value[0]);
                    });

                    saveBtn.text('Save Changes');
                    saveBtn.prop("disabled", false);
                }
            });
        });
    });
</script>

@endpush
