<div class="detail-card hide model-content">
    <div class="title-ref">
        <p class="text-grey2 text-22 font-bold">Referral Letter</p>
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
    <div class="details-ref px-36 py-20">
        <p class="text-grey2 text-xs font-normal">Date: {{ date('l jS F Y', strtotime($appointment->refLetter->date)) }}
        </p>
        @isset($appointment->refLetter->refer_to)
            <p class="text-grey2 text-xs font-normal mt-16">
                To
                <br />
                {{ $appointment->refLetter->refer_to }}
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
            <span class="font-normal">{{$appointment->refLetter->subject}}</span>
        </p>
        <p class="text-grey2 text-xs font-normal text-justify">
            {{$appointment->refLetter->content}}
        </p>
        <!-- Rest of the content... -->
    </div>
</div>
