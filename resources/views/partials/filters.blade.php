<div class="row">
    <div class="col">
        <x-orchid-input :placeholder="__('Filter by Section')" :value="$attributes['filter.section_id']" :name="'filter.section_id'" :id="'filter-section-id'" />
    </div>
    <div class="col">
        <x-orchid-input :placeholder="__('Filter by Question Text')" :value="$attributes['filter.question_text']" :name="'filter.question_text'" :id="'filter-question-text'" />
    </div>
    <div class="col">
        <x-orchid-input :placeholder="__('Filter by Order')" :value="$attributes['filter.order']" :name="'filter.order'" :id="'filter-order'" />
    </div>
</div>
