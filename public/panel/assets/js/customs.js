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
}

function searchStartLayout(){
    console.log("searchStartLayout() : start")
    document.getElementById('searchSpinner').removeAttribute('hidden');
    document.getElementById('searchResults').setAttribute('hidden', '');
    document.getElementById('searchNoResults').setAttribute('hidden', '');
}

function searchFinishLayout(isFound) {
    console.log("searchFinishLayout() : start")
    document.getElementById('searchSpinner').setAttribute('hidden', '');
    if (isFound){
        document.getElementById('searchResults').removeAttribute('hidden');
    } else {
        document.getElementById('searchNoResults').removeAttribute('hidden');
    }
}


function panelSearch(searchText) {
    searchStartLayout();
    
    const url = `/api/search_panel?search_text=${encodeURIComponent(searchText)}`;
    let isFound = false;
    let resultsContainer = document.getElementById('searchResults');
    
    fetch(url, {
            method: 'GET',
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            // for each in data -> results
            data.results.forEach(result => {
                isFound = true;
                console.log(result);
                
                const metadataBlock = document.createElement('div');

                metadataBlock.innerHTML = `
                    <a href="${result.url}">${result.title}"></a>
                `;

                resultsContainer.appendChild(metadataBlock)

            })
            
            if(data.more_items > 0) {
                resultsContainer.appendChild(document.createElement('hr'));

                const metadataBlock = document.createElement('div');
                // metadataBlock.classList.add('mb-2', 'border', 'rounded');

                metadataBlock.innerHTML = `
                    <a href="#">... oraz ${data.more_items} więcej wyników</a>
                `;

                resultsContainer.appendChild(metadataBlock)
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => {
            searchFinishLayout(isFound);
        });
    
}



// const titleInput = document.getElementById('title');
// const customUrlInput = document.getElementById('custom_url');

// titleInput.addEventListener('input', () => {
//     generateUrl();
// })

// function generateUrl() {
//     // console.log('generateUrl()');
//     const title = titleInput.value;
//     // build url with param
//     const url = `/api/generate_page_url?text=${encodeURIComponent(title)}`;

//     fetch(url, {
//             method: 'GET',
//         })
//         .then(response => {
//             if (!response.ok) {
//                 throw new Error(`HTTP error! status: ${response.status}`);
//             }
//             return response.json();
//         })
//         .then(data => {
//             customUrlInput.value = data.page_url;
//         })
//         .catch(error => console.error('Error:', error));
// }

