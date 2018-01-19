<template>
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-map-marker"></i>
            <h3 class="box-title">Map Helper</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-default" @click.prevent="centerSpot()" title="re-center red dot">
                    <i class="fa fa-arrows"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="coordinates" ref="map">... Map Loading ...</div>
            <transition name="slide-fade">
                <div v-if="toast" class="coord-toast">{{ toast }}</div>
            </transition>
        </div>
    </div>
</template>

<script>
    import loadGoogleMapsAPI from 'load-google-maps-api';
    import BaseTable from 'belt/core/js/helpers/table';
    import BaseService from 'belt/core/js/helpers/service';

    /**
     * @todo create/add parameter to limit places results to nearby items
     */
    class PlacesTable extends BaseTable {
        constructor(options = {}) {
            super(options);
            this.service = new BaseService({baseUrl: '/api/v1/places'});
            this.query.orderBy = 'id';
            this.query.sortBy = 'desc';
            this.query.perPage = 5000;
        }
    }

    let gMap = null;
    let dragSpot = null;
    let _vue = null;

    export default {
        name: 'coordinates-map',
        props: ['lat', 'lng', 'type', 'level', 'zoom'],
        data() {
            return {
                center: '',
                dragSpot: null,
                gMap: null,
                table: new PlacesTable(),
                toast: '',
                markers: [],
                windows: [],
                active: {
                    place: null
                }
            }
        },
        mounted() {
            _vue = this;
            loadGoogleMapsAPI({key: config('gmaps_api_key')})
                .then(() => this.initMap())
                .then(() => this.table.index())
                .then(() => this.addPlaces())
                .catch((err) => console.error(err));
        },
        computed: {
            activePlace() {
                return this.markers.find(m => m.id === this.active.place);
            },
            activeWindow() {
                return this.windows.find(w => w.id === this.active.place);
            }
        },
        methods: {

            centerSpot() {
                this.dragSpot.setPosition(this.gMap.getCenter());
            },

            /**
             * Initilize Map
             */

            initMap() {

                // Get zoom from parameter or config
                //let zoom = parseInt(this.zoom ? this.zoom : config('zoom', 15));
                let lat = parseFloat(this.lat ? this.lat : config('lat'));
                let lng = parseFloat(this.lng ? this.lng : config('lng'));

                this.center = new google.maps.LatLng(lat, lng);

                this.gMap = new google.maps.Map(this.$refs.map, {
                    center: this.center,
                    zoom: 18,
                    disableDefaultUI: false,
                    gestureHandling: 'cooperative',
                    scrollwheel: false,
                });

                // Set marker default location OR passed in coordinates
                let dragSpotLocation = {};
                if (this.lat && this.lng) {
                    dragSpotLocation = new google.maps.LatLng(this.lat, this.lng);
                } else {
                    dragSpotLocation = this.center;
                }

                // Create draggable marker
                this.dragSpot = new google.maps.Marker({
                    position: dragSpotLocation,
                    map: this.gMap,
                    draggable: true,
                    zIndex: 100,
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 10,
                        strokeOpacity: 0.0,
                        strokeColor: 'red',
                        fillOpacity: 1.0,
                        fillColor: 'purple'
                    }
                });

                // Add listener, emit events and coords changed
                google.maps.event.addListener(this.dragSpot, 'dragend', function (event) {
                    _vue.$emit('spot-updated', {
                        lat: this.getPosition().lat(),
                        lng: this.getPosition().lng()
                    })
                    _vue.showToast(`Spot Updated`)
                });

                return Promise.resolve();
            },

            /**
             * Update Dragspot Location
             */

            updateDragSpotLocation() {
                if (this.dragSpot && this.gMap) {
                    const updatedPosition = new google.maps.LatLng(this.lat, this.lng);
                    this.dragSpot.setPosition(updatedPosition);
                    this.gMap.setCenter(updatedPosition);
                }
            },

            /**
             * Add Places
             */

            addPlaces() {
                this.table.items.forEach(this.addPlaceMarker);
            },

            /** Quick Toast */
            showToast(msg) {
                this.toast = msg
                delay(1500)
                    .then(() => this.toast = '');
            },

            /**
             * Add Place marker
             */

            addPlaceMarker(place) {
                if (!place.address) {
                    return;
                }

                // create marker
                const marker = createMarker(place);
                marker.setMap(this.gMap);
                marker.id = place.id;
                this.markers.push(marker);

                // bind marker events
                google.maps.event.addListener(marker, 'dragend', function (event) {
                    const payload = {
                        lat: this.getPosition().lat(),
                        lng: this.getPosition().lng()
                    }
                    saveOutsidePlace(this.placeId, this.addressId, this.placeName, payload)
                });

                google.maps.event.addListener(marker, 'click', function (event) {
                    window.location.href = `/admin/belt/spot/places/edit/${this.placeId}/addresses`;
                });

                marker.addListener('mouseover', function () {
                    if (_vue.active.place && (_vue.active.place !== this.id)) {
                        // console.log('hide spot from MOUSEOVER')
                        _vue.hidePlace(_vue.active.place)
                    }
                    _vue.showPlace(this.id)
                });

                marker.addListener('mouseout', function () {
                    // console.log('hide spot from mouse OUT: %s', this.id)
                    _vue.hidePlace(this.id)
                });

                // create infoWindow
                const infoWindow = createInfoWindow(place);
                infoWindow.id = place.id;
                this.windows.push(infoWindow);

            },

            showPlace(id) {
                // Update active id
                this.active.place = id;

                // guard
                if (!this.activePlace) {
                    return;
                }

                // Open window
                this.activeWindow.open(this.gMap, this.activePlace);
            },

            hidePlace(id) {
                // Guard
                const window = this.windows.find(w => w.id === id);

                if (!window) {
                    return;
                }

                // Close Window
                window.close();
            },
        },
        watch: {
            lat: function (val) {
                this.updateDragSpotLocation();
            },
            lng: function (val) {
                this.updateDragSpotLocation();
            }
        }
    }

    /**
     * Helper Funtions
     */

    function iconDefault() {
        return {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 8,
            strokeOpacity: 0.0,
            strokeColor: '#b9b9b9',
            fillOpacity: 1.0,
            fillColor: '#b9b9b9'
        }
    }

    function iconActive() {
        return {
            url: activeDestinationMarker,
            labelOrigin: new google.maps.Point(18, 75),
        }
    }

    function labelActive(text) {
        return {
            color: '#193d66',
            fontFamily: 'ApexNew',
            text: text
        }
    }

    function config(key, _default) {

        if (_.get(window, 'larabelt.coords.' + key)) {
            return _.get(window, 'larabelt.coords.' + key);
        }

        if (_default) {
            return _default;
        }

        return null;
    }

    function saveOutsidePlace(placeId, addressId, placeName, payload) {
        let baseUrl = `/api/v1/places/${placeId}/addresses/`;
        const outsideService = new BaseService({baseUrl: baseUrl});
        outsideService.put(addressId, payload)
            .then(() => _vue.showToast(`${placeName} Updated`));
    }


    function delay(time) {
        return new Promise(resolve => {
            setTimeout(() => resolve(), time);
        })
    }

    function createInfoWindow(place) {
        const contentString = '<div class="c-info-window">' +
            `<h5 class="c-info-window__headline">${place.name}</h5>` +
            '</div>';

        return new google.maps.InfoWindow({
            content: contentString,
            id: place.id
        });
    }

    function createMarker(place) {
        return new google.maps.Marker({
            position: new google.maps.LatLng(place.address.lat, place.address.lng),
            draggable: true,
            zIndex: 1,
            placeId: place.id,
            addressId: place.address.id,
            placeName: place.name,
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                scale: 9,
                strokeOpacity: 0.0,
                strokeColor: 'red',
                fillOpacity: 1.0,
                fillColor: 'gray'
            }
        })
    }

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .coordinates {
        height: 500px;
    }

    .box-body {
        padding: 0;
        position: relative;
        overflow: hidden;
    }

    .coord-toast {
        background-color: purple;
        font-size: 13px;
        padding: 10px;
        color: #fff;
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        max-width: 300px;
    }

    .slide-fade-enter-active {
        transition: all .3s ease;
    }

    .slide-fade-leave-active {
        transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }

    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active below version 2.1.8 */
    {
        transform: translateX(-50%) translateY(-105%);
    }

</style>