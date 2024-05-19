<?php

use boctulus\TolScraper\core\libs\Url;

?>

<div class="container mt-4">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="ejecutar-orden-tab" data-bs-toggle="tab" data-bs-target="#ejecutar-orden" type="button" role="tab" aria-controls="ejecutar-orden" aria-selected="true" data-slug="ejecutar-orden">Ejecutar Orden</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="resultado-tab" data-bs-toggle="tab" data-bs-target="#resultado" type="button" role="tab" aria-controls="resultado" aria-selected="false" data-slug="resultado">Resultado</button>
        </li>
        <li class="ms-auto">
            <button class="btn btn-secondary" id="refreshBtn" style="display: none;">
                <i class="fas fa-sync-alt"></i>
            </button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="ejecutar-orden" role="tabpanel" aria-labelledby="ejecutar-orden-tab">
            <div class="mt-3">
                <textarea class="form-control" id="jsonInput" rows="10" placeholder="Ingresa JSON aquí"></textarea>
                <button class="btn btn-danger mt-2 float-end me-2" id="clearSentOrderBtn">Limpiar</button>
                <button class="btn btn-primary mt-2 float-end" id="sendJsonBtn">Enviar</button>
            </div>
            <div class="mt-5" id="sentOrderSection">
                <h6>Orden enviada:</h6>
                <textarea class="form-control" id="sentOrderTextarea" rows="10" readonly></textarea>
            </div>
        </div>
        <div class="tab-pane fade" id="resultado" role="tabpanel" aria-labelledby="resultado-tab">
            <div class="mt-3">
                <div class="mb-3">
                    <img src="<?= shortcode_asset(__DIR__ . '/img/no-image.jpg') ?>" alt="Resultado" class="img-fluid w-100">
                </div>
                <div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" style="max-width: 70px;">Fecha y Hora</th>
                                <th scope="col" style="max-width: 70px;">Archivo</th>
                                <th scope="col" style="max-width: 70px;">Estado</th>
                                <th scope="col">Mensaje de Error</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- datos a rellenar -->
                            <td style="max-width: 70px;"></td>
                            <td style="max-width: 70px;"></td>
                            <td style="max-width: 70px;"></td>
                            <td></td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/*
    VER RESULTADO
*/

// URL de la imagen por defecto
const defaultImg = '<?= shortcode_asset(__DIR__ . '/img/no-image.jpg') ?>';
const base_url   = '<?= Url::getBaseUrl() ?>';
let pollingInterval;

// Función para realizar AJAX polling
function fetchDataAndUpdateTable() {
    // Endpoint al que se enviará la solicitud AJAX
    const endpoint = base_url + '/robot/status';

    // Intervalo de tiempo para realizar la solicitud (en milisegundos)
    const interval = 1000; // Se realiza cada 1 segundo

    // Función para realizar la solicitud AJAX
    function fetchData() {
        console.log('solicitando ...');

        // Realizar la solicitud AJAX
        fetch(endpoint)
            .then(response => response.json())
            .then(data => {
                // Verificar si el estado final es "completed" o "failed"
                const finalStatus = data.data.robot_status;
                if (finalStatus === 'completed' || finalStatus === 'failed') {
                    // Detener el AJAX polling si el estado final es alcanzado
                    clearInterval(pollingInterval);
                    pollingInterval = null;
                }
                
                // Actualizar la tabla con los nuevos datos
                updateTable(data.data);
            })
            .catch(error => {
                console.error('Error al obtener los datos:', error);
            });
    }

    // Función para actualizar la tabla con los nuevos datos
    function updateTable(data) {
        // Obtener la referencia de la tabla y su cuerpo
        const table = document.querySelector('#resultado table');
        const tbody = table.querySelector('tbody');

        // Limpiar el contenido actual de la tabla
        tbody.innerHTML = '';

        let image_url = defaultImg;
        if (data.last_screenshot != null){
            image_url = base_url + '/robot/screenshots/' + data.last_screenshot;
        }      

        // Crear la fila de la tabla con los datos recibidos
        const row = document.createElement('tr');
        row.innerHTML = `
            <td style="max-width: 100px;">${data.execution_datetime}</td>
            <td style="max-width: 100px;">${data.order_file}</td>
            <td style="max-width: 70px;">${data.robot_status}</td>
            <td>${data.error_msg || 'N/A'}</td>
        `;

        // Agregar la fila a la tabla
        tbody.appendChild(row);

        // Actualizar la imagen con la URL de la captura de pantalla
        const img = document.querySelector('#resultado img');
        img.src = image_url;
    }

    // Realizar la primera solicitud de inmediato
    fetchData();

    // Configurar el intervalo para realizar el AJAX polling si no está ya iniciado
    if (!pollingInterval) {
        pollingInterval = setInterval(fetchData, interval);
    }
}

