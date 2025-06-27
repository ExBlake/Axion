document.addEventListener('DOMContentLoaded', function() {
    // Referencias a elementos del DOM
    const pqrGrid = document.getElementById('pqr-grid');
    const pqrList = document.getElementById('pqr-list');
    const viewButtons = document.querySelectorAll('.view-btn');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const searchInput = document.getElementById('pqr-search');
    const clearSearchBtn = document.getElementById('clear-search');
    const addPqrBtn = document.getElementById('add-pqr-btn');
    const pqrModal = document.getElementById('pqr-modal');
    const modalClose = document.getElementById('modal-close');
    const cancelPqrBtn = document.getElementById('cancel-pqr');
    const pqrForm = document.getElementById('pqr-form');
    const viewPqrBtns = document.querySelectorAll('.view-pqr-btn');
    const editPqrBtns = document.querySelectorAll('.edit-pqr-btn');
    const pqrDetailsModal = document.getElementById('pqr-details-modal');
    const detailsModalClose = document.getElementById('details-modal-close');
    const closeDetailsBtn = document.getElementById('close-details');
    const editFromDetailsBtn = document.getElementById('edit-from-details');
    const fileUploadArea = document.getElementById('file-upload-area');
    const fileInput = document.getElementById('pqr-attachments-input');
    const fileList = document.getElementById('file-list');
    const responseForm = document.getElementById('response-form');
    const savePqrExterno = document.getElementById('save-pqr-externo');

    //Enviar el formulario
    if (savePqrExterno && pqrForm) {
        savePqrExterno.addEventListener('click', function () {
            pqrForm.submit();
        });
    }
    //Manejo de archivos
    if (fileUploadArea && fileInput) {
        // Clic en toda el área
        fileUploadArea.addEventListener('click', function () {
            fileInput.click();
          
        });

        // También capturamos clic solo en el texto
        const browseElements = fileUploadArea.querySelectorAll('.file-upload-browse');
        browseElements.forEach(el => {
            el.addEventListener('click', function (e) {
                e.stopPropagation(); // evita doble trigger
                fileInput.click();
            });
        });

        // Drag & Drop
        fileUploadArea.addEventListener('dragover', function (e) {
            e.preventDefault();
            this.closest('.file-upload-container').classList.add('dragover');
        });

        fileUploadArea.addEventListener('dragleave', function (e) {
            e.preventDefault();
            this.closest('.file-upload-container').classList.remove('dragover');
        });

        fileUploadArea.addEventListener('drop', function (e) {
            e.preventDefault();
            this.closest('.file-upload-container').classList.remove('dragover');

            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                updateFileList();
            }
        });

        fileInput.addEventListener('change', updateFileList);

        function updateFileList() {
            if (fileList) {
                fileList.innerHTML = '';

                for (const file of fileInput.files) {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item';

                    let icon = 'fa-file';
                    if (file.type.startsWith('image/')) {
                        icon = 'fa-file-image';
                    } else if (file.type === 'application/pdf') {
                        icon = 'fa-file-pdf';
                    } else if (file.type.includes('word')) {
                        icon = 'fa-file-word';
                    } else if (file.type.includes('excel') || file.type.includes('sheet')) {
                        icon = 'fa-file-excel';
                    } else if (file.type.includes('text')) {
                        icon = 'fa-file-alt';
                    }

                    fileItem.innerHTML = `
                        <i class="fas ${icon}"></i>
                        <span>${file.name}</span>
                        <span class="file-remove" data-name="${file.name}">
                            <i class="fas fa-times"></i>
                        </span>
                    `;

                    fileList.appendChild(fileItem);
                }

                // Opción de eliminación visual (nota: no elimina del input real)
                document.querySelectorAll('.file-remove').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const fileName = this.getAttribute('data-name');
                        this.closest('.file-item').remove();
                        // ⚠️ Nota: no se puede eliminar directamente del input 'files' por limitaciones de seguridad del navegador
                        alert('El archivo se eliminará visualmente, pero no se puede eliminar del input real por seguridad del navegador. Para evitar enviarlo, vuelve a seleccionar los archivos deseados.');
                    });
                });
            }
        }
    }
    
    
    // Cambiar entre vista de cuadrícula y lista
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const view = this.getAttribute('data-view');
            
            viewButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            if (view === 'grid') {
                pqrGrid.style.display = 'grid';
                pqrList.style.display = 'none';
            } else {
                pqrGrid.style.display = 'none';
                pqrList.style.display = 'block';
            }
        });
    });

    // Filtrar PQRs por tipo y estado
    let currentTypeFilter = 'all';
    let currentStatusFilter = 'all';

    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            const type = this.getAttribute('data-filter');
            const status = this.getAttribute('data-status');

            // Actualizar los valores actuales de filtro
            if (type !== null) {
                currentTypeFilter = type;
                // Desactivar botones del grupo de tipo
                this.closest('.filter-options').querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            }
            if (status !== null) {
                currentStatusFilter = status;
                // Desactivar botones del grupo de estado
                this.closest('.filter-options').querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            }

            this.classList.add('active');

            // Aplicar filtros combinados
            const pqrItems = document.querySelectorAll('.pqr-item, .pqr-list-row');
            pqrItems.forEach(item => {
                const itemType = item.getAttribute('data-type');
                const itemStatus = item.getAttribute('data-status');

                const matchType = currentTypeFilter === 'all' || itemType === currentTypeFilter;
                const matchStatus = currentStatusFilter === 'all' || itemStatus === currentStatusFilter;

                item.style.display = (matchType && matchStatus) ? '' : 'none';
            });
        });
    });


    // Búsqueda de PQRs
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        const pqrItems = document.querySelectorAll('.pqr-item');
        const pqrRows = document.querySelectorAll('.pqr-list-row');
        
        pqrItems.forEach(item => {
            // Obtener texto de título y descripción
            const title = item.querySelector('.pqr-title').textContent.toLowerCase();
            const description = item.querySelector('.pqr-description').textContent.toLowerCase();
            
            // Obtener valores de los atributos 'data-'
            const type = item.getAttribute('data-type') ? item.getAttribute('data-type').toLowerCase() : '';
            const status = item.getAttribute('data-status') ? item.getAttribute('data-status').toLowerCase() : '';
            
            // Obtener texto de los metadatos
            const username = item.querySelector('.pqr-meta-item span').textContent.toLowerCase();
            const creationDate = item.querySelector('.pqr-meta-item span:nth-child(2)').textContent.toLowerCase();
            const responseDate = item.querySelector('.pqr-meta-item span:nth-child(4)') ? item.querySelector('.pqr-meta-item span:nth-child(4)').textContent.toLowerCase() : '';
            
            // Verificar si alguno de los valores contiene el término de búsqueda
            if (title.includes(searchTerm) || description.includes(searchTerm) ||
                type.includes(searchTerm) || status.includes(searchTerm) ||
                username.includes(searchTerm) || creationDate.includes(searchTerm) ||
                responseDate.includes(searchTerm)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
        
        pqrRows.forEach(row => {
            const rowTextContent = Array.from(row.querySelectorAll('.pqr-list-cell')).map(cell => cell.textContent.toLowerCase()).join(" ");
            
            if (rowTextContent.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });


    // Limpiar búsqueda
    clearSearchBtn.addEventListener('click', function() {
        searchInput.value = '';
        const event = new Event('input');
        searchInput.dispatchEvent(event);
    });

    // Abrir modal para añadir PQR
    addPqrBtn.addEventListener('click', function() {
        pqrForm.reset();
        document.getElementById('modal-title').textContent = 'Nuevo PQR';
        pqrModal.classList.add('active');
    });

    // Cerrar modal
    modalClose.addEventListener('click', function() {
        pqrModal.classList.remove('active');
    });

    cancelPqrBtn.addEventListener('click', function() {
        pqrModal.classList.remove('active');
    });

    // Ver detalles del PQR
    viewPqrBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Aquí cargaríamos los detalles del PQR específico
            pqrDetailsModal.classList.add('active');
        });
    });

    // Cerrar modal de detalles
    detailsModalClose.addEventListener('click', function() {
        pqrDetailsModal.classList.remove('active');
    });

    closeDetailsBtn.addEventListener('click', function() {
        pqrDetailsModal.classList.remove('active');
    });

    // Editar desde detalles
    editFromDetailsBtn.addEventListener('click', function() {
        pqrDetailsModal.classList.remove('active');
        // Aquí cargaríamos los datos del PQR en el formulario
        document.getElementById('modal-title').textContent = 'Editar PQR';
        pqrModal.classList.add('active');
    });

    // Editar PQR
    editPqrBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Aquí cargaríamos los datos del PQR en el formulario
            document.getElementById('modal-title').textContent = 'Editar PQR';
            pqrModal.classList.add('active');
        });
    });

    

    // Enviar respuesta
    if (responseForm) {
        responseForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const responseText = document.getElementById('response-text').value;
            
            if (responseText.trim() !== '') {
                const responsesList = document.getElementById('details-responses');
                
                const timelineItem = document.createElement('div');
                timelineItem.className = 'timeline-item';
                
                const currentDate = new Date();
                const formattedDate = `${currentDate.getDate()}/${currentDate.getMonth() + 1}/${currentDate.getFullYear()} ${currentDate.getHours()}:${currentDate.getMinutes()}`;
                
                timelineItem.innerHTML = `
                    <div class="timeline-icon">
                        <i class="fas fa-comment-alt"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <span class="timeline-author">Usuario Actual</span>
                            <span class="timeline-date">${formattedDate}</span>
                        </div>
                        <div class="timeline-body">
                            <p>${responseText}</p>
                        </div>
                    </div>
                `;
                
                responsesList.appendChild(timelineItem);
                document.getElementById('response-text').value = '';
            }
        });
    }

    // Cerrar modales al hacer clic fuera de ellos
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-backdrop')) {
            pqrModal.classList.remove('active');
            pqrDetailsModal.classList.remove('active');
        }
    });

     // Details del PQRS
    function populatePQRDetailsModal(pqrElement) {
        const data = pqrElement.dataset;
        // Guardar el Id_PQRS en el input oculto
        const hiddenInput = document.getElementById("hidden-pqr-id");
        if (hiddenInput) {
            hiddenInput.value = data.id;
        }
        // Intentar parsear archivos
        let archivosData = [];
        try {
            archivosData = data.archivos ? JSON.parse(data.archivos) : [];
        } catch (e) {
            console.warn("Error al parsear archivos:", e);
        }

        // Rellenar campos del modal
        document.getElementById("details-type").textContent = data.type;
        document.getElementById("details-type").className = "pqr-badge " + data.type.toLowerCase();

        document.getElementById("details-status").textContent = data.status;
        document.getElementById("details-status").className = "pqr-status " + data.status.toLowerCase();

        document.getElementById("details-date").textContent = data.fechaCreacion;
        document.getElementById("timeline-date").textContent = data.fechaCreacion;
        document.getElementById("details-subject").textContent = data.asunto;
        document.getElementById("details-description").textContent = data.descripcion;
        document.getElementById("details-name").textContent = data.usuario;
        document.getElementById("details-email").textContent = data.correo || "No disponible";
        document.getElementById("details-id").textContent = data.identificacion || "No disponible";
        document.getElementById("details-company").textContent = data.empresa || "No disponible";

        // Mostrar solo si hay respuesta válida (no vacía, no 'Sin respuesta')
        if (data.respuesta && data.respuesta.trim() !== '' && data.respuesta !== 'Sin respuesta') {
            document.getElementById("timeline-body-respond").textContent = data.respuesta;
            document.getElementById("timeline-date-respond").textContent = data.fechaRespuesta;
            document.getElementById("details-responses-admin").style.display = "block";
        } else {
            document.getElementById("details-responses-admin").style.display = "none";
        }


        const archivosContainer = document.getElementById("details-attachments");
        archivosContainer.innerHTML = "";

        if (archivosData.length > 0) {
            archivosData.forEach(archivo => {
                const extension = archivo.nombre.split('.').pop().toLowerCase();
                let iconClass = "fas fa-file";
                let iconType = "default";

                if (["pdf"].includes(extension)) {
                    iconClass = "fas fa-file-pdf";
                    iconType = "pdf";
                } else if (["jpg", "jpeg", "png", "gif", "bmp", "webp"].includes(extension)) {
                    iconClass = "fas fa-file-image";
                    iconType = "image";
                } else if (["doc", "docx"].includes(extension)) {
                    iconClass = "fas fa-file-word";
                    iconType = "word";
                } else if (["xls", "xlsx", "csv"].includes(extension)) {
                    iconClass = "fas fa-file-excel";
                    iconType = "excel";
                } else if (["txt"].includes(extension)) {
                    iconClass = "fas fa-file-alt";
                    iconType = "text";
                }

                // Crear el contenedor del archivo
                const item = document.createElement("div");
                item.className = "attachment-item";

                // Icono
                const iconDiv = document.createElement("div");
                iconDiv.className = "attachment-icon " + iconType;
                iconDiv.innerHTML = `<i class="${iconClass}"></i>`;
                item.appendChild(iconDiv);

                // Info
                const infoDiv = document.createElement("div");
                infoDiv.className = "attachment-info";
                const nameSpan = document.createElement("span");
                nameSpan.className = "attachment-name";
                nameSpan.textContent = archivo.nombre;
                const sizeSpan = document.createElement("span");
                sizeSpan.className = "attachment-size";
                sizeSpan.textContent = archivo.tamano || ""; // Opcional
                infoDiv.appendChild(nameSpan);
                infoDiv.appendChild(sizeSpan);
                item.appendChild(infoDiv);

                // Link de descarga forzado
                const downloadLink = document.createElement("a");
                downloadLink.href = "#";
                downloadLink.className = "attachment-download";
                downloadLink.title = "Descargar";
                downloadLink.innerHTML = `<i class="fas fa-download"></i>`;

                downloadLink.addEventListener("click", (e) => {
                    e.preventDefault();

                    // Crear un enlace temporal para descargar
                    const a = document.createElement("a");
                    a.href = archivo.ruta;
                    a.download = archivo.nombre;
                    a.style.display = "none";

                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                });

                item.appendChild(downloadLink);

                // Añadir al contenedor
                archivosContainer.appendChild(item);
            });
        } else {
            archivosContainer.innerHTML = "<p>No hay archivos adjuntos</p>";
        }

        // Mostrar respuesta
        const responseField = document.getElementById("details-response");
        responseField.textContent = data.respuesta || "Sin respuesta";

        // Abrir el modal
        document.getElementById("pqr-details-modal").classList.add("open");
    }

    // Evento click para cada tarjeta o fila de la lista
    document.querySelectorAll(".pqr-item, .pqr-list-row").forEach(element => {
        element.addEventListener("click", () => {
            populatePQRDetailsModal(element);
        });
    });

});

