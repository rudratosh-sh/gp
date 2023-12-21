@extends('doctor.layouts.doctor-layout', ['active' => 'history'])
@section('content')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        .right-hr {
            border-right: 1px solid black;
            width: 45px;
        }

        .autocomplete-wrapper {
            position: relative;
        }

        .autocomplete-input {
            width: 300px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            /* border-radius: 5px; */
        }

        .ui-autocomplete {
            position: absolute;
            z-index: 1000;
            background-color: #fff;
            border: 1px solid #ddd;
            border-top: none;
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 200px;
            overflow-y: auto;
            width: 15 0px;
            /* Adjust width as needed */
        }

        .ui-menu-item {
            padding: 8px 12px;
            cursor: pointer;
        }

        .ui-menu-item:hover {
            background-color: #f5f5f5;
        }

        .ui-state-active {
            border: none !important;
            background: transparent !important;
        }
    </style>
    <div class="content">
        <section class="bg-grey1 patient-detail-wrapper flex">
            <div class="left_section">
                <div class="flex items-center">
                    <a href="{{ route('doctor.patient.details.get', ['userId' => encrypt($appointment->user->id)]) }}">
                        <img class="pointer" width="40px" height="40px" src="/assets/images/arrow-left-purple.svg"
                            alt="">
                    </a>
                    <p class="text-grey2 text-22 font-bold ml-10">Patient Details</p>
                </div>
                <div class="bg-white detail-left-first mt-24">
                    <div class="px-12">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <p class="text-purple text-30 font-bold mr-15">{{ $appointment->user->name }}</p>
                                <p class="text-grey3 text-15 font-thin">
                                    {{ $appointment->medicareDetail->gender }}
                                    <span
                                        class="ml-10">{{ \Carbon\Carbon::parse($appointment->medicareDetail->birthdate)->age . ' Years' }}</span>
                                </p>
                            </div>
                            <img class="pointer right-messages openChatModel" width="28px" height="28px"
                                src="/assets/images/messages.svg" alt="" />
                        </div>
                        <div class="flex items-center justify-between mt-16">
                            <p class="text-grey3 text-xs font-thin">
                                Contact:
                                <span
                                    class="font-normal">{{ $appointment->user->country_code . '-' . $appointment->user->mobile }}</span>
                            </p>
                            <p class="text-grey3 text-xs font-thin">
                                Medicare No. :
                                <span class="font-normal">{{ $appointment->medicareDetail->medicare_number }}</span>
                            </p>
                            <p class="text-grey3 text-xs font-thin">
                                Last Visited:
                                <span class="font-normal">{{ $appointment->last_visited }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="flex">
                        <img class="pointer" width="25px" height="25px" src="/assets/images/vital.svg" alt="" />
                        <p class="text-grey4 text-18 font-bold ml-10">Vitals</p>
                    </div>

                    @php $vitalsChunks = $appointment->patientVitalValues->where('clinicVital.vital.type', 'text')->chunk(3); @endphp

                    @foreach ($vitalsChunks as $vitalsChunk)
                        <div class="flex mt-24">
                            @foreach ($vitalsChunk as $index => $ptValue)
                                @php
                                    $position = $index % 3;
                                    $vitalClass = $position === 0 ? 'vital-first' : ($position === 1 ? 'flex justify-center vital-second' : 'flex justify-center vital-third');
                                @endphp
                                <div class="{{ $vitalClass }}">
                                    <div>
                                        <p class="text-grey3 text-xs font-normal mb-10">
                                            {{ $ptValue->clinicVital->vital->name }}
                                        </p>
                                        <p class="text-grey4 text-20 font-bold">
                                            {{ strtok($ptValue->value, ' ') }}
                                            <span class="text-grey3 text-xs font-semibold">
                                                {{ strstr($ptValue->value, ' ') }}
                                            </span>
                                            <span class="text-grey3 text-xs font-normal">
                                                {{-- Additional information --}}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Fill the remaining spaces if less than 3 vitals --}}
                            @for ($i = count($vitalsChunk); $i < 3; $i++)
                                <div
                                    class="{{ $i === 0 ? 'vital-first' : ($i === 1 ? 'flex justify-center vital-second' : 'flex justify-center vital-third') }}">
                                    <!-- Empty div to maintain structure -->
                                </div>
                            @endfor
                        </div>
                    @endforeach

                </div>
                <div class="detail-left-second bg-white">
                    <div class="mt-36">
                        <p class="text-grey5 text-20 font-semibold">
                            Please list all problem you want to address today?
                        </p>
                        <p class="text-grey3 text-16 font-thin">
                            Lorem Ipsum is simply dummy text of the printing and typesetting
                            industry. Lorem Ipsum has been the industry’s standard dummy text
                            ever since the 1500s, when an unknown printer took a galley of
                            type and scrambled it to make a type specimen book. It has
                            survived not only five centuries, but also the leap into
                            electronic typesetting, remaining essentially unchanged. It was
                            popularised in the 1960s with the release
                        </p>
                    </div>
                    <div class="mt-36">
                        <p class="text-grey5 text-20 font-semibold">
                            Which health issues is your top priority for today?
                        </p>
                        <p class="text-grey3 text-16 font-thin">
                            Lorem Ipsum is simply dummy text of the printing and typesetting
                            industry. Lorem Ipsum has been the industry’s standard dummy text
                            ever since the 1500s, when an unknown printer took a galley of
                            type and scrambled it to make a type specimen book. It has
                            survived not only five centuries, but also the leap into
                            electronic typesetting, remaining essentially unchanged. It was
                            popularised in the 1960s with the release
                        </p>
                    </div>
                    <div class="mt-36">
                        <p class="text-grey5 text-20 font-semibold">
                            What do you feel might be the cause of this problem ?
                        </p>
                        <p class="text-grey3 text-16 font-thin">
                            Lorem Ipsum is simply dummy text of the printing and typesetting
                            industry. Lorem Ipsum has been the industry’s standard dummy text
                            ever since the 1500s, when an unknown printer took a galley of
                            type and scrambled it to make a type specimen book. It has
                            survived not only five centuries, but also the leap into
                            electronic typesetting, remaining essentially unchanged. It was
                            popularised in the 1960s with the release
                        </p>
                    </div>
                </div>
            </div>
            <div class="right_section">
                <form method="POST" action="{{ route('doctor.create.prescription.post') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img width="24px" height="24px" src="/assets/images/create-letter.svg" alt="" />
                            <p class="text-grey2 text-20 font-bold ml-10">Create prescription</p>
                        </div>
                        <div class="flex items-center">
                            <a class="save-btn" href="/gp/patient-details.html">Cancel</a>
                            <button class="refer-btn flex items-center" type="submit">
                                <span class="text-white text-20 ml-10">Save</span>
                            </button>
                        </div>
                    </div>
                    <div class="form-second-sec bg-white flex flex-col justify-between">
                        <div class="flex flex-col">
                            <div class="flex items-center justify-between form-date">
                                <p class="text-grey2 text-20 font-bold">
                                    {{ \Carbon\Carbon::now()->format('l jS F Y') }}
                                </p>
                                <img width="140px" height="72px" src="/assets/images/logo.png" alt="" />
                            </div>
                            <div class="pres-wrapper">
                                <p class="pres-title">New Prescription</p>
                                <div class="pres-table">
                                    <div class="pres-header">
                                        <div class="pres-header-wrapper1">
                                            <p>Medication</p>
                                        </div>
                                        <div class="pres-header-wrapper2">
                                            <p>Route</p>
                                        </div>
                                        <div class="pres-header-wrapper3">
                                            <p>Dosage</p>
                                        </div>
                                        <div class="pres-header-wrapper4">
                                            <p>Total Quantity</p>
                                        </div>
                                        <div class="pres-header-wrapper5">
                                            <p>Remarks</p>
                                        </div>
                                    </div>
                                    <div class="pres-divider"></div>
                                    <div class="press-wrap">
                                        <div class="pres-body">
                                            <div class="pres-body-wrapper1 autocomplete-wrapper">
                                                <input type="text" required class="medication autocomplete-input"
                                                    name="medication_name[]">
                                                <input type="hidden" class="medication_id" name="medication_id[]">
                                            </div>
                                            <div class="pres-body-wrapper2 autocomplete-wrapper">
                                                <input type="text" required class="route autocomplete-input"
                                                    name="route_name[]">
                                                <input type="hidden" class="route_id" name="route_id[]">
                                            </div>
                                            <div class="pres-body-wrapper3">
                                                <input type="text" required name="dosage[]" class="dosage">
                                            </div>
                                            <div class="pres-body-wrapper4"><input type="text" required
                                                    name="quantity[]" class="total-quantity"></div>
                                            <div class="pres-body-wrapper5"><input name="remarks[]" required
                                                    type="text"></div>
                                            <div class="pres-body-wrapper6">
                                                <img src="/assets/cross.png" alt="cross" class="delete-row">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pres-divider"></div>
                                    <div class="pres-butto">
                                        <button style="all:unset;color:#fff;cursor: pointer;" type="button"
                                            class="add-medication-btn">Add Medication</button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="{{ encrypt($appointment->user->id) }}" name="pres_user_id" />
                            <input type="hidden" value="{{ encrypt($appointment->clinic_id) }}"
                                name="pres_clinic_id" />
                            <input type="hidden" value="{{ encrypt($appointment->doctor_id) }}"
                                name="pres_doctor_id" />
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            // Event listener for file input change
            $('#attachmentInput').on('change', function() {
                // Get the selected files
                const files = $(this)[0].files;

                // Loop through the selected files and display them
                $.each(files, function(index, file) {
                    const fileName = file.name;

                    const attachmentWrap = $('<div>').addClass('attachment-wrap');
                    const attachmentName = $('<span>').addClass('text-grey2 font-semibold text-16')
                        .text(fileName);
                    const removeButton = $('<button>').addClass('remove-attachment').text('X');

                    // Event listener for remove button click
                    removeButton.on('click', function() {
                        // Remove the attachment item
                        attachmentWrap.remove();
                    });

                    attachmentWrap.append(attachmentName, removeButton);
                    $('#attachmentList').append(attachmentWrap);
                });
            });
        });

        function initializeAutocomplete(element, sourceRoute, hiddenInput) {
            element.autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: sourceRoute,
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            response(data.map(item => ({
                                label: item.name,
                                value: item.id
                            })));
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    $(this).val(ui.item.label); // Display the name in the input
                    $(hiddenInput).val(ui.item.value); // Store the ID in the hidden input
                    return false;
                }
            });
        }

        // Initialize autocomplete for the initial rows
        initializeAutocomplete($(".medication"), "{{ route('medication.autocomplete') }}", ".medication_id");
        initializeAutocomplete($(".route"), "{{ route('route.autocomplete') }}", ".route_id");

        // Add new row on clicking 'Add Medication' button
        $('.add-medication-btn').click(function() {
            var newRow = $('.pres-body:first').clone();
            newRow.find('input').val('').attr('required', true); // Set required for all inputs in the new row
            newRow.find('.medication_id, .route_id').val(''); // Clear hidden inputs for IDs
            newRow.appendTo('.press-wrap');
            initializeAutocomplete(newRow.find('.medication'), "{{ route('medication.autocomplete') }}",
                ".medication_id");
            initializeAutocomplete(newRow.find('.route'), "{{ route('route.autocomplete') }}", ".route_id");
        });


        // Delete row on clicking cross icon
        $(document).on('click', '.delete-row', function() {
            var row = $(this).closest('.pres-body');
            if (row.index() !== 0) { // Check if the row is not the first one
                row.remove();
            }
        });

        $(document).on('input', '.total-quantity , .dosage', function() {
            var value = $(this).val();
            if (!/^[1-9]\d*$/.test(value)) { // Validates if the input is a positive integer greater than zero
                $(this).val(''); // Clears the input if the condition is not met
            }
        });
    </script>
@endsection
