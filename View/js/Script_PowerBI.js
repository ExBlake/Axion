document.addEventListener("DOMContentLoaded", () => {
    // Funcionalidad para el botón de expandir
    const expandBtn = document.querySelector('.powerbi-actions .btn-icon[title="Expandir"]');
    const powerbiContainer = document.querySelector('.powerbi-container');
    const powerbiContent = document.querySelector('.powerbi-content');
    
    if (expandBtn && powerbiContainer && powerbiContent) {
        let isExpanded = false;
        
        expandBtn.addEventListener('click', () => {
            if (!isExpanded) {
                // Expandir
                powerbiContainer.style.position = 'fixed';
                powerbiContainer.style.top = '0';
                powerbiContainer.style.left = '0';
                powerbiContainer.style.width = '100%';
                powerbiContainer.style.height = '100%';
                powerbiContainer.style.zIndex = '1000';
                powerbiContainer.style.borderRadius = '0';
                powerbiContent.style.height = 'calc(100% - 73px)'; // Ajustar por el header
                document.body.style.overflow = 'hidden';
                expandBtn.innerHTML = '<i class="fas fa-compress"></i>';
                expandBtn.title = "Contraer";
            } else {
                // Contraer
                powerbiContainer.style.position = '';
                powerbiContainer.style.top = '';
                powerbiContainer.style.left = '';
                powerbiContainer.style.width = '';
                powerbiContainer.style.height = '';
                powerbiContainer.style.zIndex = '';
                powerbiContainer.style.borderRadius = '';
                powerbiContent.style.height = '';
                document.body.style.overflow = '';
                expandBtn.innerHTML = '<i class="fas fa-expand"></i>';
                expandBtn.title = "Expandir";
            }
            
            isExpanded = !isExpanded;
        });
    }
    
    // Funcionalidad para el botón de refrescar (ahora realmente recarga el iframe)
    const refreshBtn = document.querySelector('.powerbi-actions .btn-icon[title="Refrescar datos"]');
    
    if (refreshBtn) {
        refreshBtn.addEventListener('click', () => {
            // Buscar el iframe de Power BI
            const powerBIFrame = document.querySelector('.powerbi-content iframe');
            
            if (powerBIFrame) {
                // Mostrar indicador de carga
                const loadingIndicator = document.createElement('div');
                loadingIndicator.className = 'powerbi-loading';
                loadingIndicator.innerHTML = `
                    <div class="loading-spinner">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                    <p>Actualizando datos...</p>
                `;
                
                powerbiContent.appendChild(loadingIndicator);
                
                // Recargar el iframe
                const currentSrc = powerBIFrame.src;
                powerBIFrame.src = 'about:blank';
                
                setTimeout(() => {
                    powerBIFrame.src = currentSrc;
                    
                    // Cuando el iframe termine de cargar, quitar el indicador
                    powerBIFrame.onload = () => {
                        if (loadingIndicator && loadingIndicator.parentNode) {
                            loadingIndicator.parentNode.removeChild(loadingIndicator);
                        }
                        showNotification('Datos actualizados correctamente');
                    };
                }, 100);
            } else {
                // Si no hay iframe (estamos en modo placeholder), simular recarga
                const placeholder = document.querySelector('.powerbi-placeholder');
                if (placeholder) {
                    const originalIcon = placeholder.querySelector('.placeholder-icon').innerHTML;
                    const originalText = placeholder.querySelector('p').textContent;
                    
                    placeholder.querySelector('.placeholder-icon').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    placeholder.querySelector('p').textContent = 'Actualizando datos...';
                    
                    setTimeout(() => {
                        placeholder.querySelector('.placeholder-icon').innerHTML = originalIcon;
                        placeholder.querySelector('p').textContent = originalText;
                        showNotification('Datos actualizados correctamente');
                    }, 2000);
                }
            }
        });
    }
    
    // Funcionalidad para el botón de opciones (ahora con menú desplegable)
    const optionsBtn = document.querySelector('.powerbi-actions .btn-icon[title="Más opciones"]');
    
    if (optionsBtn) {
        // Crear el menú de opciones
        const optionsMenu = document.createElement('div');
        optionsMenu.className = 'options-menu';
        optionsMenu.innerHTML = `
            <div class="options-menu-arrow"></div>
            <ul>
                <li data-action="fullscreen"><i class="fas fa-expand"></i> Vista completa</li>
                <li data-action="print"><i class="fas fa-print"></i> Imprimir</li>
                <li data-action="export-pdf"><i class="fas fa-file-pdf"></i> Exportar a PDF</li>
                <li data-action="export-excel"><i class="fas fa-file-excel"></i> Exportar a Excel</li>
                <li class="divider"></li>
                <li data-action="filters"><i class="fas fa-filter"></i> Mostrar filtros</li>
                <li data-action="bookmarks"><i class="fas fa-bookmark"></i> Marcadores</li>
                <li class="divider"></li>
                <li data-action="settings"><i class="fas fa-cog"></i> Configuración</li>
                <li data-action="help"><i class="fas fa-question-circle"></i> Ayuda</li>
            </ul>
        `;
        
        // Añadir el menú al DOM pero oculto
        document.body.appendChild(optionsMenu);
        
        // Posicionar y mostrar/ocultar el menú al hacer clic en el botón
        optionsBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            
            const btnRect = optionsBtn.getBoundingClientRect();
            optionsMenu.style.top = (btnRect.bottom + 10) + 'px';
            optionsMenu.style.right = (window.innerWidth - btnRect.right) + 'px';
            
            // Toggle del menú
            if (optionsMenu.classList.contains('active')) {
                optionsMenu.classList.remove('active');
            } else {
                optionsMenu.classList.add('active');
            }
        });
        
        // Cerrar el menú al hacer clic fuera
        document.addEventListener('click', () => {
            if (optionsMenu.classList.contains('active')) {
                optionsMenu.classList.remove('active');
            }
        });
        
        // Evitar que los clics dentro del menú lo cierren
        optionsMenu.addEventListener('click', (e) => {
            e.stopPropagation();
        });
        
        // Manejar las acciones del menú
        optionsMenu.querySelectorAll('li[data-action]').forEach(item => {
            item.addEventListener('click', () => {
                const action = item.getAttribute('data-action');
                
                // Cerrar el menú
                optionsMenu.classList.remove('active');
                
                // Ejecutar la acción correspondiente
                switch (action) {
                    case 'fullscreen':
                        // Usar la API de Fullscreen si está disponible
                        const powerBIFrame = document.querySelector('.powerbi-content iframe');
                        if (powerBIFrame && powerBIFrame.requestFullscreen) {
                            powerBIFrame.requestFullscreen();
                        } else {
                            // Alternativa: usar el botón de expandir
                            if (expandBtn) expandBtn.click();
                        }
                        break;
                        
                    case 'print':
                        showNotification('Preparando impresión...');
                        setTimeout(() => {
                            const powerBIFrame = document.querySelector('.powerbi-content iframe');
                            if (powerBIFrame) {
                                try {
                                    // Intentar imprimir el contenido del iframe
                                    powerBIFrame.contentWindow.print();
                                } catch (e) {
                                    showNotification('No se puede imprimir el contenido del iframe por restricciones de seguridad');
                                }
                            } else {
                                window.print();
                            }
                        }, 500);
                        break;
                        
                    case 'export-pdf':
                        showExportDialog('PDF');
                        break;
                        
                    case 'export-excel':
                        showExportDialog('Excel');
                        break;
                        
                    case 'filters':
                        toggleFiltersPanel();
                        break;
                        
                    case 'bookmarks':
                        showBookmarksPanel();
                        break;
                        
                    case 'settings':
                        showSettingsPanel();
                        break;
                        
                    case 'help':
                        showHelpPanel();
                        break;
                }
            });
        });
    }
    
    // Funcionalidad para el selector de rango de fechas
    const dateRangeBtn = document.querySelector('.date-range-selector .btn-outline');
    
    if (dateRangeBtn) {
        dateRangeBtn.addEventListener('click', () => {
            // Aquí podrías mostrar un selector de fechas
            showNotification('Selector de fechas');
        });
    }
    
    // Funcionalidad para el botón de exportar
    const exportBtn = document.querySelector('.header-actions .btn-primary');
    
    if (exportBtn) {
        exportBtn.addEventListener('click', () => {
            showExportDialog('Todos los formatos');
        });
    }
    
    // Función para mostrar notificaciones
    function showNotification(message) {
        // Crear elemento de notificación
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        
        // Añadir al DOM
        document.body.appendChild(notification);
        
        // Mostrar con animación
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        // Ocultar después de un tiempo
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Función para mostrar el diálogo de exportación
    function showExportDialog(format) {
        // Crear el diálogo
        const dialog = document.createElement('div');
        dialog.className = 'export-dialog';
        
        let title = 'Exportar datos';
        let options = '';
        
        if (format === 'PDF') {
            title = 'Exportar a PDF';
            options = `
                <div class="export-option">
                    <input type="radio" name="pdf-quality" id="pdf-high" checked>
                    <label for="pdf-high">Alta calidad (Recomendado)</label>
                </div>
                <div class="export-option">
                    <input type="radio" name="pdf-quality" id="pdf-medium">
                    <label for="pdf-medium">Calidad media</label>
                </div>
                <div class="export-option">
                    <input type="checkbox" id="pdf-include-filters" checked>
                    <label for="pdf-include-filters">Incluir filtros aplicados</label>
                </div>
            `;
        } else if (format === 'Excel') {
            title = 'Exportar a Excel';
            options = `
                <div class="export-option">
                    <input type="radio" name="excel-data" id="excel-current" checked>
                    <label for="excel-current">Datos actuales</label>
                </div>
                <div class="export-option">
                    <input type="radio" name="excel-data" id="excel-all">
                    <label for="excel-all">Todos los datos</label>
                </div>
                <div class="export-option">
                    <input type="checkbox" id="excel-include-filters" checked>
                    <label for="excel-include-filters">Incluir filtros aplicados</label>
                </div>
            `;
        } else {
            options = `
                <div class="export-option">
                    <input type="radio" name="export-format" id="format-pdf" checked>
                    <label for="format-pdf">PDF</label>
                </div>
                <div class="export-option">
                    <input type="radio" name="export-format" id="format-excel">
                    <label for="format-excel">Excel</label>
                </div>
                <div class="export-option">
                    <input type="radio" name="export-format" id="format-image">
                    <label for="format-image">Imagen (PNG)</label>
                </div>
                <div class="export-option">
                    <input type="checkbox" id="export-include-filters" checked>
                    <label for="export-include-filters">Incluir filtros aplicados</label>
                </div>
            `;
        }
        
        dialog.innerHTML = `
            <div class="export-dialog-backdrop"></div>
            <div class="export-dialog-container">
                <div class="export-dialog-header">
                    <h3>${title}</h3>
                    <button class="dialog-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="export-dialog-body">
                    ${options}
                </div>
                <div class="export-dialog-footer">
                    <button class="btn btn-secondary dialog-cancel">Cancelar</button>
                    <button class="btn btn-primary dialog-export">Exportar</button>
                </div>
            </div>
        `;
        
        // Añadir al DOM
        document.body.appendChild(dialog);
        
        // Mostrar con animación
        setTimeout(() => {
            dialog.classList.add('show');
        }, 10);
        
        // Manejar cierre del diálogo
        const closeDialog = () => {
            dialog.classList.remove('show');
            setTimeout(() => {
                dialog.remove();
            }, 300);
        };
        
        // Eventos para cerrar
        dialog.querySelector('.dialog-close').addEventListener('click', closeDialog);
        dialog.querySelector('.dialog-cancel').addEventListener('click', closeDialog);
        dialog.querySelector('.export-dialog-backdrop').addEventListener('click', closeDialog);
        
        // Evento para exportar
        dialog.querySelector('.dialog-export').addEventListener('click', () => {
            showNotification('Exportando datos...');
            closeDialog();
            
            // Simular proceso de exportación
            setTimeout(() => {
                showNotification('Exportación completada');
            }, 2000);
        });
    }
    
    // Función para mostrar/ocultar panel de filtros
    function toggleFiltersPanel() {
        let filtersPanel = document.querySelector('.filters-panel');
        
        if (!filtersPanel) {
            // Crear panel de filtros si no existe
            filtersPanel = document.createElement('div');
            filtersPanel.className = 'filters-panel';
            filtersPanel.innerHTML = `
                <div class="filters-panel-header">
                    <h3>Filtros</h3>
                    <button class="filters-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="filters-panel-body">
                    <div class="filter-group">
                        <h4>Fecha</h4>
                        <div class="filter-item">
                            <label for="filter-date-from">Desde:</label>
                            <input type="date" id="filter-date-from">
                        </div>
                        <div class="filter-item">
                            <label for="filter-date-to">Hasta:</label>
                            <input type="date" id="filter-date-to">
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <h4>Categoría</h4>
                        <div class="filter-item">
                            <input type="checkbox" id="filter-cat-1" checked>
                            <label for="filter-cat-1">Ventas</label>
                        </div>
                        <div class="filter-item">
                            <input type="checkbox" id="filter-cat-2" checked>
                            <label for="filter-cat-2">Marketing</label>
                        </div>
                        <div class="filter-item">
                            <input type="checkbox" id="filter-cat-3" checked>
                            <label for="filter-cat-3">Operaciones</label>
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <h4>Región</h4>
                        <div class="filter-item">
                            <input type="checkbox" id="filter-region-1" checked>
                            <label for="filter-region-1">Norte</label>
                        </div>
                        <div class="filter-item">
                            <input type="checkbox" id="filter-region-2" checked>
                            <label for="filter-region-2">Sur</label>
                        </div>
                        <div class="filter-item">
                            <input type="checkbox" id="filter-region-3" checked>
                            <label for="filter-region-3">Este</label>
                        </div>
                        <div class="filter-item">
                            <input type="checkbox" id="filter-region-4" checked>
                            <label for="filter-region-4">Oeste</label>
                        </div>
                    </div>
                </div>
                <div class="filters-panel-footer">
                    <button class="btn btn-secondary filters-reset">Restablecer</button>
                    <button class="btn btn-primary filters-apply">Aplicar</button>
                </div>
            `;
            
            document.body.appendChild(filtersPanel);
            
            // Eventos para el panel de filtros
            filtersPanel.querySelector('.filters-close').addEventListener('click', () => {
                filtersPanel.classList.remove('show');
            });
            
            filtersPanel.querySelector('.filters-reset').addEventListener('click', () => {
                // Restablecer todos los filtros
                filtersPanel.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    checkbox.checked = true;
                });
                
                const today = new Date();
                const thirtyDaysAgo = new Date();
                thirtyDaysAgo.setDate(today.getDate() - 30);
                
                const dateFrom = filtersPanel.querySelector('#filter-date-from');
                const dateTo = filtersPanel.querySelector('#filter-date-to');
                
                if (dateFrom && dateTo) {
                    dateFrom.valueAsDate = thirtyDaysAgo;
                    dateTo.valueAsDate = today;
                }
            });
            
            filtersPanel.querySelector('.filters-apply').addEventListener('click', () => {
                showNotification('Filtros aplicados');
                filtersPanel.classList.remove('show');
                
                // Aquí iría el código para aplicar los filtros al Power BI
                // Por ejemplo, usando la API de Power BI para JavaScript
            });
            
            // Inicializar fechas
            const today = new Date();
            const thirtyDaysAgo = new Date();
            thirtyDaysAgo.setDate(today.getDate() - 30);
            
            const dateFrom = filtersPanel.querySelector('#filter-date-from');
            const dateTo = filtersPanel.querySelector('#filter-date-to');
            
            if (dateFrom && dateTo) {
                dateFrom.valueAsDate = thirtyDaysAgo;
                dateTo.valueAsDate = today;
            }
        }
        
        // Mostrar/ocultar panel
        filtersPanel.classList.toggle('show');
    }
    
    // Función para mostrar panel de marcadores
    function showBookmarksPanel() {
        const bookmarksPanel = document.createElement('div');
        bookmarksPanel.className = 'bookmarks-panel';
        bookmarksPanel.innerHTML = `
            <div class="bookmarks-panel-header">
                <h3>Marcadores</h3>
                <button class="bookmarks-close"><i class="fas fa-times"></i></button>
            </div>
            <div class="bookmarks-panel-body">
                <div class="bookmark-item">
                    <div class="bookmark-info">
                        <h4>Vista general</h4>
                        <p>Creado el 15/04/2023</p>
                    </div>
                    <div class="bookmark-actions">
                        <button class="btn-icon" title="Aplicar marcador"><i class="fas fa-play"></i></button>
                        <button class="btn-icon" title="Eliminar marcador"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div class="bookmark-item">
                    <div class="bookmark-info">
                        <h4>Ventas Q1</h4>
                        <p>Creado el 10/03/2023</p>
                    </div>
                    <div class="bookmark-actions">
                        <button class="btn-icon" title="Aplicar marcador"><i class="fas fa-play"></i></button>
                        <button class="btn-icon" title="Eliminar marcador"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div class="bookmark-item">
                    <div class="bookmark-info">
                        <h4>Comparativa anual</h4>
                        <p>Creado el 22/02/2023</p>
                    </div>
                    <div class="bookmark-actions">
                        <button class="btn-icon" title="Aplicar marcador"><i class="fas fa-play"></i></button>
                        <button class="btn-icon" title="Eliminar marcador"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div class="bookmark-add">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i>
                        <span>Crear nuevo marcador</span>
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(bookmarksPanel);
        
        // Mostrar con animación
        setTimeout(() => {
            bookmarksPanel.classList.add('show');
        }, 10);
        
        // Evento para cerrar
        bookmarksPanel.querySelector('.bookmarks-close').addEventListener('click', () => {
            bookmarksPanel.classList.remove('show');
            setTimeout(() => {
                bookmarksPanel.remove();
            }, 300);
        });
        
        // Eventos para los botones de marcadores
        bookmarksPanel.querySelectorAll('.bookmark-actions .btn-icon').forEach(btn => {
            btn.addEventListener('click', () => {
                if (btn.title === "Aplicar marcador") {
                    const bookmarkName = btn.closest('.bookmark-item').querySelector('h4').textContent;
                    showNotification(`Aplicando marcador: ${bookmarkName}`);
                    
                    // Cerrar panel
                    bookmarksPanel.classList.remove('show');
                    setTimeout(() => {
                        bookmarksPanel.remove();
                    }, 300);
                } else if (btn.title === "Eliminar marcador") {
                    const bookmarkItem = btn.closest('.bookmark-item');
                    const bookmarkName = bookmarkItem.querySelector('h4').textContent;
                    
                    // Animación de eliminación
                    bookmarkItem.style.opacity = '0.5';
                    setTimeout(() => {
                        bookmarkItem.style.height = '0';
                        bookmarkItem.style.padding = '0';
                        bookmarkItem.style.margin = '0';
                        bookmarkItem.style.overflow = 'hidden';
                        
                        setTimeout(() => {
                            bookmarkItem.remove();
                            showNotification(`Marcador eliminado: ${bookmarkName}`);
                        }, 300);
                    }, 300);
                }
            });
        });
        
        // Evento para crear nuevo marcador
        bookmarksPanel.querySelector('.bookmark-add button').addEventListener('click', () => {
            showNotification('Nuevo marcador creado');
            
            // Crear nuevo elemento de marcador
            const newBookmark = document.createElement('div');
            newBookmark.className = 'bookmark-item';
            newBookmark.innerHTML = `
                <div class="bookmark-info">
                    <h4>Nuevo marcador</h4>
                    <p>Creado ahora</p>
                </div>
                <div class="bookmark-actions">
                    <button class="btn-icon" title="Aplicar marcador"><i class="fas fa-play"></i></button>
                    <button class="btn-icon" title="Eliminar marcador"><i class="fas fa-trash"></i></button>
                </div>
            `;
            
            // Añadir al panel
            bookmarksPanel.querySelector('.bookmark-add').before(newBookmark);
            
            // Añadir eventos a los botones
            newBookmark.querySelectorAll('.btn-icon').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (btn.title === "Aplicar marcador") {
                        showNotification('Aplicando marcador: Nuevo marcador');
                        
                        // Cerrar panel
                        bookmarksPanel.classList.remove('show');
                        setTimeout(() => {
                            bookmarksPanel.remove();
                        }, 300);
                    } else if (btn.title === "Eliminar marcador") {
                        newBookmark.style.opacity = '0.5';
                        setTimeout(() => {
                            newBookmark.style.height = '0';
                            newBookmark.style.padding = '0';
                            newBookmark.style.margin = '0';
                            newBookmark.style.overflow = 'hidden';
                            
                            setTimeout(() => {
                                newBookmark.remove();
                                showNotification('Marcador eliminado: Nuevo marcador');
                            }, 300);
                        }, 300);
                    }
                });
            });
            
            // Animar entrada
            newBookmark.style.opacity = '0';
            newBookmark.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                newBookmark.style.opacity = '1';
                newBookmark.style.transform = 'translateY(0)';
            }, 10);
        });
    }
    
    // Función para mostrar panel de configuración
    function showSettingsPanel() {
        const settingsPanel = document.createElement('div');
        settingsPanel.className = 'settings-panel';
        settingsPanel.innerHTML = `
            <div class="settings-panel-header">
                <h3>Configuración</h3>
                <button class="settings-close"><i class="fas fa-times"></i></button>
            </div>
            <div class="settings-panel-body">
                <div class="settings-group">
                    <h4>Visualización</h4>
                    <div class="settings-item">
                        <label for="setting-auto-refresh">Actualización automática</label>
                        <div class="toggle-switch">
                            <input type="checkbox" id="setting-auto-refresh">
                            <span class="toggle-slider"></span>
                        </div>
                    </div>
                    <div class="settings-item">
                        <label for="setting-refresh-interval">Intervalo de actualización</label>
                        <select id="setting-refresh-interval" class="form-select">
                            <option value="5">5 minutos</option>
                            <option value="10">10 minutos</option>
                            <option value="15">15 minutos</option>
                            <option value="30">30 minutos</option>
                            <option value="60">1 hora</option>
                        </select>
                    </div>
                </div>
                
                <div class="settings-group">
                    <h4>Apariencia</h4>
                    <div class="settings-item">
                        <label for="setting-theme">Tema</label>
                        <select id="setting-theme" class="form-select">
                            <option value="light">Claro</option>
                            <option value="dark">Oscuro</option>
                            <option value="system">Sistema</option>
                        </select>
                    </div>
                    <div class="settings-item">
                        <label for="setting-font-size">Tamaño de fuente</label>
                        <select id="setting-font-size" class="form-select">
                            <option value="small">Pequeño</option>
                            <option value="medium" selected>Mediano</option>
                            <option value="large">Grande</option>
                        </select>
                    </div>
                </div>
                
                <div class="settings-group">
                    <h4>Datos</h4>
                    <div class="settings-item">
                        <label for="setting-data-labels">Mostrar etiquetas de datos</label>
                        <div class="toggle-switch">
                            <input type="checkbox" id="setting-data-labels" checked>
                            <span class="toggle-slider"></span>
                        </div>
                    </div>
                    <div class="settings-item">
                        <label for="setting-tooltips">Mostrar tooltips</label>
                        <div class="toggle-switch">
                            <input type="checkbox" id="setting-tooltips" checked>
                            <span class="toggle-slider"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="settings-panel-footer">
                <button class="btn btn-secondary settings-reset">Restablecer</button>
                <button class="btn btn-primary settings-save">Guardar</button>
            </div>
        `;
        
        document.body.appendChild(settingsPanel);
        
        // Mostrar con animación
        setTimeout(() => {
            settingsPanel.classList.add('show');
        }, 10);
        
        // Evento para cerrar
        settingsPanel.querySelector('.settings-close').addEventListener('click', () => {
            settingsPanel.classList.remove('show');
            setTimeout(() => {
                settingsPanel.remove();
            }, 300);
        });
        
        // Eventos para los botones
        settingsPanel.querySelector('.settings-reset').addEventListener('click', () => {
            // Restablecer configuraciones
            settingsPanel.querySelector('#setting-auto-refresh').checked = false;
            settingsPanel.querySelector('#setting-refresh-interval').value = '15';
            settingsPanel.querySelector('#setting-theme').value = 'light';
            settingsPanel.querySelector('#setting-font-size').value = 'medium';
            settingsPanel.querySelector('#setting-data-labels').checked = true;
            settingsPanel.querySelector('#setting-tooltips').checked = true;
            
            showNotification('Configuración restablecida');
        });
        
        settingsPanel.querySelector('.settings-save').addEventListener('click', () => {
            // Guardar configuraciones
            showNotification('Configuración guardada');
            
            // Cerrar panel
            settingsPanel.classList.remove('show');
            setTimeout(() => {
                settingsPanel.remove();
            }, 300);
            
            // Aplicar algunas configuraciones inmediatamente
            const theme = settingsPanel.querySelector('#setting-theme').value;
            if (theme === 'dark') {
                document.body.classList.add('dark-mode');
            } else if (theme === 'light') {
                document.body.classList.remove('dark-mode');
            }
            
            const fontSize = settingsPanel.querySelector('#setting-font-size').value;
            document.documentElement.setAttribute('data-font-size', fontSize);
        });
    }
    
    // Función para mostrar panel de ayuda
    function showHelpPanel() {
        const helpPanel = document.createElement('div');
        helpPanel.className = 'help-panel';
        helpPanel.innerHTML = `
            <div class="help-panel-header">
                <h3>Ayuda</h3>
                <button class="help-close"><i class="fas fa-times"></i></button>
            </div>
            <div class="help-panel-body">
                <div class="help-section">
                    <h4>Navegación</h4>
                    <p>Utilice los controles de navegación para moverse entre las diferentes páginas del informe. Puede hacer clic en las pestañas o utilizar las flechas de navegación.</p>
                </div>
                
                <div class="help-section">
                    <h4>Filtros</h4>
                    <p>Los filtros le permiten ajustar los datos mostrados en el informe. Puede acceder a ellos haciendo clic en el botón "Filtros" en el menú de opciones.</p>
                </div>
                
                <div class="help-section">
                    <h4>Exportación</h4>
                    <p>Para exportar datos, haga clic en el botón "Exportar" en la parte superior derecha. Puede exportar a varios formatos como PDF, Excel o imagen.</p>
                </div>
                
                <div class="help-section">
                    <h4>Actualización de datos</h4>
                    <p>Para actualizar los datos mostrados, haga clic en el botón de actualización en la barra de herramientas del informe.</p>
                </div>
                
                <div class="help-section">
                    <h4>Soporte</h4>
                    <p>Si necesita ayuda adicional, contacte con el equipo de soporte:</p>
                    <a href="mailto:soporte@ejemplo.com" class="help-contact">soporte@ejemplo.com</a>
                </div>
            </div>
            <div class="help-panel-footer">
                <button class="btn btn-primary help-close-btn">Entendido</button>
            </div>
        `;
        
        document.body.appendChild(helpPanel);
        
        // Mostrar con animación
        setTimeout(() => {
            helpPanel.classList.add('show');
        }, 10);
        
        // Eventos para cerrar
        const closeHelp = () => {
            helpPanel.classList.remove('show');
            setTimeout(() => {
                helpPanel.remove();
            }, 300);
        };
        
        helpPanel.querySelector('.help-close').addEventListener('click', closeHelp);
        helpPanel.querySelector('.help-close-btn').addEventListener('click', closeHelp);
    }
    
    // Añadir estilos para los nuevos componentes
    const style = document.createElement('style');
    style.textContent = `
        /* Notificaciones */
        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: var(--primary-color);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1100;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        .notification.show {
            transform: translateY(0);
            opacity: 1;
        }
        
        /* Menú de opciones */
        .options-menu {
            position: absolute;
            background-color: var(--panel-color);
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            width: 220px;
            z-index: 1050;
            opacity: 0;
            transform: translateY(10px);
            pointer-events: none;
            transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 1px solid var(--border-color);
        }
        
        .options-menu.active {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }
        
        .options-menu-arrow {
            position: absolute;
            top: -8px;
            right: 13px;
            width: 16px;
            height: 8px;
            overflow: hidden;
        }
        
        .options-menu-arrow:after {
            content: "";
            position: absolute;
            width: 12px;
            height: 12px;
            background: var(--panel-color);
            transform: translateY(50%) rotate(45deg);
            top: 0;
            left: 2px;
            border-top: 1px solid var(--border-color);
            border-left: 1px solid var(--border-color);
        }
        
        .options-menu ul {
            list-style: none;
            padding: 8px 0;
            margin: 0;
        }
        
        .options-menu li {
            padding: 10px 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background-color 0.2s ease;
        }
        
        .options-menu li:hover {
            background-color: var(--gray-7);
        }
        
        .options-menu li i {
            width: 16px;
            text-align: center;
            color: var(--primary-color);
        }
        
        .options-menu li.divider {
            height: 1px;
            padding: 0;
            margin: 8px 0;
            background-color: var(--border-color);
            cursor: default;
        }
        
        .options-menu li.divider:hover {
            background-color: var(--border-color);
        }
        
        /* Diálogo de exportación */
        .export-dialog {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1100;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .export-dialog.show {
            opacity: 1;
        }
        
        .export-dialog-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }
        
        .export-dialog-container {
            position: relative;
            background-color: var(--panel-color);
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transform: scale(0.95);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        .export-dialog.show .export-dialog-container {
            transform: scale(1);
            opacity: 1;
        }
        
        .export-dialog-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .export-dialog-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .dialog-close {
            background: none;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-secondary);
            transition: all 0.2s ease;
        }
        
        .dialog-close:hover {
            background-color: var(--gray-7);
            color: var(--text-color);
        }
        
        .export-dialog-body {
            padding: 20px;
        }
        
        .export-option {
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .export-option label {
            cursor: pointer;
        }
        
        .export-dialog-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        
        /* Panel de filtros */
        .filters-panel {
            position: fixed;
            top: 0;
            right: 0;
            height: 100%;
            width: 320px;
            background-color: var(--panel-color);
            box-shadow: -5px 0 20px rgba(0, 0, 0, 0.1);
            z-index: 1050;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        .filters-panel.show {
            transform: translateX(0);
        }
        
        .filters-panel-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .filters-panel-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .filters-close {
            background: none;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-secondary);
            transition: all 0.2s ease;
        }
        
        .filters-close:hover {
            background-color: var(--gray-7);
            color: var(--text-color);
        }
        
        .filters-panel-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }
        
        .filter-group {
            margin-bottom: 24px;
        }
        
        .filter-group h4 {
            margin: 0 0 12px 0;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-secondary);
        }
        
        .filter-item {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .filter-item label {
            flex: 1;
            cursor: pointer;
        }
        
        .filter-item input[type="date"] {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background-color: var(--panel-color);
            color: var(--text-color);
            width: 100%;
        }
        
        .filters-panel-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        
        /* Panel de marcadores */
        .bookmarks-panel {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.95);
            background-color: var(--panel-color);
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            z-index: 1050;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            flex-direction: column;
            max-height: 90vh;
        }
        
        .bookmarks-panel.show {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }
        
        .bookmarks-panel-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .bookmarks-panel-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .bookmarks-close {
            background: none;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-secondary);
            transition: all 0.2s ease;
        }
        
        .bookmarks-close:hover {
            background-color: var(--gray-7);
            color: var(--text-color);
        }
        
        .bookmarks-panel-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }
        
        .bookmark-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 12px;
            background-color: var(--gray-7);
            transition: all 0.3s ease;
        }
        
        .bookmark-item:hover {
            background-color: var(--gray-6);
        }
        
        .bookmark-info h4 {
            margin: 0 0 4px 0;
            font-size: 16px;
            font-weight: 500;
        }
        
        .bookmark-info p {
            margin: 0;
            font-size: 12px;
            color: var(--text-secondary);
        }
        
        .bookmark-actions {
            display: flex;
            gap: 8px;
        }
        
        .bookmark-add {
            margin-top: 20px;
            text-align: center;
        }
        
        .btn-outline-primary {
            background-color: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 10px 16px;
            border-radius: var(--button-radius);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        /* Panel de configuración */
        .settings-panel {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.95);
            background-color: var(--panel-color);
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            z-index: 1050;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            flex-direction: column;
            max-height: 90vh;
        }
        
        .settings-panel.show {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }
        
        .settings-panel-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .settings-panel-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .settings-close {
            background: none;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-secondary);
            transition: all 0.2s ease;
        }
        
        .settings-close:hover {
            background-color: var(--gray-7);
            color: var(--text-color);
        }
        
        .settings-panel-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }
        
        .settings-group {
            margin-bottom: 24px;
        }
        
        .settings-group h4 {
            margin: 0 0 12px 0;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-secondary);
        }
        
        .settings-item {
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .form-select {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background-color: var(--panel-color);
            color: var(--text-color);
            min-width: 120px;
        }
        
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 22px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--gray-4);
            transition: .3s;
            border-radius: 34px;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }
        
        input:checked + .toggle-slider {
            background-color: var(--primary-color);
        }
        
        input:checked + .toggle-slider:before {
            transform: translateX(18px);
        }
        
        .settings-panel-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        
        /* Panel de ayuda */
        .help-panel {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.95);
            background-color: var(--panel-color);
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            z-index: 1050;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            flex-direction: column;
            max-height: 90vh;
        }
        
        .help-panel.show {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }
        
        .help-panel-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .help-panel-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .help-close {
            background: none;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-secondary);
            transition: all 0.2s ease;
        }
        
        .help-close:hover {
            background-color: var(--gray-7);
            color: var(--text-color);
        }
        
        .help-panel-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }
        
        .help-section {
            margin-bottom: 24px;
        }
        
        .help-section h4 {
            margin: 0 0 12px 0;
            font-size: 16px;
            font-weight: 600;
        }
        
        .help-section p {
            margin: 0 0 12px 0;
            line-height: 1.6;
        }
        
        .help-contact {
            display: inline-block;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .help-panel-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
        }
        
        /* Indicador de carga para Power BI */
        .powerbi-loading {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(var(--panel-color-rgb, 255, 255, 255), 0.8);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }
        
        .loading-spinner {
            font-size: 32px;
            color: var(--primary-color);
            margin-bottom: 16px;
        }
        
        .powerbi-loading p {
            font-size: 16px;
            font-weight: 500;
            color: var(--text-color);
        }
        
        /* Ajustes para modo oscuro */
        body.dark-mode .options-menu-arrow:after {
            background-color: var(--panel-color);
        }
    `;
    document.head.appendChild(style);
    function initPowerBI() {
        console.log('Power BI inicializado');
    
        setTimeout(() => {
            const iframe = document.createElement('iframe');
            iframe.title = "Reporte Power BI";
            iframe.width = "100%";
            iframe.height = "100%";
    
            // Usa la variable global definida en el PHP
            if (typeof informeUrl !== "undefined" && informeUrl) {
                iframe.src = informeUrl;
            } else {
                iframe.src = "about:blank";
                console.warn("No se encontró el informe para este plan.");
            }
    
            iframe.frameBorder = "0";
            iframe.allowFullscreen = true;
    
            const powerbiContent = document.querySelector('.powerbi-content');
            if (powerbiContent) {
                powerbiContent.innerHTML = '';
                powerbiContent.appendChild(iframe);
            }
        }, 1500);
    }
    
    
    // Inicializar Power BI
    initPowerBI();
});