import {openUrl} from './helper';
import {dispatchEventMarkerClicked} from './dispatchEvent';

export function createMarker(service, element, map, markerData) {
  const {title, lat, lng, url, popup, icon, iconSize, iconAnchor} = markerData;

  const markerOptions = {
    title,
    keyboard: false,
    draggable: false,
  };

  if (icon) {
    const iconOptions = {
      iconUrl: icon,
    };
    if (iconSize) {
      iconOptions.iconSize = iconSize;
    }
    if (iconAnchor) {
      iconOptions.iconAnchor = iconAnchor;
    }
    markerOptions.icon = window.L.icon(iconOptions);
  }

  const marker = window.L.marker([lat, lng], markerOptions);

  marker.on('click', event => {
    event.originalEvent.preventDefault();
    dispatchEventMarkerClicked(service, element, map, marker);
    if (popup) {
      window.L.popup()
        .setLatLng([lat, lng])
        .setContent(popup)
        .openOn(map);
    } else if (url) {
      openUrl(url);
    }
  });

  marker.addTo(map);

  return marker;
}
