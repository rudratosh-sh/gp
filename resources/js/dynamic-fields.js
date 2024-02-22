// resources/js/dynamic-fields.js

document.addEventListener('DOMContentLoaded', function () {
    const questionTypeField = document.querySelector('[name="questionV2[question_type_id]"]');
    const dynamicFieldContainer = document.querySelector('.dynamic-field-container');

    // Initially hide dynamic field container
    dynamicFieldContainer.style.display = 'none';

    questionTypeField.addEventListener('change', function () {
        const selectedType = questionTypeField.value;

        // Clear previous dynamic fields
        dynamicFieldContainer.innerHTML = '';

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
        // Create and append min and max input fields to the container
        const minField = document.createElement('input');
        minField.type = 'text';
        minField.name = 'questionV2[min]';
        minField.placeholder = 'Min';
        dynamicFieldContainer.appendChild(minField);

        const maxField = document.createElement('input');
        maxField.type = 'text';
        maxField.name = 'questionV2[max]';
        maxField.placeholder = 'Max';
        dynamicFieldContainer.appendChild(maxField);

        // Show dynamic field container
        dynamicFieldContainer.style.display = 'block';
    }

    function createMultipleChoiceFields() {
        // Create and append two option input fields to the container
        for (let i = 0; i < 2; i++) {
            const optionField = document.createElement('input');
            optionField.type = 'text';
            optionField.name = 'questionV2[options][' + i + ']';
            optionField.placeholder = 'Option ' + (i + 1);
            dynamicFieldContainer.appendChild(optionField);
        }

        // Create and append a button to add more options
        const addButton = document.createElement('button');
        addButton.type = 'button';
        addButton.textContent = '+ Add Option';
        addButton.addEventListener('click', function () {
            const newOptionField = document.createElement('input');
            newOptionField.type = 'text';
            newOptionField.name = 'questionV2[options][' + dynamicFieldContainer.children.length + ']';
            newOptionField.placeholder = 'Option ' + (dynamicFieldContainer.children.length + 1);
            dynamicFieldContainer.insertBefore(newOptionField, addButton);
        });

        dynamicFieldContainer.appendChild(addButton);

        // Show dynamic field container
        dynamicFieldContainer.style.display = 'block';
    }
});
