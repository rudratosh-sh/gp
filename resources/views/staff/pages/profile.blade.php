@extends('staff.layouts.staff-layout')
@section('content')
    <div class="internal-page profile-page">
        <section class="profile">
            <p class="page-heading">
                <button class="back-button">
                    <img src="../assets/back-button.png" />
                </button>
                <span style="font-size: 22px;">Profile Page</span>
            </p>
            <section
                class="user-detail-wrapper user-detail-wrapper-profile-page user-detail-wrapper-allied-profile-page flex justify-center">
                <form method="POST" action="{{ route('staff.profile.update') }}" enctype="multipart/form-data"
                    style="width: 100%">
                    @csrf

                    <div class="user-detail user-detail-edit-profile">
                        <!-- Image upload -->
                        <div class="flex">
                            <div class="shrink-0" style="margin-top: 40px; position: relative;">
                                <img id="preview-image"
                                    src="{{ $profileData->avatar ? asset($profileData->avatar) : '/assets/images/chat-profile.png' }}"
                                    style="border-radius: 50%" width="210px" height="210px" alt="" />
                                <label for="image-upload-input"
                                    style="position: absolute; top: 0; right: 0; margin-top: 150px; margin-right: 1rem; cursor: pointer;">
                                    <div class=""
                                        style="background-color: #FFF; width: 50px; height: 50px; border-radius: 50%; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); display: flex; align-items: center; justify-content: center;">
                                        <img src="../assets/camera.svg"
                                            style="width: 15px; height: 23px; z-index: 1; transform: scale(1.5, 1.5);" />
                                    </div>
                                </label>
                                <input type="file" id="image-upload-input" name="avatar"
                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" />
                            </div>
                            <div class="user-detail-right">
                                @foreach ($fields as $field)
                                    <div class="row">
                                        <div class="col-3">
                                            <span
                                                class="left-side-key-name">{{ ucfirst(str_replace('_', ' ', $field)) }}</span>
                                        </div>
                                        <div class="col-9">
                                            @if ($field === 'about_me')
                                                <textarea type="text" class="user-detail-input" rows="6" name="{{ $field }}">{{ old($field, $profileData->$field) }}</textarea>
                                            @elseif ($field === 'email')
                                                <input type="email" class="user-detail-input" name="{{ $field }}"
                                                    value="{{ old($field, $profileData->$field) }}" />
                                            @elseif ($field === 'medicare_number')
                                                <input type="text" class="user-detail-input" name="{{ $field }}"
                                                    value="{{ old($field, $profileData->medicareDetail->$field) }}" />
                                            @elseif ($field === 'address')
                                                <input type="text" class="user-detail-input" name="{{ $field }}"
                                                    value="{{ old($field, $profileData->medicareDetail->$field) }}" />
                                            @else
                                                <input type="text" class="user-detail-input" name="{{ $field }}"
                                                    value="{{ old($field, $profileData->$field) }}" />
                                            @endif

                                            @error($field)
                                                <div class="text-red-500">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="user-detail-buttons-wrap">
                            <div class="user-detail-buttons">
                                <button onclick="navigateToPage('/patient/profile.html')" class="cancel">Cancel</button>
                                <button type="submit" style="cursor: pointer" class="save">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#image-upload-input').change(function() {
                readURL(this);
            });

        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview-image').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]); // Read the image file as a data URL.
            }
        }
        $(document).ready(function() {
            const headerUserProfile = $(".login_user");
            const userPopup = $(".user_profile_popup");
            headerUserProfile.on("click", handleUserPopup);

            function handleUserPopup(event) {
                event.stopPropagation();
                userPopup.toggle();
            }
        });
    </script>
@endsection
