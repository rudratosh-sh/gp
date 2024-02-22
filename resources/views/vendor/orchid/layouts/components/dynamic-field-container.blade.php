<!-- dynamic-field-container.blade.php -->

<fieldset class=" row g-0 mb-3">
    <div class="col p-0 px-3">
        <legend class="text-black px-2 mt-2">
        </legend>
    </div>
    <!-- Dynamic fields will be appended here -->
    <div class="col-12 col-md-7 shadow-sm">
        <div class="bg-white d-flex flex-column layout-wrapper rounded">
            <fieldset class="mb-3" data-async="">
                <div class="dynamic-field-container bg-white rounded shadow-sm p-4 py-4 d-flex flex-column">
                    {{-- <div class="form-group">
                        <label for="field-questionv2question-text-131ca045e75456acddf48ccc1c26c657229a9ce8"
                            class="form-label">Question Text
                            <sup class="text-danger">*</sup>

                        </label>

                        <div data-controller="input" data-input-mask="">
                            <input class="form-control" name="questionV2[question_text]" title="Question Text"
                                placeholder="Enter the Question Text" required="required"
                                id="field-questionv2question-text-131ca045e75456acddf48ccc1c26c657229a9ce8">
                        </div>

                    </div>

                    <div class="form-group">
                        <label
                            for="field-questionv2question-type-id-9762f297f8533f42fed201481ed3484c316be98c-ts-control"
                            class="form-label"
                            id="field-questionv2question-type-id-9762f297f8533f42fed201481ed3484c316be98c-ts-label">Question
                            Type
                            <sup class="text-danger">*</sup>

                        </label>

                        <div data-controller="select" data-select-placeholder="Select Question Type"
                            data-select-allow-empty="" data-select-message-notfound="No results found"
                            data-select-allow-add="false" data-select-message-add="Add">
                            <select class="form-control tomselected ts-hidden-accessible"
                                name="questionV2[question_type_id]" required="required" title="Question Type"
                                placeholder="Select Question Type"
                                id="field-questionv2question-type-id-9762f297f8533f42fed201481ed3484c316be98c"
                                tabindex="-1">


                                <option value="3">Multiple Choice Question with multiselect</option>
                                <option value="4">Input Answer</option>
                                <option value="1">Range</option>
                                <option value=""></option>
                                <option value="2">Multiple Choice Question</option>
                            </select>
                            <div
                                class="ts-wrapper form-control single plugin-change_listener required preloaded full has-items input-hidden">
                                <div class="ts-control">
                                    <div data-value="2" class="item" data-ts-item="">Multiple Choice Question</div>
                                    <input type="select-one" autocomplete="off" size="1" tabindex="0"
                                        role="combobox" aria-haspopup="listbox" aria-expanded="false"
                                        aria-controls="field-questionv2question-type-id-9762f297f8533f42fed201481ed3484c316be98c-ts-dropdown"
                                        id="field-questionv2question-type-id-9762f297f8533f42fed201481ed3484c316be98c-ts-control"
                                        aria-labelledby="field-questionv2question-type-id-9762f297f8533f42fed201481ed3484c316be98c-ts-label"
                                        placeholder="Select Question Type"
                                        aria-activedescendant="field-questionv2question-type-id-9762f297f8533f42fed201481ed3484c316be98c-opt-2">
                                </div>
                                <div class="ts-dropdown single plugin-change_listener"
                                    style="display: none; visibility: visible;">
                                    <div role="listbox" tabindex="-1" class="ts-dropdown-content"
                                        id="field-questionv2question-type-id-9762f297f8533f42fed201481ed3484c316be98c-ts-dropdown"
                                        aria-labelledby="field-questionv2question-type-id-9762f297f8533f42fed201481ed3484c316be98c-ts-label">
                                        <div data-selectable="" data-value="1" class="option" role="option"
                                            id="field-questionv2question-type-id-9762f297f8533f42fed201481ed3484c316be98c-opt-1">
                                            Range</div>
                                        <div data-selectable="" data-value="2" class="option active selected"
                                            role="option"
                                            id="field-questionv2question-type-id-9762f297f8533f42fed201481ed3484c316be98c-opt-2"
                                            aria-selected="true">Multiple Choice Question</div>
                                        <div data-selectable="" data-value="3" class="option" role="option"
                                            id="field-questionv2question-type-id-9762f297f8533f42fed201481ed3484c316be98c-opt-3">
                                            Multiple Choice Question with multiselect</div>
                                        <div data-selectable="" data-value="4" class="option" role="option"
                                            id="field-questionv2question-type-id-9762f297f8533f42fed201481ed3484c316be98c-opt-4">
                                            Input Answer</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <small class="form-text text-muted">Select the type of question to display additional fields
                            accordingly.</small>
                    </div> --}}
                </div>
            </fieldset>

        </div>
    </div>
</fieldset>
