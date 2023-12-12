@extends('staff.layouts.staff-layout')
<style>
    .container {
        overflow: scroll !important;
    }

    .action-items .column {
        display: flex;
        justify-content: end;
    }

    .action-items .column .is-primary {
        margin-left: 10px;
        background: #3d386a 0% 0% no-repeat padding-box;
        border-radius: 10px;
        opacity: 1;
        font-size: 20px;
    }

    .action-items .column .is-outlined {
        border-color: #3d386a;
        color: #3d386a;
        border-radius: 10px;
        font-size: 20px;
    }

    .open-preview {
        padding: 5px !important;
        margin: 0px auto;
        width: 24px;
        height: 24px !important;
        float: right;
        margin-right: 3px;
        margin-top: 0px;
        top: 35px;
    }
</style>
@section('content')
    <style>
        .right-hr {
            border-right: 1px solid black;
            width: 45px;
        }
    </style>

    <section class="report">
        <p class="page-heading">
            <button class="back-button" style="margin-top: 3px;">
                <img src="/assets/back-button.png" />
            </button>
            <span style="font-size: 22px;">Patient Vitals</span>
        </p>
        <div class="report-content">
            <div class="patient-details">
                <p class="basic-details">
                    <span class="name">{{ $patient->name }}</span>
                    <span class="gender">{{ $patient->medicareDetail->gender }}</span>
                    <span
                        class="age">{{ \Carbon\Carbon::parse($patient->medicareDetail->birthdate)->diff(\Carbon\Carbon::now())->format('%y years') }}</span>
                </p>
                <p class="advanced-details">
                    Contact: <span class="">{{ $patient->mobile }}</span> Medicare No:
                    <span class="">{{ $patient->medicareDetail->medicare_number }}</span> Last Visited:
                    <span class="">{{ $last_visited ?? '-' }}</span>
                </p>
            </div>
            <div class="report-details">
                <form action="{{ route('staff.save.patient.vitals', ['userId' => encrypt($patient->id)]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="columns is-flex-wrap-wrap">
                        @foreach ($vitalMaster as $mv)
                            <div class="column is-6 field">
                                <label>{{ $mv->vital->name }}</label>
                                @php
                                    $clinicVital = $clinicVitals->firstWhere('clinic_vital_id', $mv->id);
                                    $fieldName = $clinicVital ? 'vitals[' . $clinicVital->clinic_vital_id . ']' : 'vital_uploads_' . $mv->id;
                                    $errorName = $clinicVital ? 'vitals.' . $clinicVital->clinic_vital_id : 'vital_uploads_' . $mv->id;
                                @endphp
                                @if ($clinicVital)
                                    @if ($mv->vital->type === 'upload')
                                        <div class="upload-photo-wrp" style="position: relative;">
                                            <span id="upload-photo-text">{{ $mv->vital->name }}</span>
                                            <input type="file" name="{{ $fieldName }}"
                                                accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                                            <button id="clearButton"
                                                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: transparent; border: none; cursor: pointer; display: none;font-size: 28px;">&times;</button>
                                                <button type="button" class="button open-preview is-outlined"
                                                data-file-url="{{ asset($clinicVital->value) }}">P</button>
                                            </div>
                                        @error($errorName)
                                            <p class="help is-danger">{{ $message }}</p>
                                        @enderror
                                    @else
                                        <input type="text" name="{{ $fieldName }}"
                                            value="{{ old($errorName, $clinicVital->value ?? '') }}"
                                            placeholder="{{ $mv->vital->name }}" />
                                        @error($errorName)
                                            <p class="help is-danger">{{ $message }}</p>
                                        @enderror
                                    @endif
                                @elseif ($mv->vital->type === 'upload')
                                    <div class="upload-photo-wrp" style="position: relative;">
                                        <span id="upload-photo-text">{{ $mv->vital->name }}</span>
                                        <input type="file" name="{{ $fieldName }}"
                                            accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                                        <button id="clearButton"
                                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: transparent; border: none; cursor: pointer; display: none;font-size: 28px;">&times;</button>
                                    </div>
                                    <div id="imagePreview" style="width:100px;height:100px; margin-left: 1rem;"></div>
                                    @error($errorName)
                                        <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                                @else
                                    <input type="text" name="{{ $fieldName }}" value="{{ old($errorName) }}"
                                        placeholder="{{ $mv->vital->name }}" />
                                    @error($errorName)
                                        <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="action-items">
                        <div class="columns">
                            <div class="column">
                                <button class="button is-outlined">Cancel</button>
                                <button type="submit" class="button is-primary">Save</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="{{ encrypt($user->clinic_id) }}" name="clinic_id" />
                </form>
                <!-- HTML structure for the modal -->
                <div class="modal" id="previewModal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <div id="previewContent"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('/js/staff/booked-appointment.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.open-preview').click(function() {
                var fileUrl = $(this).data('file-url');
                var fileType = getFileType(fileUrl);

                // Function to display preview based on file type
                displayPreview(fileUrl, fileType);

                // Show the modal
                $('#previewModal').show();
            });

            // Close the modal when clicking the close button
            $('.close').click(function() {
                $('#previewModal').hide();
            });

            // Function to get file type
            function getFileType(url) {
                var extension = url.split('.').pop().toLowerCase();
                if (extension === 'pdf') {
                    return 'pdf';
                } else if (extension === 'doc' || extension === 'docx') {
                    return 'doc';
                } else {
                    return 'image';
                }
            }

            // Function to display preview based on file type
            function displayPreview(url, type) {
                var previewContent = $('#previewContent');
                previewContent.empty(); // Clear any previous content

                if (type === 'pdf') {
                    // Display PDF using an embed or iframe
                    previewContent.html('<embed src="' + url +
                        '" type="application/pdf" width="100%" height="500px" />');
                } else if (type === 'doc') {
                    // Display document using an embed or iframe
                    previewContent.html('<iframe src="https://view.officeapps.live.com/op/embed.aspx?src=' +
                        encodeURIComponent(url) + '" width="100%" height="500px" frameborder="0">');
                } else {
                    // Display image
                    previewContent.html('<img src="' + url + '" style="max-width: 100%; max-height: 500px;" />');
                }
            }
        });
    </script>
@endsection
