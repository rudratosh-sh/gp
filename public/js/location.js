function getCurrentLocation() {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const currentLatitude = position.coords.latitude;
                const currentLongitude = position.coords.longitude;

                // Get clinic's latitude and longitude from the hidden inputs
                const clinicLatitude =
                    document.getElementById("clinicLatitude").value;
                const clinicLongitude =
                    document.getElementById("clinicLongitude").value;

                // Calculate the distance
                const distanceInKms = calculateDistance(
                    currentLatitude,
                    currentLongitude,
                    clinicLatitude,
                    clinicLongitude
                );

                console.log('distanceInKms',distanceInKms)
                // Update the HTML element with the distance
                document.getElementById(
                    "distance-from-clinic"
                ).innerText = `Distance: ${Number((distanceInKms).toFixed(2))} km`;
            },
            function (error) {
                console.error("Error getting location:", error.message);
            }
        );
    } else {
        console.error("Geolocation is not available");
    }
}

getCurrentLocation();

function calculateDistance(currentLat, currentLng, clinicLat, clinicLng) {
    const earthRadiusKm = 6371;

    const dLat = degreesToRadians(clinicLat - currentLat);
    const dLng = degreesToRadians(clinicLng - currentLng);

    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(degreesToRadians(currentLat)) *
            Math.cos(degreesToRadians(clinicLat)) *
            Math.sin(dLng / 2) *
            Math.sin(dLng / 2);

    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const distance = earthRadiusKm * c;

    return distance;
}

function degreesToRadians(degrees) {
    return (degrees * Math.PI) / 180;
}