/*
    ENVIAR ORDEN
*/

// Función para enviar el JSON al endpoint
function sendJson() {
    // Obtener el contenido del textarea con el JSON
    const jsonInput = document.getElementById('jsonInput');
    const json = jsonInput.value.trim();

    // Verificar que el JSON no esté vacío
    if (json === '') {
        alert('El JSON no puede estar vacío');
        return;
    }

    // Configurar la solicitud HTTP POST
    const requestOptions = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: json
    };

    // Enviar la solicitud al endpoint
    fetch(base_url + '/robot/order', requestOptions)
        .then(response => {
            // Verificar si la solicitud fue exitosa
            if (!response.ok) {
                throw new Error('Error al enviar el JSON');
            }
            // Mostrar mensaje de éxito
            alert('JSON enviado con éxito');
            // Limpiar el contenido del textarea
            jsonInput.value = '';

            // Mostrar la orden enviada en el segundo textarea
            showSentOrder(json);
        })
        .catch(error => {
            console.error('Error al enviar el JSON:', error);
            // Mostrar mensaje de error
            alert('Error al enviar el JSON');
        });
}

// Función para mostrar la orden enviada en el segundo textarea
function showSentOrder(json) {
    // Obtener el textarea de la orden enviada
    const sentOrderTextarea = document.getElementById('sentOrderTextarea');
    // Mostrar la orden enviada
    sentOrderTextarea.value = json;
    // Habilitar el textarea para que sea editable
    sentOrderTextarea.readOnly = false;
    // Guardar la orden en localStorage
    localStorage.setItem('lastOrder', json);
}

// Función para cargar la última orden desde localStorage
function loadLastOrder() {
    const lastOrder = localStorage.getItem('lastOrder');
    if (lastOrder) {
        const sentOrderTextarea = document.getElementById('sentOrderTextarea');
        sentOrderTextarea.value = lastOrder;
    }
}

// Evento click del botón de enviar
document.getElementById('sendJsonBtn').addEventListener('click', sendJson);

// Evento click del botón de limpiar
document.getElementById('clearSentOrderBtn').addEventListener('click', () => {
    const sentOrderTextarea = document.getElementById('sentOrderTextarea');
    sentOrderTextarea.value = '';
    localStorage.removeItem('lastOrder');
});

// Función para manejar el cambio de pestañas y actualizar la URL
function handleTabChange(event) {
    const targetTab = event.target;
    const slug = targetTab.getAttribute('data-slug');
    if (slug) {
        history.pushState(null, '', '#' + slug);
        // Mostrar u ocultar el botón de refrescar
        const refreshBtn = document.getElementById('refreshBtn');
        if (slug === 'resultado') {
            refreshBtn.style.display = 'block';
        } else {
            refreshBtn.style.display = 'none';
        }
    }
}

// Función para activar la pestaña correcta al cargar la página
function activateTabFromUrl() {
    const hash = window.location.hash.substring(1);
    if (hash) {
        const targetTabButton = document.querySelector(`#myTab button[data-slug="${hash}"]`);
        if (targetTabButton) {
            const tab = new bootstrap.Tab(targetTabButton);
            tab.show();
        }
    }
}

// Agregar el evento a cada botón de pestaña
document.querySelectorAll('#myTab button').forEach(button => {
    button.addEventListener('shown.bs.tab', handleTabChange);
});

// Activar la pestaña correcta al cargar la página
document.addEventListener('DOMContentLoaded', activateTabFromUrl);
document.addEventListener('DOMContentLoaded', loadLastOrder);
document.addEventListener('DOMContentLoaded', () => {
    // Llamar a la función para iniciar el AJAX polling
    fetchDataAndUpdateTable();
});

// Evento click del botón de refrescar
document.getElementById('refreshBtn').addEventListener('click', () => {
    if (!pollingInterval) {
        fetchDataAndUpdateTable();
    } else {
        console.log('El polling ya está en ejecución');
    }
});

// Evento click del tab de resultados
document.getElementById('resultado-tab').addEventListener('click', () => {
    if (!pollingInterval) {
        fetchDataAndUpdateTable();
    } else {
        console.log('El polling ya está en ejecución');
    }
});

</script>
