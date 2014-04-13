var MapModel = Backbone.Model.extend({
    defaults: {
        id: null,
        latitude: 40.740,
        longitude: -74.18,
        zoom: 8,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    },
    
    createLatLngObj: function (){
        return new google.maps.LatLng(this.get('latitude'), this.get('longitude'));
    }
});
