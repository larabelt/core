class Cookies {

    set(name, value, exdays) {
        let d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();

        document.cookie = name + "=" + value + ";" + expires + ";path=/";
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