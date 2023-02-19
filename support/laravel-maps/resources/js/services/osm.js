import {fadeElementIn, isDefined, logError, openUrl} from '../utils/helper';
import {createMarker} from '../utils/leaflet';

// TODO maybe add this https://github.com/elmarquis/Leaflet.GestureHandling/

// TODO add config for different styles like database connections: https://wiki.openstreetmap.org/wiki/Tile_servers
// http://leaflet-extras.github.io/leaflet-providers/preview/

// TODO custom icons: https://leafletjs.com/examples/custom-icons/

const name = 'osm';

export default {
  name,
  createMap(element, mapData) {
    if (!isDefined(window.L)) {
      logError('leaflet is undefined');
      return;
    }
    const {lat, lng, zoom, service} = mapData;

    const map = window.L
      .map(element, {})
      .on('load', () => {
        fadeElementIn(element);
      })
      .setView([lat, lng], zoom);

    window.L
      .tileLayer(service.type || 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      })
      .addTo(map);

    return map;
  },
  createMarker: createMarker.bind(null, name),
}
