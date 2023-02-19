import {logError} from './helper';

const parseMap = element => JSON.parse(
  element.dataset.mapGoogle
  || element.dataset.mapOsm
  || element.dataset.mapBing
  || element.dataset.mapMapquest
  || element.dataset.mapYandex
  || element.dataset.mapMapkit
);

const parseService = element => {
  const {key, type} = JSON.parse(element.dataset.mapService);

  return {
    key,
    type,
  }
};

const parseMarkers = element => {
  const markers = JSON.parse(element.dataset.mapMarkers) || [];
  return markers.map(marker => {
    const lat = parseNumberFloat(marker.lat);
    const lng = parseNumberFloat(marker.lng);

    const {title, url, popup, icon, icon_size, icon_anchor} = marker;

    return {
      title,
      lat,
      lng,
      url,
      popup,
      icon,
      iconSize: icon_size || marker.iconSize,
      iconAnchor: icon_anchor || marker.iconAnchor,
    };
  });
};

const parseNumberFloat = number => {
  return typeof number === 'string'
    ? parseFloat(number)
    : number;
};

const parseNumberInt = number => {
  return typeof number === 'string'
    ? parseFloat(number)
    : number;
};

export default {
  map(element) {
    try {
      const map = parseMap(element);
      const lat = parseNumberFloat(map.lat);
      const lng = parseNumberFloat(map.lng);
      const zoom = parseNumberInt(map.zoom);
      const service = parseService(element);
      const markers = parseMarkers(element);
      return {
        lat,
        lng,
        zoom,
        service,
        markers,
      };
    } catch (e) {
      logError(e);
    }
  },
}
