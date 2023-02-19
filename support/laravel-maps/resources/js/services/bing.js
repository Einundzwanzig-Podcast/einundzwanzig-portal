import {fadeElementIn, isDefined, logError, openUrl} from '../utils/helper';
import 'leaflet-bing-layer';
import {createMarker} from '../utils/leaflet';

const name = 'bing';

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

    window.L.tileLayer
      .bing({
        bingMapsKey: service.key,
        imagerySet: 'CanvasLight',
      })
      .addTo(map);

    return map;
  },
  createMarker: createMarker.bind(null, name),
}
