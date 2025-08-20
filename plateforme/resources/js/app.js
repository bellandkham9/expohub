import './bootstrap';

import * as bootstrap from 'bootstrap';


document.addEventListener('DOMContentLoaded', function () {
    const dropdownTrigger = document.querySelector('[data-bs-toggle="dropdown"]');
    const dropdown = new bootstrap.Dropdown(dropdownTrigger);

                                // Tu peux forcer le toggle à l'ouverture pour tester :
    dropdownTrigger.addEventListener('click', function (e) {
        e.preventDefault();
        dropdown.toggle();
    });
});