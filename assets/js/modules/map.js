import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

export default class Map {
    static init() {
        let map = document.querySelector('#map')
        if (map === null) {
            return
        }
        let icon = L.icon({
            iconUrl: '/images/marker-icon.png'
        });

        let center = [map.dataset.lat, map.dataset.lng]
        map = L.map('map').setView(center, 13)
        let token = 'pk.eyJ1Ijoib2xwb2siLCJhIjoiY2tibWNlcTBqMWhidjJybDl5YXV4c2R4YyJ9.V9bhsLYwWMm8A8wvxJHrWw'
        L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/streets-v11/tiles/{z}/{x}/{y}?access_token=' + token, {
            maxZoom: 18,
            minZoom: 12,
            attribution: '© <a href="https://www.mapbox.com/feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map)
        L.marker(center, { icon: icon }).addTo(map)
    }

}