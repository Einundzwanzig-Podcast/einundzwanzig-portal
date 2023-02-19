export function dispatchEventMapInitialized (serviceName, element, data) {
  const event = new CustomEvent('LaravelMaps:MapInitialized', {
    detail: {
      element: element,
      map: data.map,
      markers: data.markers || [],
      service: serviceName,
    },
  });
  window.dispatchEvent(event);
}

export function dispatchEventMarkerClicked (serviceName, element, map, marker) {
  const event = new CustomEvent('LaravelMaps:MarkerClicked', {
    detail: {
      element: element,
      map: map,
      marker: marker,
      service: serviceName,
    },
  });
  window.dispatchEvent(event);
}
