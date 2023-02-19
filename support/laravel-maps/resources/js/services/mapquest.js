import {fadeElementIn, isDefined, logError, openUrl} from '../utils/helper';
import {createMarker} from '../utils/leaflet';

// TODO maybe add this https://github.com/elmarquis/Leaflet.GestureHandling/

// TODO add config for different styles like database connections: https://wiki.openstreetmap.org/wiki/Tile_servers
// http://leaflet-extras.github.io/leaflet-providers/preview/

// TODO custom icons: https://leafletjs.com/examples/custom-icons/
const name = 'mapquest';

export default {
  name,
  createMap(element, mapData) {
    if (!isDefined(window.L)) {
      logError('leaflet is undefined');
      return;
    }
    if (!isDefined(window.L.mapquest)) {
      logError('mapquest is undefined');
      return
    }
    const {lat, lng, zoom, service} = mapData;
    window.L.mapquest.key = service.key;

    const map = window.L.mapquest
      .map(element, {
        center: [lat, lng],
        zoom,
        layers: window.L.mapquest.tileLayer(service.type || 'map'),
      })
      .on('load', () => {
        fadeElementIn(element);
      })
      .setView([lat, lng], zoom);

    return map;
  },
  createMarker: createMarker.bind(null, name),
}
