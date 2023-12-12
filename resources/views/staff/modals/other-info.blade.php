<div class="detail-card hide model-content-other">
    <div class="title-ref">
        <p class="text-grey2 text-22 font-bold">Other Information</p>
    </div>
    <div class="px-36 user-ref">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                @isset($name)
                    <p class="text-purple text-30 font-bold mr-15">{{ $name }}</p>
                @endisset

                @isset($gender, $age)
                    <p class="text-grey3 text-15 font-thin">
                        {{ $gender }}
                        <span class="ml-10">{{ $age }}</span>
                    </p>
                @endisset
            </div>
        </div>
        <div class="flex items-center mt-16">
            @isset($contact)
                <p class="text-grey3 text-xs font-thin">
                    Contact:
                    <span class="font-normal">{{ $contact }}</span>
                </p>
            @endisset

            @isset($medicareNo)
                <p class="text-grey3 text-xs font-thin ml-30">
                    Medicare No. :
                    <span class="font-normal">{{ $medicareNo }}</span>
                </p>
            @endisset

            @isset($lastVisited)
                <p class="text-grey3 text-xs font-thin ml-30">
                    Last Visited:
                    <span class="font-normal">{{ $lastVisited }}</span>
                </p>
            @endisset
        </div>
    </div>
    <div class="details-note">
        @isset($presentingComplaints)
            <p class="text-grey2 text-18 font-normal mt-16">Presenting Complaints</p>
            <p class="text-grey2 text-base font-thin mt-8">{{ $presentingComplaints }}</p>
        @endisset

        @isset($relevantHistory)
            <p class="text-grey2 text-18 font-normal mt-16">Relevant History</p>
            <p class="text-grey2 text-base font-thin mt-8">{{ $relevantHistory }}</p>
        @endisset

        @isset($examination)
            <p class="text-grey2 text-18 font-normal mt-16">Examination</p>
            <p class="text-grey2 text-base font-thin mt-8">{{ $examination }}</p>
        @endisset

        @isset($recommendation)
            <p class="text-grey2 text-18 font-normal mt-16">Recommendation</p>
            <p class="text-grey2 text-base font-thin mt-8">{{ $recommendation }}</p>
        @endisset

        @isset($followup)
            <p class="text-grey2 text-18 font-normal mt-16">Followup</p>
            <p class="text-grey2 text-base font-thin mt-8">{{ $followup }}</p>
        @endisset

        @isset($personalizationFramework)
            <p class="text-grey2 text-18 font-normal mt-16">Personalization Framework</p>
            <p class="text-grey2 text-base font-thin mt-8">{{ $personalizationFramework }}</p>
        @endisset
    </div>
</div>
