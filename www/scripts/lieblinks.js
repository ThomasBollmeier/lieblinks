const $ = selector => document.querySelector(selector);

document.addEventListener("DOMContentLoaded", () => {

    readBookmarks().then(displayBookmarks);

});

function readBookmarks() {
    return fetch("api/bookmarks").then(response => response.json());
}

function displayBookmarks(bookmarks) {

    const list = $('#lieblinks_list');

    for (let child of list.childNodes) {
        list.removeChild(child);
    }

    for (let bookmark of bookmarks) {
        const li = document.createElement("li");
        const a = document.createElement("a");
        a.href = bookmark.url;
        a.title = bookmark.description;
        a.text = bookmark.url;
        li.appendChild(a);
        const info = document.createTextNode(` (${bookmark.description})`);
        li.appendChild(info);
        list.appendChild(li);
    }

}