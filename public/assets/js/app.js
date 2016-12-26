/**
 * Example usage of a Script being added
 * to the view. See PagesController to see how this
 * file was included.
 */

var scaffold;

function Scaffold() {
    this.profile = {};
}

window.onload = function() {
    scaffold = new Scaffold();

    if (profile) {
        scaffold.profile = profile;
    }
};