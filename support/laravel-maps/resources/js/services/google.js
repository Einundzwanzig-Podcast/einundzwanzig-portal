import {fadeElementIn, isDefined, logError, openUrl} from '../utils/helper';
import {dispatchEventMarkerClicked} from '../utils/dispatchEvent';

const name = 'google';

export default {
  name,
  createMap(element, mapData) {
    if (!isDefined(window.google)) {
      logError('google is undefined');
      return;
    }
    if (!isDefined(window.google.maps)) {
      logError('google maps is undefined');
      return;
    }

    const {lat, lng, zoom, service} = mapData;

    const map = new window.google.maps.Map(element, {
      center: new window.google.maps.LatLng(lat, lng),
      zoom,
      mapTypeId: service.type || window.google.maps.MapTypeId.ROADMAP,
    });

    window.google.maps.event.addListenerOnce(map, 'idle', () => {
      fadeElementIn(element);
    });

    return map;
  },
  createMarker(element, map, markerData) {
    const {title, lat, lng, url, popup, icon, iconSize, iconAnchor} = markerData;

    const markerOptions = {
      position: new window.google.maps.LatLng(lat, lng),
      map,
      title,
      draggable: false,
    };

    if (icon) {
      markerOptions.icon = {
        url: icon,
      };
      if (iconSize) {
        markerOptions.icon.size = new window.google.maps.Size(...iconSize);
      }
      if (iconAnchor) {
        markerOptions.icon.anchor = new window.google.maps.Point(...iconAnchor);
      }
    }

    const marker = new window.google.maps.Marker(markerOptions);

    marker.addListener('click', () => {
      dispatchEventMarkerClicked(name, element, map, marker);
      if (popup) {
        const infoWindow = new window.google.maps.InfoWindow({
          content: popup
        });
        infoWindow.open(map, marker);
      } else if (url) {
        openUrl(url);
      }
    });

    return marker;
  },
};
