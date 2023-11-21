<div class="detail-card hide model-content">
    <div class="title-ref">
        <p class="text-grey2 text-22 font-bold">Referral Letter</p>
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
            <p class="text-grey3 text-xs font-thin">
                Contact:
                <span class="font-normal">1234567890</span>
            </p>
            <p class="text-grey3 text-xs font-thin ml-30">
                Medicare No. :
                <span class="font-normal">5336 5336 5336 5336</span>
            </p>
            <p class="text-grey3 text-xs font-thin ml-30">
                Last Visited:
                <span class="font-normal">24/04/2023</span>
            </p>
        </div>
    </div>
    <div class="details-ref px-36 py-20">
        <p class="text-grey2 text-xs font-normal">Date: August 18, 2022</p>
        <p class="text-grey2 text-xs font-normal mt-16">
            To
            @isset($date)
            <p class="text-grey2 text-xs font-normal">Date: {{ $date }}</p>
        @endisset

        @isset($ATTN)
            <p class="text-grey2 text-xs font-normal mt-16">
                To
                <br />
                {{ $ATTN }}
            </p>
        @endisset

        @isset($ADDRESS)
            <p class="text-grey2 text-xs font-normal">
                {{ $ADDRESS }}
            </p>
        @endisset

        @isset($POSTAL_CODE)
            <p class="text-grey2 text-xs font-normal">
                {{ $POSTAL_CODE }}
            </p>
        @endisset

        @isset($COUNTRY)
            <p class="text-grey2 text-xs font-normal">
                {{ $COUNTRY }}
            </p>
        @endisset
        </p>
        <p class="text-grey2 text-xs font-bold mt-16">
            Subject
            <span class="font-normal">Letter of Medical Necessity</span>
        </p>
        <p class="text-grey2 text-xs font-normal mt-16">
            To Whome It May Concern / Dear Dr,
        </p>
        <!-- Rest of the content... -->
    </div>
</div>
