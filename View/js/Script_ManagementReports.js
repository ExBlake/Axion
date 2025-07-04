document.addEventListener("DOMContentLoaded", () => {
    // Mobile sidebar functionality
    const sidebar = document.querySelector(".sidebar")
    const showSidebarBtn = document.getElementById("show-sidebar-btn")
    const sidebarToggle = document.getElementById("sidebar-toggle")

    // Create overlay element if it doesn't exist
    let overlay = document.querySelector(".sidebar-overlay")
    if (!overlay) {
        overlay = document.createElement("div")
        overlay.className = "sidebar-overlay"
        document.body.appendChild(overlay)
    }

    // Function to open sidebar on mobile
    function openSidebar() {
        sidebar.classList.add("active")
        overlay.classList.add("active")
        document.body.style.overflow = "hidden"
    }

    // Function to close sidebar on mobile
    function closeSidebar() {
        sidebar.classList.remove("active")
        overlay.classList.remove("active")
        document.body.style.overflow = ""
    }

    // Toggle sidebar on button click
    if (showSidebarBtn) {
        showSidebarBtn.addEventListener("click", () => {
            openSidebar()
        })
    }

    // Close sidebar when clicking the toggle button inside sidebar
    if (sidebarToggle) {
        sidebarToggle.addEventListener("click", () => {
            closeSidebar()
        })
    }

    // Close sidebar when clicking the overlay
    overlay.addEventListener("click", () => {
        closeSidebar()
    })

    // Close sidebar when pressing Escape key
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && sidebar.classList.contains("active")) {
            closeSidebar()
        }
    })

    // Check window size and adjust sidebar accordingly
    function checkWindowSize() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove("active")
            overlay.classList.remove("active")
            document.body.style.overflow = ""
        }
    }

    // Listen for window resize
    window.addEventListener("resize", checkWindowSize)
    checkWindowSize()

    // Toggle between grid and list view
    const viewOptions = document.querySelectorAll(".view-option")
    const reportsGrid = document.getElementById("reports-grid")
    const reportsList = document.getElementById("reports-list")

    viewOptions.forEach((option) => {
        option.addEventListener("click", function () {
            // Remove active class from all options
            viewOptions.forEach((opt) => opt.classList.remove("active"))

            // Add active class to clicked option
            this.classList.add("active")

            // Show the corresponding view
            const viewType = this.getAttribute("data-view")
            if (viewType === "grid") {
                reportsGrid.style.display = "grid"
                reportsList.style.display = "none"
            } else if (viewType === "list") {
                reportsGrid.style.display = "none"
                reportsList.style.display = "block"
            }

            // Save preference in localStorage
            localStorage.setItem("reportsViewPreference", viewType)
        })
    })

    // Initialize view based on saved preference
    const savedViewPreference = localStorage.getItem("reportsViewPreference")
    if (savedViewPreference) {
        const option = document.querySelector(`.view-option[data-view="${savedViewPreference}"]`)
        if (option) {
            option.click()
        }
    }

    // Search functionality
    const searchInput = document.getElementById("report-search")
    const clearSearchBtn = document.getElementById("clear-search")
    const reportCards = document.querySelectorAll(".report-card")
    const reportRows = document.querySelectorAll(".table-row")

    function filterReports() {
        const searchTerm = searchInput.value.toLowerCase().trim()

        // Si el campo de búsqueda está vacío, mostrar todos los informes
        if (searchTerm === "") {
            reportCards.forEach((card) => {
                card.style.display = "flex"
            })

            reportRows.forEach((row) => {
                if (!row.classList.contains("table-header")) {
                    row.style.display = "flex"
                }
            })

            clearSearchBtn.style.display = "none"
            return
        }

        // Filtrado normal
        reportCards.forEach((card) => {
            const name = card.querySelector("h3")?.textContent.toLowerCase() || ""
            const company = card.querySelector(".report-company span")?.textContent.toLowerCase() || ""
            const description = card.querySelector(".report-description p")?.textContent.toLowerCase() || ""
            const type = card.querySelector(".report-type")?.textContent.toLowerCase() || ""
            const status = card.querySelector(".report-status")?.textContent.toLowerCase() || ""
            const author = card.getAttribute("data-author")?.toLowerCase() || ""
            const department = card.getAttribute("data-department")?.toLowerCase() || ""

            const matchesSearch = [name, company, description, type, status, author, department].some(field =>
                field.includes(searchTerm)
            )

            card.style.display = matchesSearch ? "flex" : "none"
        })

        reportRows.forEach((row) => {
            if (row.classList.contains("table-header")) return

            const name = row.querySelector(".report-title")?.textContent.toLowerCase() || ""
            const company = row.querySelector(".cell-company")?.textContent.toLowerCase() || ""
            const type = row.querySelector(".type-badge")?.textContent.toLowerCase() || ""
            const status = row.querySelector(".status-badge")?.textContent.toLowerCase() || ""
            const author = row.querySelector(".cell-author")?.textContent.toLowerCase() || ""

            const matchesSearch = [name, company, type, status, author].some(field =>
                field.includes(searchTerm)
            )

            row.style.display = matchesSearch ? "flex" : "none"
        })

        // Mostrar botón para limpiar búsqueda si hay texto
        clearSearchBtn.style.display = searchTerm.length > 0 ? "flex" : "none"
    }

    // Search input event
    if (searchInput) {
        searchInput.addEventListener("input", filterReports)
    }

    // Clear search button
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener("click", () => {
            searchInput.value = ""
            filterReports()
        })
    }

    // Copy URL functionality
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            // Show a temporary success message
            const notification = document.createElement('div')
            notification.textContent = 'URL copiada al portapapeles'
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: var(--primary-color);
                color: white;
                padding: 12px 16px;
                border-radius: 8px;
                z-index: 10000;
                font-size: 14px;
                font-weight: 500;
            `
            document.body.appendChild(notification)
            
            setTimeout(() => {
                document.body.removeChild(notification)
            }, 2000)
        }).catch(() => {
            alert('Error al copiar la URL')
        })
    }

    // Copy URL buttons in cards
    document.addEventListener('click', (e) => {
        if (e.target.closest('.copy-url-btn')) {
            const card = e.target.closest('.report-card') || e.target.closest('.table-row')
            if (card) {
                const url = card.getAttribute('data-url')
                if (url) {
                    copyToClipboard(url)
                }
            }
        }
    })

    // Open Power BI buttons
    document.addEventListener('click', (e) => {
        if (e.target.closest('.open-powerbi-btn')) {
            const btn = e.target.closest('.open-powerbi-btn')
            const url = btn.getAttribute('data-url')
            if (url) {
                window.open(url, '_blank')
            }
        }
    })

    // Modal functionality
    const reportModal = document.getElementById("report-modal")
    const reportDetailsModal = document.getElementById("report-details-modal")
    const addReportBtns = document.querySelectorAll("#add-report-btn, #add-report-btn-main")
    const modalClose = document.getElementById("modal-close")
    const detailsModalClose = document.getElementById("details-modal-close")
    const cancelReportBtn = document.getElementById("cancel-report")
    const saveReportBtn = document.getElementById("save-report")
    const editReportBtn = document.getElementById("edit-report")
    const closeDetailsBtn = document.getElementById("close-details")
    const editFromDetailsBtn = document.getElementById("edit-from-details")
    const modalTitle = document.getElementById("modal-title")
    const reportForm = document.getElementById("report-form")

    // Open add report modal
    addReportBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            modalTitle.textContent = "Nuevo Informe Power BI"
            reportForm.reset()
            reportModal.classList.add("active")
            document.body.style.overflow = "hidden"
            reportModal.setAttribute("data-report-id", "")

            // Mostrar solo el botón Guardar
            saveReportBtn.style.display = "inline-block"
            editReportBtn.style.display = "none"

            // Set current report ID to null to indicate we're adding a new report
            reportModal.setAttribute("data-report-id", "")
        })
    })

    // Close report modal
    function closeReportModal() {
        reportModal.classList.remove("active")
        document.body.style.overflow = ""
    }

    if (modalClose) {
        modalClose.addEventListener("click", closeReportModal)
    }

    if (cancelReportBtn) {
        cancelReportBtn.addEventListener("click", closeReportModal)
    }

    // Close details modal
    function closeDetailsModal() {
        reportDetailsModal.classList.remove("active")
        document.body.style.overflow = ""
    }

    if (detailsModalClose) {
        detailsModalClose.addEventListener("click", closeDetailsModal)
    }

    if (closeDetailsBtn) {
        closeDetailsBtn.addEventListener("click", closeDetailsModal)
    }

    // Edit from details
    if (editFromDetailsBtn) {
        editFromDetailsBtn.addEventListener("click", () => {
            const reportId = reportDetailsModal.getAttribute("data-report-id")
            closeDetailsModal()
            openEditModal(reportId)
        })
    }

    // Close modals when clicking outside
    window.addEventListener("click", (e) => {
        if (e.target.classList.contains("modal-backdrop")) {
            closeReportModal()
            closeDetailsModal()
        }
    })

    // Close modals when pressing Escape key
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            if (reportModal && reportModal.classList.contains("active")) {
                closeReportModal()
            }
            if (reportDetailsModal && reportDetailsModal.classList.contains("active")) {
                closeDetailsModal()
            }
        }
    })

    // View report details
    const viewReportBtns = document.querySelectorAll(".view-report-btn")

    viewReportBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
            // Get the report card or row
            const reportElement = this.closest(".report-card") || this.closest(".table-row")
            const reportId = reportElement.getAttribute("data-id") || generateId()

            // Store the report ID in the modal for reference
            reportDetailsModal.setAttribute("data-report-id", reportId)

            // Populate details modal with report information
            populateDetailsModal(reportElement)

            // Show the details modal
            reportDetailsModal.classList.add("active")
            document.body.style.overflow = "hidden"
        })
    })

    // Function to populate details modal
    function populateDetailsModal(reportElement) {
        const data = reportElement.dataset
        
        // Asignar valores al modal
        document.getElementById("details-name").textContent = data.nombre_informe
        document.getElementById("details-company").textContent = data.company
        document.getElementById("details-status").textContent = data.status
        document.getElementById("details-status").className = "report-status " + data.status.toLowerCase().replace(" ", "-")
        document.getElementById("details-url").value = data.url
        document.getElementById("details-created").textContent = data.created
        document.getElementById("details-updated").textContent = data.updated
        document.getElementById("details-plan-badge").textContent = data.plan

        // Set up copy URL button in details
        const copyUrlDetailsBtn = document.getElementById("copy-url-details")
        const openPowerBIDetailsBtn = document.getElementById("open-powerbi-details")
        
        if (copyUrlDetailsBtn) {
            copyUrlDetailsBtn.onclick = () => copyToClipboard(data.url)
        }
        
        if (openPowerBIDetailsBtn) {
            openPowerBIDetailsBtn.onclick = () => window.open(data.url, '_blank')
        }

        // Copy URL button in details modal
        const detailsCopyBtn = document.querySelector("#report-details-modal .copy-url-btn")
        if (detailsCopyBtn) {
            detailsCopyBtn.onclick = () => copyToClipboard(data.url)
        }
    }

    // Edit report
    const editReportBtns = document.querySelectorAll(".edit-report-btn")

    editReportBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
            // Get the report card or row
            const reportElement = this.closest(".report-card") || this.closest(".table-row")
            const reportId = reportElement.getAttribute("data-id") || generateId()

            openEditModal(reportId, reportElement)
        })
    })

    // Function to open edit modal
    function openEditModal(reportId, reportElement) {
        if (!reportElement) {
            // If reportElement is not provided, find it by ID
            reportElement = document.querySelector(`.report-card[data-id="${reportId}"]`) ||
                          document.querySelector(`.table-row[data-id="${reportId}"]`)

            // If still not found, try to get it from the details modal
            if (!reportElement) {
                const detailsName = document.getElementById("details-name").textContent
                reportCards.forEach((card) => {
                    if (card.querySelector("h3").textContent === detailsName) {
                        reportElement = card
                    }
                })
            }
        }

        if (!reportElement) return

        modalTitle.textContent = "Editar Informe Power BI"

        // Store the report ID in the modal for reference
        reportModal.setAttribute("data-report-id", reportId)

        // Populate form with report data
        populateEditForm(reportElement)

        // Show the modal
        reportModal.classList.add("active")
        document.body.style.overflow = "hidden"
        saveReportBtn.style.display = "none"
        editReportBtn.style.display = "inline-block"
    }

    // Function to populate edit form
    function populateEditForm(reportElement) {
        const data = reportElement.dataset

        // Asignar valores al formulario
        document.getElementById("report-id").value = data.id
        document.getElementById("report-nombre").value = data.nombre_informe
        // document.getElementById("report-status").textContent = data.status
        document.getElementById("report-company").value = data.companyId;
        document.getElementById("report-url").value = data.url;
        document.getElementById("report-plan").value = data.planId;
    }

    // Initialize the page
    filterReports()



    // Apply user settings function
    function applyUserSettings() {
        console.log("Aplicando configuraciones de usuario...")

        // Theme
        const savedTheme = localStorage.getItem("theme")
        const darkModeEnabled = localStorage.getItem("darkMode") === "enabled"

        if (savedTheme === "dark" || darkModeEnabled) {
            document.body.classList.add("dark-mode")
            document.documentElement.style.setProperty("--text-color", "#ffffff")
            document.documentElement.style.setProperty("--text-secondary", "#a0a0a0")
            document.documentElement.style.setProperty("--background-color", "#1c1c1e")
            document.documentElement.style.setProperty("--panel-color", "#2c2c2e")
            document.documentElement.style.setProperty("--border-color", "#3c3c3e")
            document.documentElement.style.setProperty("--gray-5", "#5c5c5e")
            document.documentElement.style.setProperty("--gray-6", "#48484a")
            document.documentElement.style.setProperty("--gray-7", "#3a3a3c")
        } else {
            document.body.classList.remove("dark-mode")
            document.documentElement.style.setProperty("--text-color", "#000000")
            document.documentElement.style.setProperty("--text-secondary", "#666666")
            document.documentElement.style.setProperty("--background-color", "#f2f2f7")
            document.documentElement.style.setProperty("--panel-color", "#ffffff")
            document.documentElement.style.setProperty("--border-color", "#e5e5ea")
            document.documentElement.style.setProperty("--gray-5", "#e5e5ea")
            document.documentElement.style.setProperty("--gray-6", "#f2f2f7")
            document.documentElement.style.setProperty("--gray-7", "#f9f9f9")
        }

        // Accent color
        const savedColor = localStorage.getItem("accentColor") || "#007AFF"
        document.documentElement.style.setProperty("--primary-color", savedColor)

        function hexToRgb(hex) {
            if (hex.startsWith("#")) {
                hex = hex.substring(1)
            }
            if (hex.length === 3) {
                hex = hex.split("").map((char) => char + char).join("")
            }
            const r = Number.parseInt(hex.substring(0, 2), 16)
            const g = Number.parseInt(hex.substring(2, 4), 16)
            const b = Number.parseInt(hex.substring(4, 6), 16)
            return { r, g, b }
        }

        const colorRGB = hexToRgb(savedColor)
        if (colorRGB) {
            const rgbValue = `${colorRGB.r}, ${colorRGB.g}, ${colorRGB.b}`
            document.documentElement.style.setProperty("--primary-color-rgb", rgbValue)
            const lightColor = `rgba(${colorRGB.r}, ${colorRGB.g}, ${colorRGB.b}, 0.1)`
            document.documentElement.style.setProperty("--primary-light", lightColor)
        }

        // Font family
        const savedFontFamily = localStorage.getItem("fontFamily") || '"SF Pro Display", -apple-system, BlinkMacSystemFont, sans-serif'
        document.documentElement.style.setProperty("--font-family", savedFontFamily)
        document.documentElement.style.fontFamily = savedFontFamily
        document.body.style.fontFamily = savedFontFamily

        // Font weight
        const savedFontWeight = localStorage.getItem("fontWeight") || "400"
        document.documentElement.style.setProperty("--font-weight", savedFontWeight)

        // Animations
        const savedAnimations = localStorage.getItem("animations")
        if (savedAnimations === "disabled") {
            document.body.classList.add("no-animations")
        } else {
            document.body.classList.remove("no-animations")
        }

        // Animation speed
        const savedSpeed = localStorage.getItem("animationSpeed") || "normal"
        let speedValue = "0.2s"
        if (savedSpeed === "slow") {
            speedValue = "0.4s"
        } else if (savedSpeed === "fast") {
            speedValue = "0.1s"
        }
        document.documentElement.style.setProperty("--animation-speed", speedValue)

        // High contrast
        const savedHighContrast = localStorage.getItem("highContrast")
        if (savedHighContrast === "enabled") {
            document.body.classList.add("high-contrast")
        } else {
            document.body.classList.remove("high-contrast")
        }

        // Border radius
        const savedBorderRadius = localStorage.getItem("borderRadius") || "normal"
        let cardRadius = "16px"
        let buttonRadius = "10px"
        let inputRadius = "10px"

        if (savedBorderRadius === "rounded") {
            cardRadius = "20px"
            buttonRadius = "12px"
            inputRadius = "12px"
        } else if (savedBorderRadius === "square") {
            cardRadius = "4px"
            buttonRadius = "4px"
            inputRadius = "4px"
        }

        document.documentElement.style.setProperty("--card-radius", cardRadius)
        document.documentElement.style.setProperty("--button-radius", buttonRadius)
        document.documentElement.style.setProperty("--input-radius", inputRadius)

        // Layout density
        document.body.classList.remove("compact-layout", "spacious-layout")
        const savedDensity = localStorage.getItem("layoutDensity") || "normal"
        if (savedDensity === "compact") {
            document.body.classList.add("compact-layout")
        } else if (savedDensity === "spacious") {
            document.body.classList.add("spacious-layout")
        }

        // Custom CSS
        const customCSS = localStorage.getItem("customCSS")
        if (customCSS) {
            let styleElement = document.getElementById("custom-user-styles")
            if (!styleElement) {
                styleElement = document.createElement("style")
                styleElement.id = "custom-user-styles"
                document.head.appendChild(styleElement)
            }
            styleElement.textContent = customCSS
        }
    }

    // Apply settings on load
    applyUserSettings()
    setTimeout(applyUserSettings, 100)
    setTimeout(applyUserSettings, 500)

    // Listen for storage changes
    window.addEventListener("storage", applyUserSettings)

    // Create mutation observer for new elements
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === "childList" && mutation.addedNodes.length > 0) {
                applyUserSettings()
            }
        })
    })

    observer.observe(document.body, { childList: true, subtree: true })

    // Apply settings periodically
    const settingsInterval = setInterval(applyUserSettings, 2000)

    // Cleanup on page unload
    window.addEventListener("beforeunload", () => {
        clearInterval(settingsInterval)
        observer.disconnect()
    })

    const ReportingForm = document.getElementById('report-form');
    const saveReportingBtnEnd = document.getElementById('save-report');
    const editCompanyBtnEnd = document.getElementById('edit-report');
    const accionInput = document.getElementById('accion-form');

   // Botón para registrar nueva reporte
    if (saveReportingBtnEnd && ReportingForm) {
        saveReportingBtnEnd.addEventListener('click', function () {
            accionInput.value = 'Registrar_Reporting';
            ReportingForm.submit();
        });
    }

    // Botón para editar reporte
    if (editCompanyBtnEnd && ReportingForm) {
        editCompanyBtnEnd.addEventListener('click', function () {
            accionInput.value = 'Editar_Reporting';
            ReportingForm.submit();
        });
    }


})