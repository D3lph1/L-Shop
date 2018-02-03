export default class Url {
    static getParams() {
        let params = {};
        let parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            params[key] = value;
        });

        return params;
    }

    static redirect(to)
    {
        document.location.href = to;
    }
}
