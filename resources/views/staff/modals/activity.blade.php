<!-- ACTIVITY MODAL -->
<div class="detail-card hide model-content-activity">
    <div class="title-ref">
      <p class="text-grey2 text-22 font-bold">Patient Activity</p>
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
    <div class="details-note">
      <div class="activity-details-card">
        <div class="activity-card-header">
          <div>
            <span>Date:</span>
            <span>20 July 2023</span>
          </div>
          <div style="display: flex; align-items: center; gap: 10px">
            <button class="right-prescription">
              <div class="right-video-start">Prescription</div>
            </button>
            <button class="right-other">
              <img src="{{ asset('assets/images/description_black_24dp.svg') }}" alt="video-camera" style="width: 24px; height: 16px" />
              <div class="right-video-start">Other</div>
            </button>
            <button class="right-note">
              <img src="{{ asset('assets/images/history_edu_black_24dp.svg') }}" alt="video-camera" style="width: 24px; height: 16px" />
              <div class="right-video-start">Note</div>
            </button>
            <button class="right-ref">
              <img src="{{ asset('assets/images/email_black_24dp.svg') }}" alt="video-camera" style="width: 24px; height: 16px" />
              <div class="right-video-start">Referral Letter</div>
            </button>
          </div>
        </div>
        <div class="activity-card-body">
          <span>Questionnaire</span>
          <div class="activity-card-report-info">
            @for ($i = 0; $i < 6; $i++)
            <div>
              <span>Blood Glucose</span>
              <span>120 Mg/Dl</span>
            </div>
            @endfor
          </div>
          <div class="question-answers">
            <span>Please list all problems you want to address today?</span>
            <p>
              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ACTIVITY MODAL END -->
