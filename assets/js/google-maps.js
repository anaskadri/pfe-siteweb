let map;

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 34.246211, lng: -6.588280 },
    zoom: 8
  });
}