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
      <p class="text-grey2 text-18 font-normal mt-16">
        Presenting Complaints
      </p>
      <p class="text-grey2 text-base font-thin mt-8">
        Lorem Ipsum is simply dummy text of the printing and typesetting
        industry. Lorem Ipsum has been the industry’s standard dummy text
        ever since the 1500s, when an unknown printer took a galley of type
        and scrambled it to make a type specimen book. It has survived not
        only five centuries, but also the leap
      </p>
      <p class="text-grey2 text-18 font-normal mt-16">Relevant History</p>
      <p class="text-grey2 text-base font-thin mt-8">
        Lorem Ipsum is simply dummy text of the printing and typesetting
        industry. Lorem Ipsum has been the industry’s standard dummy text
        ever since the 1500s, when an unknown printer took a galley of type
        and scrambled it to make a type specimen book. It has survived not
        only five centuries, but also the leap
      </p>
      <p class="text-grey2 text-18 font-normal mt-16">Examination</p>
      <p class="text-grey2 text-base font-thin mt-8">
        Lorem Ipsum is simply dummy text of the printing and typesetting
        industry. Lorem Ipsum has been the industry’s standard dummy text
        ever since the 1500s, when an unknown printer took a galley of type
        and scrambled it to make a type specimen book. It has survived not
        only five centuries, but also the leap
      </p>
      <p class="text-grey2 text-18 font-normal mt-16">Recommendation</p>
      <p class="text-grey2 text-base font-thin mt-8">
        Lorem Ipsum is simply dummy text of the printing and typesetting
        industry. Lorem Ipsum has been the industry’s standard dummy text
        ever since the 1500s, when an unknown printer took a galley of type
        and scrambled it to make a type specimen book. It has survived not
        only five centuries, but also the leap
      </p>
      <p class="text-grey2 text-18 font-normal mt-16">Followup</p>
      <p class="text-grey2 text-base font-thin mt-8">
        Lorem Ipsum is simply dummy text of the printing and typesetting
        industry. Lorem Ipsum has been the industry’s standard dummy text
        ever since the 1500s, when an unknown printer took a galley of type
        and scrambled it to make a type specimen book. It has survived not
        only five centuries, but also the leap
      </p>
      <p class="text-grey2 text-18 font-normal mt-16">
        Personalization Framework
      </p>
      <p class="text-grey2 text-base font-thin mt-8">
        Lorem Ipsum is simply dummy text of the printing and typesetting
        industry. Lorem Ipsum has been the industry’s standard dummy text
        ever since the 1500s, when an unknown printer took a galley of type
        and scrambled it to make a type specimen book. It has survived not
        only five centuries, but also the leap
      </p>
    </div>
  </div>
