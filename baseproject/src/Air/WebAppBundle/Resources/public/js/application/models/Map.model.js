var MapModel = Backbone.Model.extend({
    defaults: {
        gMap: null,
        id_container: '',
        latitude: 24.886436490787712,
        longitude: -70.2685546875,
        zoom: 8,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    },
    
    initialize: function (idContainer){
        this.set({'id_container': idContainer});
    },
    
    createLatLngCenter: function (){        
        return new google.maps.LatLng(this.get('latitude'), this.get('longitude'));
    },
    
    createGMapObject: function (){
        var mapOptions = {
            center: this.createLatLngCenter(),
            zoom: this.get('zoom'),
            mapTypeId: this.get('mapTypeId')
        };
        var map = new google.maps.Map(document.getElementById(this.get('id_container')), mapOptions);
        this.set('gMap', map);
        console.log(this.getGMap(), map);
    },
        
    
    triggerMap: function (){
        var self = this;
        function initializeMap(){
            self.createGMapObject();
            
//            var imageBounds = new google.maps.LatLngBounds(
//                new google.maps.LatLng(40.712216,-74.22655),
//                new google.maps.LatLng(40.773941,-74.12544));
//
//            var oldmap = new google.maps.GroundOverlay(
//              "http://www.lib.utexas.edu/maps/historical/newark_nj_1922.jpg",
//              imageBounds);
//            oldmap.setMap(map);
            self.triggerZoomListener();
        }
      google.maps.event.addDomListener(window, 'load', initializeMap);      
      
    },
    
    addCustomMarker: function (){
        if (GBrowserIsCompatible()) 
        {
            var map = new GMap2(document.getElementById("map_canvas"));
            map.setCenter(new GLatLng(37.4419, -122.1419), 13);
            map.addControl(new GSmallMapControl());
            map.addControl(new GMapTypeControl());

            // Create a base icon for all of our markers that specifies the
            // shadow, icon dimensions, etc.
            var baseIcon = new GIcon(G_DEFAULT_ICON);
            baseIcon.shadow = "http://www.google.com/mapfiles/shadow50.png";
            baseIcon.iconSize = new GSize(20, 34);
            baseIcon.shadowSize = new GSize(37, 34);
            baseIcon.iconAnchor = new GPoint(9, 34);
            baseIcon.infoWindowAnchor = new GPoint(9, 2);

            // Creates a marker whose info window displays the letter corresponding
            // to the given index.
            function createMarker(point, index) {
              // Create a lettered icon for this point using our icon class
              var letter = String.fromCharCode("A".charCodeAt(0) + index);
              var letteredIcon = new GIcon(baseIcon);
              letteredIcon.image = "http://www.google.com/mapfiles/marker" + letter + ".png";

              // Set up our GMarkerOptions object
              markerOptions = { icon:letteredIcon };
              var marker = new GMarker(point, markerOptions);

              GEvent.addListener(marker, "click", function() {
                marker.openInfoWindowHtml("Marker <b>" + letter + "</b>");
              });
              return marker;
            }
        }
    },
    
    /**
     * Draws a series of Rectangles based on the
     * given coords.
     * 
     * @param {Array} coords A set of coordinates in which every row represents
     * 4 point to draw a rectangle area with a selected color
     */
    drawPolygon: function (coords){
        var paths = [];
        for (var i in coords)
        {
            var nwLt = coords[i].coord.nw.lt;
            var nwLg = coords[i].coord.nw.lg;
            var neLt = coords[i].coord.ne.lt;
            var neLg = coords[i].coord.ne.lg;
            var swLt = coords[i].coord.sw.lt;
            var swLg = coords[i].coord.sw.lg;
            var seLt = coords[i].coord.se.lt;
            var seLg = coords[i].coord.se.lg;
            
            var p1 = new google.maps.LatLng(nwLt, nwLg);
            var p2 = new google.maps.LatLng(neLt, neLg);
            var p3 = new google.maps.LatLng(seLt, seLg);
            var p4 = new google.maps.LatLng(swLt, swLg);            
            
            paths.push(p1);
            paths.push(p2);
            paths.push(p2);
            paths.push(p3);
            paths.push(p3);
            paths.push(p4);
            paths.push(p4);
            paths.push(p1);
            
            var color = coords[i].color;
            var shape = new google.maps.Polygon({
                paths: paths,
                strokeColor: color,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: color,
                fillOpacity: 0.35
            });

            shape.setMap(this.getGMap());
        }                
    },

    triggerZoomListener: function (){
        var self = this;
        google.maps.event.addListener(this.getGMap(), 'idle', function(ev){
            var bounds = self.getGMap().getBounds();
            var ne = bounds.getNorthEast(); // LatLng of the north-east corner
            var sw = bounds.getSouthWest(); // LatLng of the south-west corder
            
            var coords = [
                {coord: {
                         nw: {lt: ne.lat(), lg: sw.lng()}, 
                         ne: {lt: ne.lat(), lg: ne.lng()}, 
                         sw: {lt: sw.lat(), lg: sw.lng()}, 
                         se: {lt: sw.lat(), lg: ne.lng()}
                        }, 
                 color: '#ff0000', 
                 name: 'Good'}                
            ];
            
            $.ajax({
                url: Routing.generate('api_get_grid_data'),
                type: 'GET',
                dataType: 'json',
                data: {
                    neLat: ne.lat(),
                    neLng: ne.lng(),
                    swLat: sw.lat(),
                    swLng: sw.lng()
                },
                success: function (grid){
                    console.log(grid);
                }
            });
            
            self.drawPolygon(coords);            
        });
    },
    
    getGMap: function (){
        return this.get('gMap');
    }
});
