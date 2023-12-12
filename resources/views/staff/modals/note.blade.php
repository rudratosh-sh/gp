<div class="detail-card hide model-content-note">
    <div class="title-ref">
        <p class="text-grey2 text-22 font-bold">Note</p>
    </div>
    <div class="px-36 user-ref">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <p class="text-purple text-30 font-bold mr-15">Sean Rada</p>
                <p class="text-grey3 text-15 font-thin">
                    Male
                    <span class="ml-10">45</span>
                </p>
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
        <p class="text-grey2 text-18 font-normal mt-16">Presenting Complaints</p>
        @isset($presentingComplaints)
            <p class="text-grey2 text-base font-thin mt-8">{{ $presentingComplaints }}</p>
        @endisset

        <p class="text-grey2 text-18 font-normal mt-16">Relevant History</p>
        @isset($relevantHistory)
            <p class="text-grey2 text-base font-thin mt-8">{{ $relevantHistory }}</p>
        @endisset

        <p class="text-grey2 text-18 font-normal mt-16">Examination</p>
        @isset($examination)
            <p class="text-grey2 text-base font-thin mt-8">{{ $examination }}</p>
        @endisset

        <p class="text-grey2 text-18 font-normal mt-16">Recommendation</p>
        @isset($recommendation)
            <p class="text-grey2 text-base font-thin mt-8">{{ $recommendation }}</p>
        @endisset

        <p class="text-grey2 text-18 font-normal mt-16">Followup</p>
        @isset($followup)
            <p class="text-grey2 text-base font-thin mt-8">{{ $followup }}</p>
        @endisset

        <p class="text-grey2 text-18 font-normal mt-16">Personalization Framework</p>
        @isset($personalizationFramework)
            <p class="text-grey2 text-base font-thin mt-8">{{ $personalizationFramework }}</p>
        @endisset
    </div>
</div>
