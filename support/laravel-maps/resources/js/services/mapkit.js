import {fadeElementIn, isDefined, logError, openUrl} from '../utils/helper';
import {dispatchEventMarkerClicked} from "../utils/dispatchEvent";

const name = 'mapkit';

export default {
  name,
  createMap(element, mapData) {
    if (!isDefined(window.mapkit)) {
      logError('mapkit is undefined');
      return;
    }
    const {lat, lng, zoom, service} = mapData;

    window.mapkit.init({
      authorizationCallback(done) {
        done(service.key);
      },
    });
    window.mapkit.addEventListener('configuration-change', event => {
      if (event.status === 'Initialized') {
        fadeElementIn(element);
      }
    });

    const map = new window.mapkit.Map(element, {
      mapType: service.type || window.mapkit.Map.MapTypes.Standard,
    });

    const delta = Math.exp(Math.log(360) - (zoom * Math.LN2)); // TODO: zoom to delta not working
    map.region = new window.mapkit.CoordinateRegion(
      new window.mapkit.Coordinate(lat, lng),
      new window.mapkit.CoordinateSpan(delta, delta),
    );

    return map;
  },
  createMarker(element, map, markerData) {
    const {title, lat, lng, url, popup, icon} = markerData;

    const coordinate = new window.mapkit.Coordinate(lat, lng);

    const markerAnnotationOptions = {title};

    if (icon) {
        markerAnnotationOptions.glyphImage = {
            1: icon,
        };
    }

    const marker = new window.mapkit.MarkerAnnotation(coordinate, markerAnnotationOptions);

    marker.addEventListener('select', event => {
      dispatchEventMarkerClicked(name, element, map, marker);
      if (popup) {
        // TODO
      } else if (url) {
        openUrl(url);
      }
    });

    map.showItems([marker]); // TODO: map auto resize bugging if multiple markers

    return marker;
  },
};
