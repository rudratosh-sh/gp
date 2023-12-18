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
            <div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="{{route("doctor.dashboard.get")}}">
                            <img class="pointer" width="40px" height="40px" src="/assets/images/arrow-left-purple.svg"
                                alt="">
                        </a>
                        <p class="text-grey2 text-22 font-bold ml-10">Patient Details</p>
                    </div>
                    <div class="flex">
                        <div onclick="navigateToPage('/gp/create-prescription.html')"
                            class="flex items-center justify-center patient-detail-btn-green">
                            <p class="text-white text-base">Create Prescription</p>
                        </div>
                        <div onclick="navigateToPage('/gp/other.html')"
                            class="flex items-center justify-center patient-detail-btn ml-10">
                            <p class="text-white text-base">Other</p>
                        </div>
                        <div onclick="navigateToPage('/gp/note.html')"
                            class="flex items-center justify-center patient-detail-btn ml-10">
                            <p class="text-white text-base">Create Note</p>
                        </div>
                        <div onclick="navigateToPage('/gp/create-referral-letter.html')"
                            class="flex items-center justify-center patient-detail-btn ml-10">
                            <p class="text-white text-base">Create Referral Later</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white detail-left-first mt-24">
                    <div class="px-12">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <p class="text-purple text-30 font-bold mr-15">{{ $appointment->user->name }}</p>
                                <p class="text-grey3 text-15 font-thin">
                                    Male
                                    <span
                                        class="ml-10">{{ \Carbon\Carbon::parse($appointment->medicareDetail->birthdate)->age . ' Years' }}</span>
                                </p>
                            </div>
                            <img class="pointer right-messages openChatModel" width="28px" height="28px"
                                src="/assets/images/messages.svg" alt="">
                        </div>
                        <div class="flex items-center mt-16">
                            <p class="text-grey3 text-xs font-thin">
                                Contact:
                                <span
                                    class="font-normal">{{ $appointment->user->country_code . '-' . $appointment->user->mobile }}</span>
                            </p>
                            <p class="text-grey3 text-xs font-thin ml-30">
                                Medicare No. :
                                <span class="font-normal">{{ $appointment->medicareDetail->medicare_number }}</span>
                            </p>
                            <p class="text-grey3 text-xs font-thin ml-30">
                                Last Visited:
                                <span class="font-normal">{{ $appointment->last_visited }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="flex">
                        <img class="pointer" width="25px" height="25px" src="/assets/images/vital.svg" alt="">
                        <p class="text-grey4 text-18 font-bold ml-10">Vitals</p>
                    </div>
                    <div class="flex mt-24">
                        <?php $index = 0; ?>
                        @foreach ($appointment->patientVitalValues as $ptKey => $ptValue)
                            @if ($ptValue->clinicVital->vital->type == 'text')
                                @if ($index == 0)
                                    <div class="vital-first-nw">
                                        <div>
                                            <p class="text-grey3 text-xs font-normal mb-10">
                                                {{ $ptValue->clinicVital->vital->name }}</p>
                                            <p class="text-grey4 text-20 font-bold">
                                                {{ strtok($ptValue->value, ' ') }}
                                                <span
                                                    class="text-grey3 text-xs font-semibold">{{ strstr($ptValue->value, ' ') }}</span>
                                                <span class="text-grey3 text-xs font-normal">
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex justify-center vital-data">
                                        <div>
                                            <p class="text-grey3 text-xs font-normal mb-10">
                                                {{ $ptValue->clinicVital->vital->name }}</p>
                                            <p class="text-grey4 text-20 font-bold">
                                                {{ strtok($ptValue->value, ' ') }}
                                                <span
                                                    class="text-grey3 text-xs font-semibold">{{ strstr($ptValue->value, ' ') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            <?php $index++; ?>
                        @endforeach
                    </div>
                </div>
                <div class="detail-left-second bg-white">
                    <div class="mt-36">
                        <p class="text-grey5 text-20 font-semibold">
                            Please list all problem you want to address today?
                        </p>
                        <p class="text-grey3 text-16 font-thin mt-6">
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
                        <p class="text-grey3 text-16 font-thin mt-6">
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
                        <p class="text-grey3 text-16 font-thin mt-6">
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
                            Is there is anything you are concerned it might be?
                        </p>
                        <p class="text-grey3 text-16 font-thin mt-6">
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
                            What would you like o achieve from your appointment today?
                        </p>
                        <p class="text-grey3 text-16 font-thin mt-6">
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
        </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
