<!-- dynamic-doctor.blade.php -->

<fieldset class=" row g-0 mb-3">
    <div class="col p-0 px-3">
        <legend class="text-black px-2 mt-2">
        </legend>
    </div>
    <!-- Dynamic fields will be appended here -->
    <div class="col-12 col-md-7 shadow-sm">
        <div class="bg-white d-flex flex-column layout-wrapper rounded">
            <fieldset class="mb-3" data-async="">
                <div class="dynamic-doctor bg-white rounded shadow-sm p-4 py-4 d-flex flex-column">
                    <select class="form-control" multiple="multiple" name="doctor[user_id]" id="auto_select_doctor_id" title="Name"
                        placeholder="Doctor Name">
                        <option>Select Doctor</option>
                    </select>
                </div>
            </fieldset>
        </div>
    </div>
</fieldset>
