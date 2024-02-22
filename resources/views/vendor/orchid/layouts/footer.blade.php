<p class="small m-n">
    © Copyright {{ date('Y') }}
    <a href="//example.com" target="_blank">Super GP</a>
</p>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://tom-select.js.org/js/tom-select.complete.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" /><!-- Select2 JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>{{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1R_Q4VawPY6mXA8qArh-eBUNykQODja4&libraries=places&callback=initialize"></script> --}}
<style type="text/css">
    #post-form {
        height: 100%;
    }
</style>
<script>
    $(document).ready(function() {
        initialize();
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Find the initial element with data-controller="listener"
        var targetElement = document.querySelector('[data-controller="listener"]');

        // Apply the class initially
        applyClass(targetElement);

        // Create a MutationObserver
        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                // Check if the mutation involves nodes being added
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    // Apply the class to the added nodes
                    // mutation.addedNodes.forEach(function(addedNode) {
                    //     if (addedNode.nodeType === 1 && addedNode.matches(
                    //             '[data-controller="listener"]
                    //         ')) {
                    //         applyClass(addedNode);
                    //     }
                    // });
                    mutation.addedNodes.forEach(function(addedNode) {
                        if (addedNode.nodeType === 1 && addedNode.matches(
                                '[data-controller="listener"]')) {
                            applyClass(addedNode);
                        }
                    });

                }
            });
        });

        // Configure and start the observer to watch for changes in the subtree
        observer.observe(document.body, {
            subtree: true,
            childList: true
        });
    });

    function applyClass(element) {
        // Check if the element is found
        if (element) {
            // Add your desired classes to the element
            element.classList.add('offset-5', 'col-12', 'col-md-7', 'shadow-sm');
        }
    }

    $(document).ready(function() {
        const questionTypeField = $('[name="questionV2[question_type_id]"]');
        const dynamicFieldContainer = $('.dynamic-field-container');

        // Initially hide dynamic field container
        dynamicFieldContainer.hide();

        questionTypeField.change(function() {
            const selectedType = questionTypeField.val();
            // Clear previous dynamic fields
            dynamicFieldContainer.html('');

            // Show dynamic field container based on selected question type
            if (selectedType == 1) { // Range
                createRangeFields();
            } else if (selectedType == 2 || selectedType == 3) { // Multiple Choice
                createMultipleChoiceFields();
            } else if (selectedType == 4) { // Input Answer
                // No dynamic field to show
            }
        });

        function createRangeFields() {
            // Create and append min and max input fields to the container with Orchid styling
            dynamicFieldContainer.append(
                '<div class="form-group"><label class="form-label">Min</label><div data-controller="input" data-input-mask=""><input class="form-control" type="text" name="questionV2[min]" placeholder="Min"></div></div>'
            );
            dynamicFieldContainer.append(
                '<div class="form-group"><label class="form-label">Max</label><div data-controller="input" data-input-mask=""><input class="form-control" type="text" name="questionV2[max]" placeholder="Max"></div></div>'
            );

            // Show dynamic field container
            dynamicFieldContainer.show();
        }

        function createMultipleChoiceFields() {
            // Create and append a button to add more options
            dynamicFieldContainer.append(`
        <div class="form-group mb-0">
            <button type="button" onclick="addOptionField(true)" class="btn btn-link" data-controller="button" data-turbo="true">
                <svg class="w-[17px] h-[17px] text-gray-800 dark:text-white" style=" height: 16px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 7.8v8.4M7.8 12h8.4m4.8 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg><span>Add Option</span>
            </button>
        </div>
    `);

            // Show dynamic field container
            dynamicFieldContainer.show();
            console.log('dynamicFieldContainer.children().length', dynamicFieldContainer.children().length)
            // Call addOptionField to ensure that initial fields are populated
            addOptionField(false); // Initial option field 3
            addOptionField(false); // Initial option field 4

            // Show dynamic field container
            dynamicFieldContainer.show();

        }


        // Function to add a new option field
        window.addOptionField = function(allowRemoval) {
            // Create and append a new option input field to the container with Orchid styling
            const newOptionField = $(`
            <div class="form-group option-field">
                <label class="form-label">Option ${dynamicFieldContainer.children().length + 0}</label>
                <div data-controller="input" data-input-mask="">
                    <input class="form-control" type="text" name="questionV2[options][${dynamicFieldContainer.children().length}]" placeholder="Option ${dynamicFieldContainer.children().length + 0}">
                </div>
                ${allowRemoval ? `
                    <button type="button" onclick="removeOptionField(this)" class="btn btn-link text-danger" data-controller="button" data-turbo="true">
                        <svg class="w-[17px] h-[17px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>Remove</span>
                    </button>
                ` : ''}
            </div>
        `);

            dynamicFieldContainer.children().last().before(newOptionField);
        }

        // Function to remove the corresponding option field
        window.removeOptionField = function(button) {
            $(button).closest('.option-field').remove();
        }

        // $('#auto_select_clinic_id').change(function($e) {
        //     updateDoctorsList($e);
        // });

        // function updateDoctorsList(event) {
        //     const clinicId = event.target.value;

        //     // Make an AJAX request to fetch doctors based on the selected clinic
        //     axios.get(`/get-doctors/${clinicId}`)
        //         .then(response => {
        //             const doctorsSelect = $('#auto_select_doctor_id');

        //             // Clear previous options
        //             doctorsSelect.empty();

        //             // Add new options based on the response
        //             response.data.forEach(doctor => {
        //                 doctorsSelect.append($('<option>').val(doctor.user_id).text(doctor.user
        //                     .name));
        //             });

        //             // Initialize Select2
        //             doctorsSelect.select2({
        //                 placeholder: "Select a doctor", // Placeholder text
        //                 allowClear: true, // Option to clear selection
        //                 // Additional options as needed
        //             });

        //             // Trigger the change event for Select2 to update its UI
        //             doctorsSelect.trigger('change');
        //         })
        //         .catch(error => {
        //             console.error('Error fetching doctors:', error);
        //         });
        // }

    });
</script>
