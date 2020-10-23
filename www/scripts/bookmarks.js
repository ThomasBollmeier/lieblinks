const bookmarks = (function(exports) {

    function readAll() {
        return fetch("api/bookmarks").then(response => response.json());
    }

    function create(url, description) {

        return fetch('api/bookmarks', {
            method: "POST",
            body: JSON.stringify({url, description}),
            headers: {"Content-type": "application/json; charset=UTF-8"}
        });
    }

    return {
        readAll,
        create
    }

})();