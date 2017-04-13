class UrlHelper {

    get(name, default_value, url) {

        url = url ? url : window.location.href;

        name = name.replace(/[\[\]]/g, "\\$&");

        let regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"), results = regex.exec(url);

        if (!results) {
            return default_value ? default_value : null;
        }

        if (!results[2]) {
            return default_value ? default_value : '';
        }

        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
}

export default UrlHelper;