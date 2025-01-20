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
    // document.getElementById('navUserElement').setAttribute('hidden', '');
    collapseNavbarElement(document.getElementById('navUserElement'));
}

function searchDeactivateLayout() {
    document.getElementById('searchInputClear').setAttribute('hidden', '');
    document.getElementById('collapseSearch').classList.remove("show"); // remove class 'show'
    // document.getElementById('navUserElement').removeAttribute('hidden');
    expandNavbarElement(document.getElementById('navUserElement'));
}



function panelSearch(searchText) {

}





// CUSTOM navbar-collapsing

function collapseNavbarElement(element) {
    element.style.height = `${element.scrollHeight}px`; // Ustaw aktualną wysokość
    element.classList.add('navbar-collapsing'); // Dodaj klasę do animacji
    element.classList.remove('navbar-collapse', 'show'); // Usuń klasy stanu początkowego

    // Po krótkim czasie ustaw wysokość na 0, aby rozpocząć animację
    setTimeout(() => {
        element.style.height = '0';
    }, 10);

    // Po zakończeniu animacji (dopasowanej do czasu w CSS)
    element.addEventListener('transitionend', function onTransitionEnd() {
        element.classList.remove('navbar-collapsing'); // Usuń klasę animacji
        element.classList.add('navbar-collapse'); // Dodaj klasę końcową
        element.setAttribute('hidden', ''); // Ukryj element w DOM
        element.removeEventListener('transitionend', onTransitionEnd);
    });
}

function expandNavbarElement(element) {
    element.removeAttribute('hidden'); // Upewnij się, że element nie jest ukryty
    element.classList.add('navbar-collapsing'); // Dodaj klasę do animacji
    element.classList.remove('navbar-collapse'); // Usuń ukrywanie
    element.style.height = '0'; // Rozpocznij animację od 0 wysokości

    // Następnie ustaw pełną wysokość
    setTimeout(() => {
        element.style.height = `${element.scrollHeight}px`;
    }, 10);

    // Po zakończeniu animacji
    element.addEventListener('transitionend', function onTransitionEnd() {
        element.classList.remove('navbar-collapsing'); // Usuń klasę animacji
        element.classList.add('navbar-collapse', 'show'); // Ustaw klasy stanu otwartego
        element.style.height = ''; // Usuń inline style
        element.removeEventListener('transitionend', onTransitionEnd);
    });
}