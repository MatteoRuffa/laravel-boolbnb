import "./bootstrap";
import "~resources/scss/app.scss";
import { Chart } from 'chart.js/auto';

// import "~bootstrap-icons/font/bootstrap-icons.scss";

import * as bootstrap from "bootstrap";
import.meta.glob(["../img/**"]);

const deleteSubmitButtons = document.querySelectorAll(".delete-button");

deleteSubmitButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
        event.preventDefault();

        const dataTitle = button.getAttribute("data-item-title");

        const modal = document.getElementById("deleteModal");

        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();

        const modalItemTitle = modal.querySelector("#modal-item-title");
        
        modalItemTitle.textContent = dataTitle;

        const buttonDelete = modal.querySelector("button.btn-danger");

        buttonDelete.addEventListener("click", () => {
            button.parentElement.submit();
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const modalInfo = new bootstrap.Modal(document.getElementById('staticBackdropInfo'));

    document.querySelectorAll('.open-modal-info').forEach(function(button) {
        button.addEventListener('click', function(event) {
            const title = this.getAttribute('data-title');
            const description = this.getAttribute('data-description');
            const created = this.getAttribute('data-created');
            const categories = this.getAttribute('data-categories');

            document.getElementById('modalTitleInfo').innerHTML = `<strong>Title:</strong> ${title}`;
            document.getElementById('modalDescriptionInfo').innerHTML = `<strong>Description:</strong> ${description}`;
            document.getElementById('modalCreatedInfo').innerHTML = `<strong>Created at:</strong> ${created}`;
            document.getElementById('modalCategoriesInfo').innerHTML = `<strong>Category:</strong> ${categories}`;

            modalInfo.show();
        });
    });
});

const image = document.getElementById("uploadImage");

//se esiste nella pagina
if (image) {
    image.addEventListener("change", () => {
        //console.log(image.files[0]);
        //prendo l'elemento ing dove voglio la preview
        const preview = document.getElementById("uploadPreview");

        //creo nuoco oggetto file reader
        const oFReader = new FileReader();

        //uso il metodo readAsDataURL dell'oggetto creato per leggere il file
        oFReader.readAsDataURL(image.files[0]);

        //al termine della lettura del file
        oFReader.onload = function (event) {
            //metto nel src della preview l'immagine
            preview.src = event.target.result;
        };
    });
}

//nicolai inizio
// Dati fittizi nel dashboard per i grafici (puoi sostituire con dati reali quando disponibili)
const analyticsData = {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [{
        label: 'Messages',
        data: [12, 19, 3, 5, 2, 3, 9],
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
    }]
};

const contabilityData = {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    datasets: [{
        label: 'Income',
        data: [12, 19, 3, 5, 2, 3],
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderColor: 'rgba(255, 99, 132, 1)',
        borderWidth: 1
    }]
};

const viewsData = {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [{
        label: 'Page Views',
        data: [65, 59, 80, 81, 56, 55, 40],
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
    }]
};

document.addEventListener('DOMContentLoaded', function () {
    const ctx1 = document.getElementById('analyticsChart');
    new Chart(ctx1, {
        type: 'bar',
        data: analyticsData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctx2 = document.getElementById('contabilityChart');
    new Chart(ctx2, {
        type: 'bar',
        data: contabilityData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctx3 = document.getElementById('viewsChart');
    new Chart(ctx3, {
        type: 'line',
        data: viewsData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});


