/**
 * This is custom js added by julia-gotuje app authors
 */

'use strict';

// #############################
// sneat js code rewrited for new navbar layout

(function () { // Initialize menu togglers and bind click on each
    let menuToggler = document.querySelectorAll('.navbar-menu-toggle');
    menuToggler.forEach(item => {
        item.addEventListener('click', event => {
            event.preventDefault();
            window.Helpers.toggleCollapsed();
        });
    });

    // Display menu toggle (navbar-menu-toggle) on hover with delay
    let delay = function (elem, callback) {
        let timeout = null;
        elem.onmouseenter = function () {
            // Set timeout to be a timer which will invoke callback after 300ms (not for small screen)
            if (!Helpers.isSmallScreen()) {
                timeout = setTimeout(callback, 300);
            } else {
                timeout = setTimeout(callback, 0);
            }
        };

        elem.onmouseleave = function () {
            // Clear any timers set to timeout
            document.querySelector('.navbar-menu-toggle').classList.remove('d-block');
            clearTimeout(timeout);
        };
    };
    if (document.getElementById('layout-menu')) {
        delay(document.getElementById('layout-menu'), function () {
            // not for small screen
            if (!Helpers.isSmallScreen()) {
                document.querySelector('.navbar-menu-toggle').classList.add('d-block');
            }
        });
    }
})();

// #########################################
// search field handling

// show / hide clear input button

// when input with id = "searchInput" has any text put by user then remove attribute "hidden" from element with id searchInputClear
// when input with id = "searchInput" has no text (its value empty) then add attribute "hidden" to element with id searchInputClear

document.getElementById('searchInput').addEventListener('input', function () {
    if (this.value) {
        // search activated
        searchActivateLayout()

        panelSearch(this.value) // call function to search

    } else {
        // search deactivated
        searchDeactivateLayout()
    }
});

// clear input field when clear button is clicked
document.getElementById('searchInputClear').addEventListener('click', function () {
    // clear val
    document.getElementById('searchInput').value = '';
    // search deactivated
    searchDeactivateLayout()
});

function searchActivateLayout() {
    document.getElementById('searchInputClear').removeAttribute('hidden');
    document.getElementById('collapseSearch').classList.add("show"); // add class 'show'
    document.getElementById('navUserElement').setAttribute('hidden', '');
}

function searchDeactivateLayout() {
    document.getElementById('searchInputClear').setAttribute('hidden', '');
    document.getElementById('collapseSearch').classList.remove("show"); // remove class 'show'
    document.getElementById('navUserElement').removeAttribute('hidden');
    
    document.getElementById('searchSpinner').removeAttribute('hidden');
    document.getElementById('searchResults').setAttribute('hidden', '');
}

function searchFinishLayout() {
    document.getElementById('searchSpinner').setAttribute('hidden', '');
    document.getElementById('searchResults').removeAttribute('hidden');
}


function panelSearch(searchText) {
    // sleep 3 s
    setTimeout(searchFinishLayout, 3000);
}





