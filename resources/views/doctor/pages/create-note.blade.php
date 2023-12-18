@extends('doctor.layouts.doctor-layout', ['active' => 'history'])
@section('content')
    <style>
        .right-hr {
            border-right: 1px solid black;
            width: 45px;
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
                <form method="POST" action="{{ route('doctor.create.note.post') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img width="24px" height="24px" src="/assets/images/create-letter.svg" alt="" />
                            <p class="text-grey2 text-20 font-bold ml-10">Create Note</p>
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
                            <div class="mt-36">
                                <p class="text-grey2 text-xs font-normal">
                                    Presenting Complaints
                                </p>
                                <textarea class="input text-grey2 text-xs font-normal" placeholder="Type Here" name="presenting_complaints">{{ optional($appointment->notes)->presenting_complaints }}                                </textarea>
                            </div>
                            <div class="mt-36">
                                <p class="text-grey2 text-xs font-normal">Relevant History</p>
                                <textarea class="input text-grey2 text-xs font-normal" placeholder="Type Here" name="relevant_history">{{ optional($appointment->notes)->relevant_history }} </textarea>
                            </div>

                            <div class="mt-36">
                                <p class="text-grey2 text-xs font-normal">Examination</p>
                                <textarea class="input text-grey2 text-xs font-normal" placeholder="Type Here" name="examination">{{ optional($appointment->notes)->examination }} </textarea>
                            </div>

                            <div class="mt-36">
                                <p class="text-grey2 text-xs font-normal">Recommendation</p>
                                <textarea class="input text-grey2 text-xs font-normal" placeholder="Type Here" name="recommendation">{{ optional($appointment->notes)->recommendation }} </textarea>
                            </div>

                            <div class="mt-36">
                                <p class="text-grey2 text-xs font-normal">Followup</p>
                                <textarea class="input text-grey2 text-xs font-normal" placeholder="Type Here" name="followup">{{ optional($appointment->notes)->followup }} </textarea>
                            </div>

                            <div class="mt-36">
                                <p class="text-grey2 text-xs font-normal">
                                    Personalization Framework
                                </p>
                                <textarea class="input text-grey2 text-xs font-normal" placeholder="Type Here" name="personalization_framework">{{ optional($appointment->notes)->personalization_framework }} </textarea>
                            </div>
                            <input type="hidden" value="{{ encrypt($appointment->user->id) }}" name="note_user_id" />
                            <input type="hidden" value="{{ encrypt($appointment->clinic_id) }}"
                                name="note_clinic_id" />
                            <input type="hidden" value="{{ encrypt($appointment->doctor_id) }}"
                                name="note_doctor_id" />

                            <div id="attachmentList" class="mt-36 flx flex-col row-gap-10">
                                @if (count($attachments) > 0)
                                    @foreach ($attachments as $attach)
                                        <div class="attachment-wrap"><span
                                                class="text-grey2 font-semibold text-16">{{ $attach->name }}</span>
                                        </div>
                            </div>
                            @endforeach
                            @endif
                        </div>

                        <div class="flex items-center justify-between mt-36">
                            <p class="text-grey2 text-20 font-thin">
                                {{ $user->name }}
                                <br />
                                {Signature}
                                <br />
                                {Dr. Physician name}
                            </p>
                            <!-- Attachment button -->
                            <div>
                                <input style="visibility: hidden;" type="file" id="attachmentInput"
                                    accept=".pdf, .doc, .docx, .jpg, .png" name="attachments[]" multiple />
                                <label for="attachmentInput">
                                    <img style="cursor: pointer;" width="45px" height="58px"
                                        src="/assets/images/attachment.png" alt="" />
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
    </script>
@endsection
