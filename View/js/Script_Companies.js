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
        document.body.style.overflow = "hidden" // Prevent scrolling when sidebar is open
    }

    // Function to close sidebar on mobile
    function closeSidebar() {
        sidebar.classList.remove("active")
        overlay.classList.remove("active")
        document.body.style.overflow = "" // Restore scrolling
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
            // On desktop, remove active classes
            sidebar.classList.remove("active")
            overlay.classList.remove("active")
            document.body.style.overflow = ""
        }
    }

    // Listen for window resize
    window.addEventListener("resize", checkWindowSize)

    // Initial check
    checkWindowSize()

    // Toggle between grid and list view
    const viewOptions = document.querySelectorAll(".view-option")
    const companiesGrid = document.getElementById("companies-grid")
    const companiesList = document.getElementById("companies-list")

    viewOptions.forEach((option) => {
        option.addEventListener("click", function () {
            // Remove active class from all options
            viewOptions.forEach((opt) => opt.classList.remove("active"))

            // Add active class to clicked option
            this.classList.add("active")

            // Show the corresponding view
            const viewType = this.getAttribute("data-view")
            if (viewType === "grid") {
                companiesGrid.style.display = "grid"
                companiesList.style.display = "none"
            } else if (viewType === "list") {
                companiesGrid.style.display = "none"
                companiesList.style.display = "block"
            }

            // Save preference in localStorage
            localStorage.setItem("companiesViewPreference", viewType)
        })
    })

    // Initialize view based on saved preference
    const savedViewPreference = localStorage.getItem("companiesViewPreference")
    if (savedViewPreference) {
        const option = document.querySelector(`.view-option[data-view="${savedViewPreference}"]`)
        if (option) {
            option.click()
        }
    }

    // Search functionality
    const searchInput = document.getElementById("company-search")
    const clearSearchBtn = document.getElementById("clear-search")
    const companyCards = document.querySelectorAll(".company-card")
    const companyRows = document.querySelectorAll(".table-row")

    function filterCompanies() {
        const searchTerm = searchInput.value.toLowerCase().trim();

        // Si el campo de búsqueda está vacío, mostrar todas las empresas sin importar el filtro
        if (searchTerm === "") {
            companyCards.forEach((card) => {
                card.style.display = "flex";
            });

            companyRows.forEach((row) => {
                row.style.display = "flex";
            });

            clearSearchBtn.style.display = "none";
            return;
        }

        // Filtrado normal
        companyCards.forEach((card) => {
            const name = card.querySelector("h3")?.textContent.toLowerCase() || "";
            const idEmpresa = card.querySelector(".meta-item:nth-child(1) span")?.textContent.toLowerCase() || "";
            const descripcion = card.querySelector(".company-description")?.textContent.toLowerCase() || "";
            const categoria = card.querySelector(".company-industry:nth-child(1)")?.textContent.toLowerCase() || "";
            const estado = card.querySelector(".company-industry:nth-child(2)")?.textContent.toLowerCase() || "";
            const ubicacion = card.querySelector(".meta-item:nth-child(2) span")?.textContent.toLowerCase() || "";

            const matchesSearch = [name, idEmpresa, descripcion, categoria, estado, ubicacion].some(field =>
                field.includes(searchTerm)
            );

            card.style.display = matchesSearch ? "flex" : "none";
        });

        companyRows.forEach((row) => {
            const name = row.querySelector(".company-cell span")?.textContent.toLowerCase() || "";
            const categoria = row.querySelector(".industry-badge")?.textContent.toLowerCase() || "";
            const ubicacion = row.children[2]?.textContent.toLowerCase() || "";
            const estado = row.querySelector(".status-badge")?.textContent.toLowerCase() || "";

            const matchesSearch = [name, categoria, ubicacion, estado].some(field =>
                field.includes(searchTerm)
            );

            row.style.display = matchesSearch ? "flex" : "none";
        });

        // Mostrar botón para limpiar búsqueda si hay texto
        clearSearchBtn.style.display = searchTerm.length > 0 ? "flex" : "none";
    }



    // Search input event
    searchInput.addEventListener("input", filterCompanies)

    // Clear search button
    clearSearchBtn.addEventListener("click", () => {
        searchInput.value = ""
        filterCompanies()
    })

    // Modal functionality
    const companyModal = document.getElementById("company-modal")
    const companyDetailsModal = document.getElementById("company-details-modal")
    const addCompanyBtn = document.getElementById("add-company-btn")
    const modalClose = document.getElementById("modal-close")
    const detailsModalClose = document.getElementById("details-modal-close")
    const cancelCompanyBtn = document.getElementById("cancel-company")
    const saveCompanyBtn = document.getElementById("save-company")
    const editCompanyBtn = document.getElementById("edit-company")
    const closeDetailsBtn = document.getElementById("close-details")
    const editFromDetailsBtn = document.getElementById("edit-from-details")
    const modalTitle = document.getElementById("modal-title")
    const companyForm = document.getElementById("company-form")

    // Company logo preview functionality
    const logoInput = document.getElementById("company-logo-input")
    const logoPreview = document.getElementById("logo-preview-image")

    logoInput.addEventListener("change", function () {
        const file = this.files[0]
        if (file) {
            const reader = new FileReader()
            reader.onload = (e) => {
                logoPreview.style.backgroundImage = `url(${e.target.result})`
            }
            reader.readAsDataURL(file)
        }
    })

    // Open add company modal
    addCompanyBtn.addEventListener("click", () => {
        modalTitle.textContent = "Nueva Empresa"
        companyForm.reset()
        logoPreview.style.backgroundImage = "url('https://via.placeholder.com/80')"
        companyModal.classList.add("active")
        document.body.style.overflow = "hidden"
        companyModal.setAttribute("data-company-id", "")

        // Mostrar solo el botón Guardar
        saveCompanyBtn.style.display = "inline-block"
        editCompanyBtn.style.display = "none"
    
        // Set current company ID to null to indicate we're adding a new company
        companyModal.setAttribute("data-company-id", "")
    })

    // Close company modal
    function closeCompanyModal() {
        companyModal.classList.remove("active")
        document.body.style.overflow = ""
    }

    modalClose.addEventListener("click", closeCompanyModal)
    cancelCompanyBtn.addEventListener("click", closeCompanyModal)

    // Close details modal
    function closeDetailsModal() {
        companyDetailsModal.classList.remove("active")
        document.body.style.overflow = ""
    }

    detailsModalClose.addEventListener("click", closeDetailsModal)
    closeDetailsBtn.addEventListener("click", closeDetailsModal)

    // Edit from details
    editFromDetailsBtn.addEventListener("click", () => {
        const companyId = companyDetailsModal.getAttribute("data-company-id")
        closeDetailsModal()
        openEditModal(companyId)
    })

    // Close modals when clicking outside
    window.addEventListener("click", (e) => {
        if (e.target.classList.contains("modal-backdrop")) {
            closeCompanyModal()
            closeDetailsModal()
        }
    })

    // Close modals when pressing Escape key
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            closeCompanyModal()
            closeDetailsModal()
        }
    })

    // View company details
    const viewCompanyBtns = document.querySelectorAll(".view-company-btn")

    viewCompanyBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
            // Get the company card or row
            const companyElement = this.closest(".company-card") || this.closest(".table-row")
            const companyId = companyElement.getAttribute("data-id") || generateId()

            // Store the company ID in the modal for reference
            companyDetailsModal.setAttribute("data-company-id", companyId)

            // Populate details modal with company information
            populateDetailsModal(companyElement)

            // Show the details modal
            companyDetailsModal.classList.add("active")
            document.body.style.overflow = "hidden"
        })
    })

    // Function to populate details modal
    function populateDetailsModal(companyElement) {
        // Get company data
        let companyName,
            companyIndustry,
            companyStatus,
            companyDescription,
            companyLocation,
            companyWebsite,
            companyEmployees,
            companyFounded,
            companyMarketValue,
            companyRating,
            companyLogo

        if (companyElement.classList.contains("company-card")) {
            // Grid view
            companyName = companyElement.querySelector("h3").textContent
            companyIndustry = companyElement.querySelector(".company-industry").textContent
            companyStatus = companyElement.querySelector(".company-status span").textContent
            companyDescription = companyElement.querySelector(".company-description").textContent

            const metaItems = companyElement.querySelectorAll(".meta-item")
            companyLocation = metaItems[0].querySelector("span").textContent
            companyEmployees = metaItems[1].querySelector("span").textContent
            companyFounded = metaItems[2].querySelector("span").textContent
            companyWebsite = metaItems[3].querySelector("span").textContent

            const statItems = companyElement.querySelectorAll(".stat-item")
            companyMarketValue = statItems[0].querySelector(".stat-value").textContent
            const projects = statItems[1].querySelector(".stat-value").textContent
            companyRating = statItems[2].querySelector(".stat-value").textContent

            companyLogo = companyElement.querySelector(".company-logo img").getAttribute("src")

            // Set details in modal
            document.getElementById("details-name").textContent = companyName
            document.getElementById("details-industry").textContent = companyIndustry
            document.getElementById("details-industry").className =
                "company-industry " + companyElement.querySelector(".company-industry").classList[1]
            document.getElementById("details-status").textContent = companyStatus
            document.getElementById("details-status").className =
                "company-status " + companyElement.querySelector(".company-status").classList[1]
            document.getElementById("details-description").textContent = companyDescription
            document.getElementById("details-location").textContent = companyLocation
            document.getElementById("details-website").textContent = companyWebsite
            document.getElementById("details-employees").textContent = companyEmployees
            document.getElementById("details-founded").textContent = companyFounded
            document.getElementById("details-market-value").textContent = companyMarketValue
            document.getElementById("details-projects").textContent = projects
            document.getElementById("details-rating").textContent = companyRating

            // Set logo
            document.getElementById("details-logo").innerHTML = `<img src="${companyLogo}" alt="${companyName}">`
            document.getElementById("details-logo").className =
                "company-details-logo " + companyElement.querySelector(".company-logo").classList[1]
        } else {
            // Obtenemos todos los datos desde los atributos data-* del elemento
            const data = companyElement.dataset;
            const companyNit = data.nit;
            const companyName = data.nombre;
            const companyIndustry = data.categoria;
            const companyLocation = data.ubicacion;
            const companyFoundedC = data.fechacreacion;
            const companyFoundedA = data.fechaactualizacion;
            const companyEmployees = data.usuarios;
            const companyMarketValue = data.planes;
            const companyLogo = data.logo;


            // Opcionalmente si quieres mantener estas variables también
            let companyDescription = "";
            let companyWebsite = "";
            let projects = "";
            let companyRating = "";

            // Buscar la card correspondiente solo si necesitas esos datos visuales adicionales
            const correspondingCard = findCorrespondingCard(companyName);
            if (correspondingCard) {
                companyDescription = correspondingCard.querySelector(".company-description")?.textContent || "";
                companyWebsite = correspondingCard.querySelectorAll(".meta-item")[3]?.querySelector("span")?.textContent || "";

                const statItems = correspondingCard.querySelectorAll(".stat-item");
                projects = statItems[1]?.querySelector(".stat-value")?.textContent || "";
                companyRating = statItems[2]?.querySelector(".stat-value")?.textContent || "";
            }

            // Asignar valores al modal
            document.getElementById("details-name").textContent = companyName;
            document.getElementById("details-industry").textContent = companyIndustry;
            document.getElementById("details-industry").className =
                "company-industry " + companyIndustry.toLowerCase();
            document.getElementById("details-description").textContent = companyDescription;
            document.getElementById("details-location").textContent = companyNit;
            document.getElementById("details-website").textContent = companyWebsite;
            document.getElementById("details-employees").textContent = companyLocation;
            document.getElementById("details-founded").textContent = companyFoundedA;
            document.getElementById("details-market-value").textContent = companyEmployees;
            document.getElementById("details-projects").textContent = companyMarketValue;
            document.getElementById("details-rating").textContent = companyFoundedC;

            document.getElementById("details-logo").innerHTML = `<img src="${companyLogo}" alt="${companyName}">`;
            document.getElementById("details-logo").className =
                "company-details-logo " + companyElement.querySelector(".company-logo-small")?.classList[1];
        }

    }

    // Function to find corresponding card by company name
    function findCorrespondingCard(companyName) {
        let foundCard = null
        companyCards.forEach((card) => {
            const cardName = card.querySelector("h3").textContent
            if (cardName === companyName) {
                foundCard = card
            }
        })
        return foundCard
    }

    // Edit company
    const editCompanyBtns = document.querySelectorAll(".edit-company-btn")

    editCompanyBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
            // Get the company card or row
            const companyElement = this.closest(".company-card") || this.closest(".table-row")
            const companyId = companyElement.getAttribute("data-id") || generateId()

            openEditModal(companyId, companyElement)
        })
    })

    // Function to open edit modal
    function openEditModal(companyId, companyElement) {
        if (!companyElement) {
            // If companyElement is not provided, find it by ID
            companyElement =
                document.querySelector(`.company-card[data-id="${companyId}"]`) ||
                document.querySelector(`.table-row[data-id="${companyId}"]`)

            // If still not found, try to get it from the details modal
            if (!companyElement) {
                const detailsName = document.getElementById("details-name").textContent
                companyCards.forEach((card) => {
                    if (card.querySelector("h3").textContent === detailsName) {
                        companyElement = card
                    }
                })
            }
        }

        if (!companyElement) return

        modalTitle.textContent = "Editar Empresa"


        // Store the company ID in the modal for reference
        companyModal.setAttribute("data-company-id", companyId)

        // Populate form with company data
        populateEditForm(companyElement)

        // Show the modal
        companyModal.classList.add("active")
        document.body.style.overflow = "hidden"
        saveCompanyBtn.style.display = "none"
        editCompanyBtn.style.display = "inline-block"
    }

    // Function to populate edit form
    function populateEditForm(companyElement) {
        let companyId,
            companyNit,
            companyName,
            companyIndustry,
            companyStatus,
            companyDescription,
            companyLocation,
            companyWebsite,
            companyLogo

        if (companyElement.classList.contains("company-card")) {
            // Vista tipo tarjeta
            companyId = companyElement.getAttribute("data-id")
            companyNit = companyElement.getAttribute("data-nit")
            companyName = companyElement.getAttribute("data-nombre")
            companyIndustry = companyElement.getAttribute("data-categoria")
            companyStatus = companyElement.getAttribute("data-estado")
            companyLocation = companyElement.getAttribute("data-ubicacion")
            companyDescription = companyElement.getAttribute("data-descripcion")
            companyWebsite = companyElement.getAttribute("data-web")
            companyLogo = companyElement.getAttribute("data-logo")

        } else {
            // Vista tipo tabla
            companyId = companyElement.getAttribute("data-id")
            companyNit = companyElement.getAttribute("data-nit")
            companyName = companyElement.getAttribute("data-nombre")
            companyIndustry = companyElement.getAttribute("data-categoria")
            companyStatus = companyElement.getAttribute("data-estado")
            companyLocation = companyElement.getAttribute("data-ubicacion")
            companyDescription = companyElement.getAttribute("data-descripcion")
            companyWebsite = companyElement.getAttribute("data-web")
            companyLogo = companyElement.getAttribute("data-logo")
        }

        // Asignar valores al formulario
        document.getElementById("company-id").value = companyId
        document.getElementById("company-nit").value = companyNit
        document.getElementById("company-name").value = companyName
        document.getElementById("company-industry").value = companyIndustry
        document.getElementById("company-status").value = companyStatus
        document.getElementById("company-description").value = companyDescription
        document.getElementById("company-ubicacion").value = companyLocation
        document.getElementById("company-website").value = companyWebsite
        document.getElementById("foto_actual_edit").value = companyLogo.split('/').pop();

        // Mostrar imagen del logo
        const logoPreview = document.getElementById("logo-preview-image")
        if (logoPreview && companyLogo) {
            logoPreview.style.backgroundImage = `url('${companyLogo}')`
        }
        
    }

    // Helper functions
    function generateId() {
        return "company_" + Math.random().toString(36).substr(2, 9)
    }


    // Initialize the page
    filterCompanies()

    const CompanyForm = document.getElementById('company-form');
    const saveCompanyBtnEnd = document.getElementById('save-company');
    const editCompanyBtnEnd = document.getElementById('edit-company');
    const accionInput = document.getElementById('accion-form');

   // Botón para registrar nueva empresa
    if (saveCompanyBtnEnd && CompanyForm) {
        saveCompanyBtnEnd.addEventListener('click', function () {
            accionInput.value = 'Registrar_Empresa';
            CompanyForm.submit();
        });
    }

    // Botón para editar empresa existente
    if (editCompanyBtnEnd && CompanyForm) {
        editCompanyBtnEnd.addEventListener('click', function () {
            accionInput.value = 'Editar_Empresa';
            CompanyForm.submit();
        });
    }
})

