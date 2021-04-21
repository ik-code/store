// google map
const map_lat = 57.72701,
map_lng = 12.922516;
function initMap() {
  var mapPage = document.querySelector('#map');

  if (mapPage) {
    var mapCenter = {
      lat: map_lat,
      lng: map_lng
    };
    var map = new google.maps.Map(document.getElementById('map'), {
      center: mapCenter,
      zoom: 13,
      disableDefaultUI: true,
      styles: [{
        elementType: 'geometry',
        stylers: [{
          color: '#f5f5f5'
        }]
      },
      {
        elementType: 'labels.icon',
        stylers: [{
          visibility: 'off'
        }]
      },
      {
        elementType: 'labels.text.fill',
        stylers: [{
          color: '#616161'
        }]
      },
      {
        elementType: 'labels.text.stroke',
        stylers: [{
          color: '#f5f5f5'
        }]
      },
      {
        featureType: 'administrative.land_parcel',
        elementType: 'labels.text.fill',
        stylers: [{
          color: '#bdbdbd'
        }]
      },
      {
        featureType: 'poi',
        elementType: 'geometry',
        stylers: [{
          color: '#eeeeee'
        }]
      },
      {
        featureType: 'poi',
        elementType: 'labels.text.fill',
        stylers: [{
          color: '#757575'
        }]
      },
      {
        featureType: 'poi.park',
        elementType: 'geometry',
        stylers: [{
          color: '#e5e5e5'
        }]
      },
      {
        featureType: 'poi.park',
        elementType: 'labels.text.fill',
        stylers: [{
          color: '#9e9e9e'
        }]
      },
      {
        featureType: 'road',
        elementType: 'geometry',
        stylers: [{
          color: '#ffffff'
        }]
      },
      {
        featureType: 'road.arterial',
        elementType: 'labels.text.fill',
        stylers: [{
          color: '#757575'
        }]
      },
      {
        featureType: 'road.highway',
        elementType: 'geometry',
        stylers: [{
          color: '#dadada'
        }]
      },
      {
        featureType: 'road.highway',
        elementType: 'labels.text.fill',
        stylers: [{
          color: '#616161'
        }]
      },
      {
        featureType: 'road.local',
        elementType: 'labels.text.fill',
        stylers: [{
          color: '#9e9e9e'
        }]
      },
      {
        featureType: 'transit.line',
        elementType: 'geometry',
        stylers: [{
          color: '#e5e5e5'
        }]
      },
      {
        featureType: 'transit.station',
        elementType: 'geometry',
        stylers: [{
          color: '#eeeeee'
        }]
      },
      {
        featureType: 'water',
        elementType: 'geometry',
        stylers: [{
          color: '#c9c9c9'
        }]
      },
      {
        featureType: 'water',
        elementType: 'labels.text.fill',
        stylers: [{
          color: '#9e9e9e'
        }]
      }
      ]
    });
    var markerImg = '/wp-content/themes/clicknstore/images/icons/map-pin.svg';
    var marker = new google.maps.Marker({
      position: mapCenter,
      map: map,
      icon: markerImg
    });

    var contentString = '<div class="marker-tooltip__container">' +
    '<div class="marker-tooltip__title">' +
    'Click N Store Borås' +
    '</div>' +
    '<p class="marker-tooltip__description">' +
    'Getängsvägen 6 <br />504 68 Borås <br />031 - 99 00 69' +
    '</p>' +
    '<a href="https://goo.gl/maps/e3zFTWCXmhkMBDHK9"' + 'class="marker-tooltip__link" target="_blank">' +
    'Google maps länk</a>' +
    '</div>';

    var infowindow = new google.maps.InfoWindow({
      content: contentString
    });

    infowindow.open(map, marker);
  }
}