function addParameterToURL(param, value) {
    let url = new URL(window.location.href);
    url.searchParams.set(param, value);
    return url.toString();
}