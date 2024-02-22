@extends('patient.layouts.public')
@section('content')
    <style type="text/css">
        /* Add this CSS to your stylesheet or within a <style> tag in your HTML */

        /* Style for the active tab button */
        .tab-btn.active {
            background-color: #007BFF;
            /* Change this to your preferred background color */
            color: #FFF;
            /* Change this to your preferred text color */
            border-color: #007BFF;
            /* Change this to your preferred border color */
        }

        /* Style for the active tab content */
        .tab-content.active {
            display: block;
        }

        /* Hide inactive tab content */
        .tab-content {
            display: none;
        }

        /* Add some basic styling to the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            font-weight: 50;
        }

        th {
            background-color: #f2f2f2;
            font-weight: 500;
        }

        /* Add some hover effect on table rows */
        tbody tr:hover {
            background-color: #f5f5f5;
        }

        /* Style the buttons */
        .btn {
            display: inline-block;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
    <div class="container">
        <!-- HEADER -->
        @include('patient.includes.header')

        <div class="space_container" style="padding: 0px">
            <!-- SIDE BAR -->
            <ul class="sidebar">
                <li id="dashboard-tab"><a style="all:unset"
                        class="a-tab-inactive"href="{{ route('appointment.schedule.list') }}">Dashboard</a></li>
                <li id="booking-tab"><a style="all:unset" class="a-tab-inactive"
                        href="{{ route('appointment.index.get') }}">Booking
                        Appointment</a></li>
                <li id="referral-tab"><a style="all:unset" class="a-tab-active"
                        href="{{ route('referal.index.get') }}">Referral Letter</a></li>
                <li class="active" id="profile-tab"><a style="all:unset" class="a-tab-inactive"
                        href="{{ route('patient.profile.get') }}">My Profile</a></li>
            </ul>
            <!-- Main Content -->
            <div class="dis_flx" style="padding: 0px;padding-top: 70px;">
                <div class="tabs" style="z-index: 99999999;position:absolute">
                    <button class="tab-button" data-target="profile-tabs">Profile</button>
                    <button class="tab-button" data-target="prescription-tab">Prescriptions</button>
                </div>
                <div id="profile-tabs" class="tab-content" style="padding: 0px">
                    <section class="user-detail-wrapper user-detail-wrapper-profile-page flex justify-center items-center"
                        style="padding: 0px">
                        <form method="POST" action="{{ route('patient.profile.update') }}" enctype="multipart/form-data"
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
                                                        <input type="email" class="user-detail-input"
                                                            name="{{ $field }}"
                                                            value="{{ old($field, $profileData->$field) }}" />
                                                    @elseif ($field === 'medicare_number')
                                                        <input type="text" class="user-detail-input"
                                                            name="{{ $field }}"
                                                            value="{{ old($field, $profileData->medicareDetail->$field) }}" />
                                                    @elseif ($field === 'address')
                                                        <input type="text" class="user-detail-input"
                                                            name="{{ $field }}"
                                                            value="{{ old($field, $profileData->medicareDetail->$field) }}" />
                                                    @else
                                                        <input type="text" class="user-detail-input"
                                                            name="{{ $field }}"
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
                                        <button onclick="navigateToPage('/patient/profile.html')"
                                            class="cancel">Cancel</button>
                                        <button type="submit" style="cursor: pointer" class="save">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
                <div id="prescription-tab" class="tab-content">
                    <section class="prescription-table">
                        <!-- Add a table here to display prescriptions -->
                        <!-- Example: -->
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th> What I’m Using </th>
                                    <th> How Much </th>
                                    <th> How To Use </th>
                                    <th>Remarks</th>
                                    <th>How to Contact</th>



                                    <!-- Add more columns as needed -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Populate the table with prescription data -->
                                <!-- Example: -->

                                @foreach ($prescriptions as $prescription)
                                    <tr>
                                        <td>{{ $prescription->id }}</td>
                                        <td>{{ $prescription->medication->drug_name }}</td>
                                        <td>{{ $prescription->medication->dosage }}</td>
                                        <td>{{ $prescription->medication->route }}</td>
                                        <td>{{ $prescription->remarks }}</td>
                                        <td>{{ $prescription->doctor->user->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                </div>


            </div>
        </div>
    </div>
@endsection

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
        // Hide all tab contents initially
        $(".tab-content").hide();

        // Show the default tab (profile-tab)
        $("#profile-tabs").show();

        // Handle tab switching
        $(".tab-button").click(function() {
            // Hide all tab contents
            $(".tab-content").hide();

            // Show the selected tab content
            var targetTab = $(this).data("target");
            $("#" + targetTab).show();
        });
    });
</script>
