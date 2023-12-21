    <div class="detail-card hide model-content-other">
        <div class="title-ref">
        <p class="text-grey2 text-22 font-bold">Other Information</p>
        </div>
        <div class="px-36 user-ref">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
            <p class="text-purple text-30 font-bold mr-15">{{$user->name}}</p>
            <p class="text-grey3 text-15 font-thin">
                {{$medicareDetail->gender}}
                <span class="ml-10">{{ \Carbon\Carbon::parse($medicareDetail->birthdate)->age . ' Years' }}</span>
            </p>
            </div>
        </div>
        <div class="flex items-center mt-16">
            <p class="text-grey3 text-xs font-thin">
            Contact:
            <span class="font-normal">{{ $appointment->user->country_code . '-' . $appointment->user->mobile }}</span>
            </p>
            <p class="text-grey3 text-xs font-thin ml-30">
            Medicare No. :
            <span class="font-normal">{{$medicareDetail->medicare_number
            }}</span>
            </p>
            <p class="text-grey3 text-xs font-thin ml-30">
            Last Visited:
            <span class="font-normal">{{$appointment->last_visited}}</span>
            </p>
        </div>
        </div>
        <div class="details-note">
            <p class="text-grey2 text-18 font-normal mt-16">Presenting Complaints</p>
            @isset($appointment->otherInfo->presenting_complaints)
                <p class="text-grey2 text-base font-thin mt-8">{{ $appointment->otherInfo->presenting_complaints }}</p>
            @endisset

            <p class="text-grey2 text-18 font-normal mt-16">Relevant History</p>
            @isset($appointment->otherInfo->relevant_history)
                <p class="text-grey2 text-base font-thin mt-8">{{ $appointment->otherInfo->relevant_history }}</p>
            @endisset

            <p class="text-grey2 text-18 font-normal mt-16">Examination</p>
            @isset($appointment->otherInfo->examination)
                <p class="text-grey2 text-base font-thin mt-8">{{ $appointment->otherInfo->examination }}</p>
            @endisset

            <p class="text-grey2 text-18 font-normal mt-16">Recommendation</p>
            @isset($appointment->otherInfo->recommendation)
                <p class="text-grey2 text-base font-thin mt-8">{{ $appointment->otherInfo->recommendation }}</p>
            @endisset

            <p class="text-grey2 text-18 font-normal mt-16">Followup</p>
            @isset($appointment->otherInfo->followup)
                <p class="text-grey2 text-base font-thin mt-8">{{ $appointment->otherInfo->followup }}</p>
            @endisset

            <p class="text-grey2 text-18 font-normal mt-16">Personalization Framework</p>
            @isset($appointment->otherInfo->personalization_framework)
                <p class="text-grey2 text-base font-thin mt-8">{{ $appointment->otherInfo->personalization_framework }}</p>
            @endisset
        </div>
    </div>
