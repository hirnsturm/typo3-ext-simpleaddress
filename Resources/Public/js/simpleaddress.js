var SleSimpleaddress = (function (window, document, $, undefined) {

    var EXT = {};

    /**
     * @type {services}
     */
    var services = new function () {

        /**
         *
         * @param selector
         * @returns {boolean}
         */
        this.has = function (selector) {
            return !!(selector);
        };

        /**
         *
         * @param selector
         * @returns {*|HTMLElement}
         */
        this.get = function (selector) {
            return $(selector);
        };

        /**
         *
         * @param url
         */
        this.substituteHttpWithCurrentProtocol = function (url) {
            return (url === undefined) ? null : url.replace('http:', location.protocol)
        };

    };

    /**
     * Plugin: address
     */
    var addressShow = new function () {

        var self = this;
        this.mapSelector = '.ext-simpleaddess-map';

        /**
         * Initializer
         */
        this.init = function () {
            if (services.has(self.mapSelector)) {
                $.each(services.get(self.mapSelector), function () {
                    googleMaps.init(this);
                });
            }
        };
    };

    /**
     *
     * @type {googleMaps}
     */
    var googleMaps = new function () {

        var self = this;
        this.maps = [];
        this.markers = [];
        this.infoWindows = [];

        /**
         *
         * @returns {Array}
         */
        this.getMaps = function () {
            return this.maps;
        };

        /**
         *
         * @returns {Array}
         */
        this.getMarkers = function () {
            return this.markers;
        };

        /**
         * Initializer
         *
         * @param $mapItem
         * @returns {google.maps.Map}
         */
        this.init = function (mapItem) {
            var $mapItem = $(mapItem);
            var config = $mapItem.data('config');

            if (config.mapConfig !== undefined) {
                map = new google.maps.Map($mapItem[0], {
                    center: {
                        lat: parseFloat(config.mapConfig.center.lat),
                        lng: parseFloat(config.mapConfig.center.lng)
                    },
                    zoom: parseInt(config.mapConfig.zoom),
                    mapTypeId: config.mapConfig.mapTypeId,
                    disableDefaultUI: config.mapConfig.disableDefaultUI,
                    disableDoubleClickZoom: config.mapConfig.disableDoubleClickZoom,
                    zoomControl: config.mapConfig.zoomControl,
                    scrollwheel: config.mapConfig.scrollwheel,
                    draggable: config.mapConfig.draggable,
                    styles: [
                        {
                            featureType: 'all',
                            stylers: [
                                {saturation: -80}
                            ]
                        }
                    ]
                });

                self.maps.push({
                    key: $mapItem.id,
                    value: map
                });

                if (config.points !== undefined) {
                    config.points.forEach(function (item) {
                        self.addMarker(map, item.lat, item.lng, item.title, item.content, $mapItem.data('map-marker-icon'));
                    });
                }

                return map;
            }

            return false;
        };

        /**
         *
         * @param map
         * @param lat
         * @param lng
         * @param title
         * @param content
         * @param icon
         * @returns {google.maps.Marker}
         */
        this.addMarker = function (map, lat, lng, title, content, icon) {
            var latLng = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
            var marker = new google.maps.Marker({
                position: latLng,
                title: title,
                clickable: true,
                icon: services.substituteHttpWithCurrentProtocol(icon)
            });

            if (content !== undefined && '' !== content) {
                google.maps.event.addListener(marker, 'click', function () {
                    self.closeInfos();
                    var infoWindow = new google.maps.InfoWindow({
                        content: content
                    });
                    infoWindow.open(self.markers, marker);
                });
            }

            marker.setMap(map);
            self.markers.push(marker); // store marker

            return marker;
        };

        /**
         *
         */
        this.closeInfos = function () {
            if (this.infoWindows.length > 0) {
                // detach the info-window from the marker ... undocumented in the API docs
                this.infoWindows[0].set("marker", null);
                // and close it
                this.infoWindows[0].close();
                // blank the array
                this.infoWindows.length = 0;
            }
        };
    };

    /**
     * initialize
     */
    EXT.initialize = function () {
        addressShow.init();
    };

    return EXT;

})(window, document, jQuery);
