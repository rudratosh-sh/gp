<div class="detail-card hide model-content-note">
    <div class="title-ref">
        <p class="text-grey2 text-22 font-bold">Note</p>
    </div>
    <div class="px-36 user-ref">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <p class="text-purple text-30 font-bold mr-15">{{ $user->name }}</p>
                <p class="text-grey3 text-15 font-thin">
                    {{ $medicareDetail->gender }}
                    <span class="ml-10">{{ \Carbon\Carbon::parse($medicareDetail->birthdate)->age . ' Years' }}</span>
                </p>
            </div>
        </div>
        <div class="flex items-center mt-16">
            <p class="text-grey3 text-xs font-thin">
                Contact:
                <span
                    class="font-normal">{{ $appointment->user->country_code . '-' . $appointment->user->mobile }}</span>
            </p>
            <p class="text-grey3 text-xs font-thin ml-30">
                Medicare No. :
                <span class="font-normal">{{ $medicareDetail->medicare_number }}</span>
            </p>
            <p class="text-grey3 text-xs font-thin ml-30">
                Last Visited:
                <span class="font-normal">{{ $appointment->last_visited }}</span>
            </p>
        </div>
    </div>
    <div class="details-note">
        <p class="text-grey2 text-18 font-normal mt-16">Presenting Complaints</p>
        @isset($appointment->notes->presenting_complaints)
            <p class="text-grey2 text-base font-thin mt-8">{{ $appointment->notes->presenting_complaints }}</p>
        @endisset

        <p class="text-grey2 text-18 font-normal mt-16">Relevant History</p>
        @isset($appointment->notes->relevant_history)
            <p class="text-grey2 text-base font-thin mt-8">{{ $appointment->notes->relevant_history }}</p>
        @endisset

        <p class="text-grey2 text-18 font-normal mt-16">Examination</p>
        @isset($appointment->notes->examination)
            <p class="text-grey2 text-base font-thin mt-8">{{ $appointment->notes->examination }}</p>
        @endisset

        <p class="text-grey2 text-18 font-normal mt-16">Recommendation</p>
        @isset($appointment->notes->recommendation)
            <p class="text-grey2 text-base font-thin mt-8">{{ $appointment->notes->recommendation }}</p>
        @endisset

        <p class="text-grey2 text-18 font-normal mt-16">Followup</p>
        @isset($appointment->notes->followup)
            <p class="text-grey2 text-base font-thin mt-8">{{ $appointment->notes->followup }}</p>
        @endisset

        <p class="text-grey2 text-18 font-normal mt-16">Personalization Framework</p>
        @isset($appointment->notes->personalization_framework)
            <p class="text-grey2 text-base font-thin mt-8">{{ $appointment->notes->personalization_framework }}</p>
        @endisset
    </div>
</div>
