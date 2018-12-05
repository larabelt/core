class Cookies {

    set(name, value, exdays) {

        let d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));

        let expires = "expires=" + d.toUTCString();

        let domain = _.get(window, 'larabelt.hostname', window.location.hostname);

        document.cookie = name + "=" + value + ";" + expires + ";path=/" + ";domain=" + domain;
    }

    get(name) {
        name = name + "=";
        let cookies = document.cookie.split(';');
        for (let i = 0; i < cookies.length; i++) {
            let c = cookies[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }

        return null;
    }

    delete(name) {
        this.set(name, null, -1);
    }
}

export default Cookies;