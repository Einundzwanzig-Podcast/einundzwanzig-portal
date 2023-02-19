import {isDefined, logError, openUrl} from '../utils/helper';
import {dispatchEventMarkerClicked} from '../utils/dispatchEvent';

const name = 'yandex';

export default {
  name,
  createMap(element, mapData) {
    if (!isDefined(window.ymaps)) {
      logError('ymaps is undefined');
      return;
    }
    const {lat, lng, zoom} = mapData;

    const map = new window.ymaps.Map(element, {
      center: [lat, lng],
      zoom,
    });

    // window.google.maps.event.addListenerOnce(map, 'idle', () => {
    //   fadeElementIn(element);
    // });

    return map;
  },
  createMarker(element, map, markerData) {
    const {title, lat, lng, url, popup, icon, iconSize, iconAnchor} = markerData;

    const placemarkProperties = {
      hintContent: title,
    };

    const placemarkOptions = {};

    if (icon) {
      placemarkOptions.iconLayout = 'default#imageWithContent';
      placemarkOptions.iconImageHref = icon;
      if (iconSize) {
        placemarkOptions.iconImageSize = iconSize;
      }
      if (iconAnchor) {
        placemarkOptions.iconImageOffset = iconAnchor;
      }
    }

    if (popup) {
      placemarkProperties.balloonContentBody = popup;
    }

    const marker = new window.ymaps.Placemark([lat, lng], placemarkProperties, placemarkOptions);

    marker.events.add('click', e => {
      dispatchEventMarkerClicked(name, element, map, marker);
      if (popup) {
        // Handled with ballonContentBody
      } else if (url) {
        openUrl(url);
      }
    });

    map.geoObjects.add(marker);

    return marker;
  },
};
