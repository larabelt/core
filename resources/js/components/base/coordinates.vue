<template>
    <div class="coordinates" ref="map">... Map Loading ...</div>
</template>

<script>
import loadGoogleMapsAPI from 'load-google-maps-api';

let gMap = {};

export default {
  name: 'coordinates-map',
  props: ['lat', 'lng', 'type', 'level'],
  data () {
    return {
      center: ''
    }
  },
  mounted () {
    // Fetch google maps API
    loadGoogleMapsAPI({ key: 'AIzaSyDSaodVjYaPnWOtjEOzx-8IpgTaVlrtpXw'})
      .then(this.initMap)
      .catch((err) => console.error(err));
  }, 
  methods: {

    /**
     * Initilize Map
     */

    initMap () {
        this.center = new google.maps.LatLng(39.9978441,-82.8857605);
        
        gMap = new google.maps.Map(this.$refs.map , {
          center: this.center,
          zoom: 17,
          disableDefaultUI: false,
          gestureHandling: 'cooperative'
        });

        // Set marker default location OR passed in coordinates
        let dragSpotLocation = this.center
        if (this.lat && this.lng) {
          dragSpotLocation = new google.maps.LatLng(this.lat, this.lng)
        }

        // Create draggable marker
        const dragSpot = new google.maps.Marker({
          position: dragSpotLocation,
          map: gMap,
          draggable: true,
          icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 10,
            strokeOpacity: 0.0,
            strokeColor: 'red',
            fillOpacity: 1.0,
            fillColor: 'red'
          }
        });

        // Add listener, emit events and coords changed
        const _vue = this;
        google.maps.event.addListener(dragSpot, 'dragend', function (event) {
           _vue.$emit('spot-updated', {
             lat: this.getPosition().lat(),
             lng: this.getPosition().lng()
           })
        });

        return Promise.resolve();
    }

  }
}


/**
 * Helper Funtions
 */

function iconDefault () {
  return {
    path: google.maps.SymbolPath.CIRCLE,
    scale: 8,
    strokeOpacity: 0.0,
    strokeColor: '#b9b9b9',
    fillOpacity: 1.0,
    fillColor: '#b9b9b9'
  }
}

function iconActive () {
  return {
    url: activeDestinationMarker,
    labelOrigin: new google.maps.Point(18, 75),
  }
}

function labelActive (text) {
  return {
    color: '#193d66',
    fontFamily: 'ApexNew',
    text: text
  }
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.coordinates {
  height: 500px;
}
</style>
