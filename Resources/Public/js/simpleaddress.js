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
            return url.replace('http:', location.protocol);
        };

    };

    /**
     * Plugin: address
     */
    var addressShow = new function () {

        var self = this;
        this.mapSelector = 'ext-simpleaddess-map';

        /**
         * Initializer
         */
        this.init = function () {
            if (services.has(self.mapSelector)) {
                $.each(services.get(self.mapSelector), function () {
                    googleMaps.getMapBySelector(self.mapSelector);
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
         *
         * @param {string} mapSelector
         * @returns {google.maps.Map}
         */
        this.getMapBySelector = function (mapSelector) {
            var map = false;

            this.maps.forEach(function (item) {
                if (item.key === mapSelector) {
                    map = item.value;
                }
            });

            return (false === map) ? this.init(mapSelector) : map;
        };

        /**
         * Initializer
         *
         * @param {string} mapSelector
         * @returns {google.maps.Map}
         */
        this.init = function (mapSelector) {
            var $map = $(mapSelector);
            var map = new google.maps.Map($map[0], {});
            var config = $map.data('config');


            console.log(config);


            if (config) {
                map = new google.maps.Map($map[0], {
                    center: {
                        lat: parseFloat(config.center.lat),
                        lng: parseFloat(config.center.lng)
                    },
                    zoom: parseInt(config.zoom),
                    mapTypeId: config.mapTypeId,
                    disableDefaultUI: config.disableDefaultUI,
                    disableDoubleClickZoom: config.disableDoubleClickZoom,
                    zoomControl: config.zoomControl,
                    scrollwheel: config.scrollwheel,
                    draggable: config.draggable,
                    styles: config.mapStyle
                });
            }

            self.maps.push({
                key: mapSelector,
                value: map
            });

            if (config && config.marker !== undefined) {
                config.marker.forEach(function (item) {
                    self.addMarker(map, item.lat, item.lng, item.title, item.content, $map.data('map-icon-base-url') + $map.data('map-icon'));
                });
            }

            return map;
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
                        content: content,
                        pixelOffset: new google.maps.Size(0, 87)
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

        /**
         *
         * @param carouselSelector
         * @param carouselItemSelector
         */
        this.closeInfoWindow = function (carouselSelector, carouselItemSelector) {
            $(carouselSelector).find('.owl-item').removeClass('skd-not-active skd-active');
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
