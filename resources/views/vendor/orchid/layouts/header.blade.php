@push('head')
    <!-- Include the Google Maps JavaScript API with Places library -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD21xJxqBgHKLqM_k2IBeQ95ZUupe08yoE&libraries=places">
    </script>
    <!-- Include your custom JavaScript -->
    <script>
        function initialize() {
            var input = document.getElementById('clinic-Address');
            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    // If no geometry, clear the input
                    input.value = '';
                } else {
                    console.log('Selected place:', place);
                    document.getElementById('clinic-latitude').value = place.geometry.location.lat();
                    document.getElementById('clinic-longitude').value = place.geometry.location.lng();

                    // Extract city, state, and country from address components
                    var city = '';
                    var state = '';
                    var country = '';

                    place.address_components.forEach(function(component) {
                        if (component.types.includes('locality')) {
                            city = component.long_name;
                        } else if (component.types.includes('administrative_area_level_1')) {
                            state = component.long_name;
                        } else if (component.types.includes('country')) {
                            country = component.long_name;
                        }
                    });

                    // Assign the values to the clinic-location element
                    document.getElementById('clinic-location').value = city + ', ' + state + ', ' + country;
                }
            });
        }
    </script>
@endpush


<p class="h2 n-m font-thin v-center">

    <span class="m-l d-none d-sm-block">
        <img src="{{ asset('storage/system/logo.png') }}" alt="GP ADMIN" style="width: 100%; height: 100%;" />
    </span>
</p>
