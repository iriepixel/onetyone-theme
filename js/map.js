var geocoder;
var map;

var styles = [
    {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#444444"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "color": "#f2f2f2"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "poi.park",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#deebd8"
            },
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 45
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "#c4e5f3"
            },
            {
                "visibility": "on"
            }
        ]
    }
]

var options = {

  center: new google.maps.LatLng(51.513248, -0.141108),
  streetViewControl: false,
  mapTypeControl: false,
  zoom: 15,
  scrollwheel: false,
  draggable: false,
  mapTypeId: 'Styled'

};

var div = document.getElementById('google-map');

var map = new google.maps.Map(div, options);

var styledMapType = new google.maps.StyledMapType(styles, { name: 'Styled' });
map.mapTypes.set('Styled', styledMapType);

function locationMap() {
geocoder = new google.maps.Geocoder();

var latlng = new google.maps.LatLng(51.513248, -0.141108);

var image = {
  url: '/wp-content/themes/onetyone/images/marker.svg',
  scaledSize: new google.maps.Size(50, 63),
};
var marker = new google.maps.Marker({
  map: map,
  position: latlng,
  icon: image
});
var infowindow = new google.maps.InfoWindow({
        content: 'OnetyOne Apartments<br />'+
                  ' 207 Regent Street<br />'+
                  'London<br />'+
                  'W1B 3HH<br />'+
                  'United Kingdom<br />'
        });
google.maps.event.addListener(marker, 'click', function() {
infowindow.open(map,marker);
});
}

// Resize stuff...
google.maps.event.addDomListener(window, 'resize', function() {
  var center = map.getCenter();
  google.maps.event.trigger(map, 'resize');
  map.setCenter(center);
});

window.onload = locationMap();
