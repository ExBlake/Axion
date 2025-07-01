// Plans Management JavaScript - Enhanced with Hover Modals

document.addEventListener("DOMContentLoaded", () => {
  // Initialize data
  initializeData()
  
  // Initialize UI
  initializeUI()
  
  // Load and display data
  loadPlansData()
  
  // Event listeners
  setupEventListeners()
  
  // Setup hover modals
  setupHoverModals()
})

// Sample data structure with billing information
let plansData = {
  companies: [
    { id: 1, name: "Apple Inc.", logo: "apple", industry: "Technology", plan: "professional", startDate: "2024-01-15", billingCycle: "monthly", status: "active" },
    { id: 2, name: "Microsoft", logo: "microsoft", industry: "Technology", plan: "enterprise", startDate: "2024-02-01", billingCycle: "yearly", status: "active" },
    { id: 3, name: "Google", logo: "google", industry: "Technology", plan: "premium", startDate: "2024-01-20", billingCycle: "monthly", status: "active" },
    { id: 4, name: "Amazon", logo: "amazon", industry: "E-commerce", plan: "enterprise", startDate: "2024-03-01", billingCycle: "yearly", status: "active" },
    { id: 5, name: "Meta", logo: "meta", industry: "Social Media", plan: "business", startDate: "2024-02-15", billingCycle: "monthly", status: "active" },
    { id: 6, name: "Netflix", logo: "netflix", industry: "Entertainment", plan: "premium", startDate: "2024-01-10", billingCycle: "monthly", status: "active" },
    { id: 7, name: "Spotify", logo: "spotify", industry: "Music", plan: "professional", startDate: "2024-02-20", billingCycle: "yearly", status: "active" },
    { id: 8, name: "Tesla", logo: "tesla", industry: "Automotive", plan: "business", startDate: "2024-01-05", billingCycle: "monthly", status: "active" },
    { id: 9, name: "NVIDIA", logo: "nvidia", industry: "Technology", plan: "enterprise", startDate: "2024-03-15", billingCycle: "yearly", status: "active" },
    { id: 10, name: "Adobe", logo: "adobe", industry: "Software", plan: "professional", startDate: "2024-02-10", billingCycle: "monthly", status: "active" },
    { id: 11, name: "Salesforce", logo: "salesforce", industry: "Technology", plan: "business", startDate: "2024-01-25", billingCycle: "monthly", status: "active" },
    { id: 12, name: "Oracle", logo: "oracle", industry: "Technology", plan: "enterprise", startDate: "2024-02-05", billingCycle: "yearly", status: "active" },
    { id: 13, name: "IBM", logo: "ibm", industry: "Technology", plan: "premium", startDate: "2024-03-10", billingCycle: "monthly", status: "trial" },
    { id: 14, name: "Intel", logo: "intel", industry: "Technology", plan: "business", startDate: "2024-01-30", billingCycle: "monthly", status: "active" },
    { id: 15, name: "Cisco", logo: "cisco", industry: "Technology", plan: "professional", startDate: "2024-02-25", billingCycle: "yearly", status: "active" },
    { id: 16, name: "Zoom", logo: "zoom", industry: "Technology", plan: "starter", startDate: "2024-03-05", billingCycle: "monthly", status: "active" },
    { id: 17, name: "Slack", logo: "slack", industry: "Technology", plan: "professional", startDate: "2024-01-12", billingCycle: "monthly", status: "active" },
    { id: 18, name: "Dropbox", logo: "dropbox", industry: "Technology", plan: "business", startDate: "2024-02-18", billingCycle: "yearly", status: "active" },
    { id: 19, name: "Airbnb", logo: "airbnb", industry: "Travel", plan: "premium", startDate: "2024-01-08", billingCycle: "monthly", status: "active" },
    { id: 20, name: "Uber", logo: "uber", industry: "Transportation", plan: "business", startDate: "2024-03-12", billingCycle: "monthly", status: "active" },
    { id: 21, name: "Startup Co.", logo: "startup", industry: "Technology", plan: null, startDate: null, billingCycle: null, status: null },
    { id: 22, name: "Tech Solutions", logo: "tech", industry: "Technology", plan: null, startDate: null, billingCycle: null, status: null },
    { id: 23, name: "Digital Agency", logo: "digital", industry: "Marketing", plan: null, startDate: null, billingCycle: null, status: null },
    { id: 24, name: "Cloud Services", logo: "cloud", industry: "Technology", plan: null, startDate: null, billingCycle: null, status: null },
    { id: 25, name: "Data Analytics", logo: "data", industry: "Analytics", plan: null, startDate: null, billingCycle: null, status: null }
  ],
  plans: {
    starter: { 
      name: "Starter", 
      price: 19, 
      features: ["Up to 3 users", "5GB storage", "Email support", "Basic features"] 
    },
    professional: {
      name: "Professional",
      price: 49,
      features: ["Up to 15 users", "50GB storage", "Priority support", "Advanced features", "Analytics dashboard"]
    },
    business: {
      name: "Business",
      price: 99,
      features: ["Up to 50 users", "200GB storage", "24/7 support", "All features", "Custom integrations", "API access"]
    },
    premium: {
      name: "Premium",
      price: 199,
      features: ["Up to 100 users", "500GB storage", "Dedicated support", "Premium features", "White-label solution", "Advanced analytics"]
    },
    enterprise: {
      name: "Enterprise",
      price: "Custom",
      features: ["Unlimited users", "Unlimited storage", "Enterprise support", "All features", "Custom development", "SLA guarantee"]
    }
  }
}

let currentPlanForAdding = null

// Initialize default data
function initializeData() {
  const savedData = localStorage.getItem("plansData")
  if (savedData) {
    plansData = JSON.parse(savedData)
  } else {
    saveData()
  }
}

// Save data to localStorage
function saveData() {
  localStorage.setItem("plansData", JSON.stringify(plansData))
}

// Initialize UI components
function initializeUI() {
  // Any initial UI setup
}

// Load and display plans data
function loadPlansData() {
  Object.keys(plansData.plans).forEach((planKey) => {
    updatePlanStats(planKey)
  })
  updateCompaniesView()
}

// Update plan statistics
function updatePlanStats(planKey) {
  const companiesInPlan = plansData.companies.filter(company => company.plan === planKey)
  const countElement = document.getElementById(`${planKey}-count`)
  const revenueElement = document.getElementById(`${planKey}-revenue`)

  if (countElement) {
    countElement.textContent = companiesInPlan.length
  }

  if (revenueElement) {
    const plan = plansData.plans[planKey]
    if (typeof plan.price === "number") {
      const revenue = companiesInPlan.length * plan.price
      revenueElement.textContent = `$${revenue.toLocaleString()}`
    } else {
      revenueElement.textContent = "Custom"
    }
  }
}

// Setup hover modals for features
function setupHoverModals() {
  const featureItems = document.querySelectorAll('.feature-item[data-modal-title]')
  const modal = document.getElementById('feature-modal')
  const modalTitle = document.getElementById('feature-modal-title')
  const modalDescription = document.getElementById('feature-modal-description')
  
  let hoverTimeout

  featureItems.forEach(item => {
    item.addEventListener('mouseenter', (e) => {
      clearTimeout(hoverTimeout)
      
      const title = item.getAttribute('data-modal-title')
      const content = item.getAttribute('data-modal-content')
      
      modalTitle.textContent = title
      modalDescription.textContent = content
      
      // Position modal
      const rect = item.getBoundingClientRect()
      const modalRect = modal.getBoundingClientRect()
      
      let left = rect.left + (rect.width / 2) - 150 // Center modal on item
      let top = rect.top - modalRect.height - 10 // Position above item
      
      // Adjust if modal goes off screen
      if (left < 10) left = 10
      if (left + 300 > window.innerWidth) left = window.innerWidth - 310
      if (top < 10) top = rect.bottom + 10 // Position below if no space above
      
      modal.style.left = left + 'px'
      modal.style.top = top + 'px'
      
      modal.classList.add('show')
    })
    
    item.addEventListener('mouseleave', () => {
      hoverTimeout = setTimeout(() => {
        modal.classList.remove('show')
      }, 100)
    })
  })
  
  // Keep modal open when hovering over it
  modal.addEventListener('mouseenter', () => {
    clearTimeout(hoverTimeout)
  })
  
  modal.addEventListener('mouseleave', () => {
    modal.classList.remove('show')
  })
}

// Update companies view
function updateCompaniesView() {
  const companiesGrid = document.getElementById("companies-grid-main")
  if (!companiesGrid) return

  companiesGrid.innerHTML = ""

  plansData.companies.forEach(company => {
    const companyCard = createCompanyCardMain(company)
    companiesGrid.appendChild(companyCard)
  })
}

// Create main company card
function createCompanyCardMain(company) {
  const card = document.createElement("div")
  card.className = `company-card-main ${company.plan ? '' : 'unassigned'}`

  const planName = company.plan ? plansData.plans[company.plan].name : "Unassigned"
  const planClass = company.plan || "unassigned"

  card.innerHTML = `
    <div class="company-card-header">
      <div class="company-logo-main ${company.logo}">
        ${company.name.charAt(0)}
      </div>
      <div class="company-info-main">
        <h3>${company.name}</h3>
        <p>${company.industry}</p>
      </div>
    </div>
    <div class="company-plan-info">
      <span class="current-plan ${planClass}">${planName}</span>
    </div>
    <div class="company-actions-main">
      <button class="btn btn-small btn-secondary" onclick="changeCompanyPlan(${company.id})">
        <i class="fas fa-exchange-alt"></i>
        Change Plan
      </button>
      <button class="btn btn-small btn-danger" onclick="removeCompany(${company.id})">
        <i class="fas fa-trash"></i>
      </button>
    </div>
  `

  return card
}

// Calculate next payment date
function calculateNextPayment(startDate, billingCycle) {
  if (!startDate || !billingCycle) return "N/A"
  
  const start = new Date(startDate)
  const now = new Date()
  let nextPayment = new Date(start)
  
  if (billingCycle === "monthly") {
    // Add months until we get a future date
    while (nextPayment <= now) {
      nextPayment.setMonth(nextPayment.getMonth() + 1)
    }
  } else if (billingCycle === "yearly") {
    // Add years until we get a future date
    while (nextPayment <= now) {
      nextPayment.setFullYear(nextPayment.getFullYear() + 1)
    }
  }
  
  return nextPayment.toLocaleDateString("en-US", {
    year: "numeric",
    month: "short",
    day: "numeric"
  })
}

// Setup event listeners
function setupEventListeners() {
  // View switching
  const viewOptions = document.querySelectorAll(".view-option")
  viewOptions.forEach((option) => {
    option.addEventListener("click", function () {
      const view = this.getAttribute("data-view")
      switchView(view)
    })
  })

  // Modal controls
  setupModalEventListeners()

  // Add company to plan buttons
  const addCompanyBtns = document.querySelectorAll(".add-company-btn")
  addCompanyBtns.forEach(btn => {
    btn.addEventListener("click", function() {
      const plan = this.getAttribute("data-plan")
      openAddCompanyModal(plan)
    })
  })

  // View companies buttons
  const viewCompaniesBtns = document.querySelectorAll(".view-companies-btn")
  viewCompaniesBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      const plan = this.getAttribute("data-plan")
      showCompaniesModal(plan)
    })
  })

  // Add company buttons
  const addCompanyMainBtn = document.getElementById("add-company-main-btn")
  const addCompanyBtn = document.getElementById("add-company-btn")
  
  if (addCompanyMainBtn) {
    addCompanyMainBtn.addEventListener("click", () => openNewCompanyModal())
  }
  
  if (addCompanyBtn) {
    addCompanyBtn.addEventListener("click", () => openNewCompanyModal())
  }

  // New company form
  const newCompanyForm = document.getElementById("new-company-form")
  if (newCompanyForm) {
    newCompanyForm.addEventListener("submit", handleNewCompanySubmit)
  }

  // Search functionality
  const searchInput = document.getElementById("search-input")
  if (searchInput) {
    searchInput.addEventListener("input", handleSearch)
  }

  // Plan filter
  const planFilter = document.getElementById("plan-filter")
  if (planFilter) {
    planFilter.addEventListener("change", handlePlanFilter)
  }
}

// Setup modal event listeners
function setupModalEventListeners() {
  // Close modal buttons
  const closeButtons = document.querySelectorAll(".modal-close")
  closeButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const modal = this.closest(".modal")
      closeModal(modal)
    })
  })

  // Close modal when clicking outside
  const modals = document.querySelectorAll(".modal")
  modals.forEach((modal) => {
    modal.addEventListener("click", function (e) {
      if (e.target === this) {
        closeModal(this)
      }
    })
  })

  // Cancel buttons
  const cancelNewCompanyBtn = document.getElementById("cancel-new-company")
  if (cancelNewCompanyBtn) {
    cancelNewCompanyBtn.addEventListener("click", () => {
      closeModal(document.getElementById("new-company-modal"))
    })
  }
}

// Switch between views
function switchView(view) {
  // Update view options
  const viewOptions = document.querySelectorAll(".view-option")
  viewOptions.forEach((option) => {
    option.classList.remove("active")
  })
  document.querySelector(`[data-view="${view}"]`).classList.add("active")

  // Update content views
  const contentViews = document.querySelectorAll(".content-view")
  contentViews.forEach((contentView) => {
    contentView.classList.remove("active")
  })
  document.getElementById(`${view}-view`).classList.add("active")
}

// Open add company to plan modal
function openAddCompanyModal(plan) {
  currentPlanForAdding = plan
  const modal = document.getElementById("add-company-modal")
  const modalTitle = document.getElementById("add-company-modal-title")
  const availableCompaniesContainer = document.getElementById("available-companies")

  modalTitle.textContent = `Add Company to ${plansData.plans[plan].name} Plan`

  // Clear existing content
  availableCompaniesContainer.innerHTML = ""

  // Get companies not in this plan
  const availableCompanies = plansData.companies.filter(company => company.plan !== plan)

  if (availableCompanies.length === 0) {
    availableCompaniesContainer.innerHTML = 
      '<p style="text-align: center; color: var(--text-secondary); grid-column: 1 / -1;">No available companies to add.</p>'
  } else {
    availableCompanies.forEach(company => {
      const companyElement = createAvailableCompanyElement(company)
      availableCompaniesContainer.appendChild(companyElement)
    })
  }

  showModal(modal)
}

// Create available company element
function createAvailableCompanyElement(company) {
  const element = document.createElement("div")
  element.className = "available-company"
  
  const currentPlanText = company.plan ? plansData.plans[company.plan].name : "Unassigned"
  
  element.innerHTML = `
    <div class="available-company-logo ${company.logo}">
      ${company.name.charAt(0)}
    </div>
    <div class="available-company-info">
      <h4>${company.name}</h4>
      <p>${company.industry} • ${currentPlanText}</p>
    </div>
  `

  element.addEventListener("click", () => {
    addCompanyToPlan(company.id, currentPlanForAdding)
  })

  return element
}

// Add company to plan
function addCompanyToPlan(companyId, plan) {
  const company = plansData.companies.find(c => c.id === companyId)
  if (company) {
    company.plan = plan
    company.startDate = new Date().toISOString().split('T')[0]
    company.billingCycle = "monthly"
    company.status = "active"
    saveData()
    refreshUI()
    closeModal(document.getElementById("add-company-modal"))
    showNotification(`${company.name} added to ${plansData.plans[plan].name} plan!`)
  }
}

// Remove company from plan
function removeCompanyFromPlan(companyId) {
  const company = plansData.companies.find(c => c.id === companyId)
  if (company) {
    const oldPlan = company.plan
    company.plan = null
    company.startDate = null
    company.billingCycle = null
    company.status = null
    saveData()
    refreshUI()
    showNotification(`${company.name} removed from ${plansData.plans[oldPlan].name} plan!`)
  }
}

// Change company plan
function changeCompanyPlan(companyId) {
  const company = plansData.companies.find(c => c.id === companyId)
  if (!company) return

  const planOptions = Object.keys(plansData.plans).map(planKey => 
    `<option value="${planKey}" ${company.plan === planKey ? 'selected' : ''}>${plansData.plans[planKey].name}</option>`
  ).join('')

  const selectHTML = `
    <select id="plan-change-select" class="form-control">
      <option value="">No Plan</option>
      ${planOptions}
    </select>
  `

  const modal = document.createElement("div")
  modal.className = "modal show"
  modal.innerHTML = `
    <div class="modal-content">
      <div class="modal-header">
        <h2>Change Plan for ${company.name}</h2>
        <button class="modal-close">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Select New Plan:</label>
          ${selectHTML}
        </div>
        <div class="form-actions">
          <button type="button" class="btn btn-secondary" onclick="closeModal(this.closest('.modal'))">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="confirmPlanChange(${companyId})">Change Plan</button>
        </div>
      </div>
    </div>
  `

  document.body.appendChild(modal)

  // Add event listeners
  modal.querySelector(".modal-close").addEventListener("click", () => {
    closeModal(modal)
  })

  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      closeModal(modal)
    }
  })
}

// Confirm plan change
function confirmPlanChange(companyId) {
  const select = document.getElementById("plan-change-select")
  const newPlan = select.value || null
  const company = plansData.companies.find(c => c.id === companyId)
  
  if (company) {
    const oldPlan = company.plan
    company.plan = newPlan
    
    if (newPlan) {
      company.startDate = new Date().toISOString().split('T')[0]
      company.billingCycle = "monthly"
      company.status = "active"
    } else {
      company.startDate = null
      company.billingCycle = null
      company.status = null
    }
    
    saveData()
    refreshUI()
    
    const modal = select.closest(".modal")
    closeModal(modal)
    
    const planName = newPlan ? plansData.plans[newPlan].name : "No Plan"
    showNotification(`${company.name} moved to ${planName}!`)
  }
}

// Remove company entirely
function removeCompany(companyId) {
  const company = plansData.companies.find(c => c.id === companyId)
  if (!company) return

  if (confirm(`Are you sure you want to remove ${company.name}? This action cannot be undone.`)) {
    const index = plansData.companies.findIndex(c => c.id === companyId)
    if (index !== -1) {
      plansData.companies.splice(index, 1)
      saveData()
      refreshUI()
      showNotification(`${company.name} removed successfully!`)
    }
  }
}

// Show companies modal with table
function showCompaniesModal(plan) {
  const modal = document.getElementById("companies-modal")
  const modalTitle = document.getElementById("modal-plan-title")
  const tableBody = document.getElementById("companies-table-body")

  const planName = plansData.plans[plan].name
  modalTitle.textContent = `Companies in ${planName} Plan`

  // Clear existing content
  tableBody.innerHTML = ""

  // Get companies for this plan
  const companiesInPlan = plansData.companies.filter(company => company.plan === plan)

  if (companiesInPlan.length === 0) {
    tableBody.innerHTML = `
      <tr>
        <td colspan="7" style="text-align: center; color: var(--text-secondary); padding: 40px;">
          No companies in this plan yet.
        </td>
      </tr>
    `
  } else {
    companiesInPlan.forEach(company => {
      const row = createCompanyTableRow(company)
      tableBody.appendChild(row)
    })
  }

  showModal(modal)
}

// Create company table row
function createCompanyTableRow(company) {
  const row = document.createElement("tr")
  
  const nextPayment = calculateNextPayment(company.startDate, company.billingCycle)
  const startDate = company.startDate ? new Date(company.startDate).toLocaleDateString("en-US", {
    year: "numeric",
    month: "short",
    day: "numeric"
  }) : "N/A"

  row.innerHTML = `
    <td>
      <div class="company-cell">
        <div class="company-logo-table ${company.logo}">
          ${company.name.charAt(0)}
        </div>
        <div>
          <div style="font-weight: 500;">${company.name}</div>
        </div>
      </div>
    </td>
    <td>${company.industry}</td>
    <td>${startDate}</td>
    <td style="font-weight: 500; color: var(--primary-color);">${nextPayment}</td>
    <td style="text-transform: capitalize;">${company.billingCycle || "N/A"}</td>
    <td>
      <span class="status-badge ${company.status || 'inactive'}">${company.status || "Inactive"}</span>
    </td>
    <td>
      <div class="table-actions">
        <button class="btn-icon" onclick="changeCompanyPlan(${company.id})" title="Change Plan">
          <i class="fas fa-exchange-alt"></i>
        </button>
        <button class="btn-icon" onclick="removeCompanyFromPlan(${company.id})" title="Remove from Plan">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </td>
  `

  return row
}

// Open new company modal
function openNewCompanyModal() {
  const modal = document.getElementById("new-company-modal")
  const form = document.getElementById("new-company-form")
  
  form.reset()
  showModal(modal)
}

// Handle new company form submission
function handleNewCompanySubmit(e) {
  e.preventDefault()

  const formData = {
    name: document.getElementById("company-name").value.trim(),
    industry: document.getElementById("company-industry").value,
    plan: document.getElementById("company-plan").value || null
  }

  // Validate form
  if (!formData.name || !formData.industry) {
    showNotification("Please fill in all required fields", "error")
    return
  }

  // Check for duplicate company name
  const existingCompany = plansData.companies.find(
    company => company.name.toLowerCase() === formData.name.toLowerCase()
  )

  if (existingCompany) {
    showNotification("A company with this name already exists", "error")
    return
  }

  // Generate logo class from company name
  const logoClass = formData.name.toLowerCase().replace(/[^a-z0-9]/g, '').substring(0, 10)

  // Add new company
  const newCompany = {
    id: Date.now(), // Simple ID generation
    name: formData.name,
    logo: logoClass,
    industry: formData.industry,
    plan: formData.plan,
    startDate: formData.plan ? new Date().toISOString().split('T')[0] : null,
    billingCycle: formData.plan ? "monthly" : null,
    status: formData.plan ? "active" : null
  }

  plansData.companies.push(newCompany)
  saveData()
  refreshUI()
  closeModal(document.getElementById("new-company-modal"))
  showNotification(`${formData.name} added successfully!`)
}

// Handle search
function handleSearch(e) {
  const searchTerm = e.target.value.toLowerCase()
  const companyCards = document.querySelectorAll(".company-card-main")
  
  companyCards.forEach(card => {
    const companyName = card.querySelector("h3").textContent.toLowerCase()
    const companyIndustry = card.querySelector("p").textContent.toLowerCase()
    
    if (companyName.includes(searchTerm) || companyIndustry.includes(searchTerm)) {
      card.style.display = "block"
    } else {
      card.style.display = "none"
    }
  })
}

// Handle plan filter
function handlePlanFilter(e) {
  const selectedPlan = e.target.value
  const companyCards = document.querySelectorAll(".company-card-main")
  
  companyCards.forEach(card => {
    const planElement = card.querySelector(".current-plan")
    const planClass = Array.from(planElement.classList).find(cls => 
      cls !== "current-plan" && (Object.keys(plansData.plans).includes(cls) || cls === "unassigned")
    )
    
    if (!selectedPlan || planClass === selectedPlan) {
      card.style.display = "block"
    } else {
      card.style.display = "none"
    }
  })
}

// Show modal
function showModal(modal) {
  modal.classList.add("show")
  document.body.style.overflow = "hidden"
}

// Close modal
function closeModal(modal) {
  modal.classList.remove("show")
  document.body.style.overflow = ""
  
  // Remove dynamically created modals
  if (!modal.id) {
    setTimeout(() => {
      modal.remove()
    }, 300)
  }
}

// Show notification
function showNotification(message, type = "success") {
  const notification = document.getElementById("notification")
  const messageElement = document.getElementById("notification-message")

  messageElement.textContent = message

  if (type === "error") {
    notification.style.background = "#ef4444"
  } else {
    notification.style.background = "#10b981"
  }

  notification.classList.add("show")

  setTimeout(() => {
    notification.classList.remove("show")
  }, 3000)
}

// Refresh UI
function refreshUI() {
  loadPlansData()
}

// Global functions for inline event handlers
window.changeCompanyPlan = changeCompanyPlan
window.removeCompany = removeCompany
window.confirmPlanChange = confirmPlanChange
window.closeModal = closeModal
window.removeCompanyFromPlan = removeCompanyFromPlan
// Setup hover modals for features - Fixed Mobile Version
function setupHoverModals() {
  const featureItems = document.querySelectorAll('.feature-item[data-modal-title]')
  const modal = document.getElementById('feature-modal')
  const modalTitle = document.getElementById('feature-modal-title')
  const modalDescription = document.getElementById('feature-modal-description')

  let hoverTimeout
  let activeFeatureItem = null
  
  // Clear any existing event listeners
  featureItems.forEach(item => {
    item.replaceWith(item.cloneNode(true))
  })
  
  // Re-select items after cloning
  const freshFeatureItems = document.querySelectorAll('.feature-item[data-modal-title]')

  freshFeatureItems.forEach(item => {
    // Check if device supports hover
    const hasHover = window.matchMedia('(hover: hover)').matches
    
    if (hasHover) {
      // Desktop hover events
      item.addEventListener('mouseenter', (e) => {
        clearTimeout(hoverTimeout)
        showFeatureModal(item)
      })
      
      item.addEventListener('mouseleave', () => {
        hoverTimeout = setTimeout(() => {
          hideFeatureModal()
        }, 100)
      })
    } else {
      // Mobile touch events
      item.addEventListener('click', (e) => {
        e.preventDefault()
        e.stopPropagation()
        handleMobileTouch(item)
      })
    }
  })

  // Handle clicks outside modal on mobile
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.feature-item') && !e.target.closest('.feature-modal')) {
      closeMobileModal()
    }
  })

  // Keep modal open when hovering over it (desktop only)
  modal.addEventListener('mouseenter', () => {
    if (window.matchMedia('(hover: hover)').matches) {
      clearTimeout(hoverTimeout)
    }
  })

  modal.addEventListener('mouseleave', () => {
    if (window.matchMedia('(hover: hover)').matches) {
      hideFeatureModal()
    }
  })

  function handleMobileTouch(item) {
    if (activeFeatureItem === item && modal.classList.contains('show')) {
      // If same item is tapped and modal is open, close it
      closeMobileModal()
    } else {
      // Close any open modal and open new one
      closeMobileModal()
      showFeatureModal(item)
      activeFeatureItem = item
      item.classList.add('active-touch')
    }
  }

  function showFeatureModal(item) {
    const title = item.getAttribute('data-modal-title')
    const content = item.getAttribute('data-modal-content')
    
    modalTitle.textContent = title
    modalDescription.textContent = content
    
    // Position modal
    const rect = item.getBoundingClientRect()
    const modalWidth = 300
    const modalHeight = 120
    
    let left = rect.left + (rect.width / 2) - (modalWidth / 2)
    let top = rect.top - modalHeight - 10
    
    // Adjust if modal goes off screen
    if (left < 10) left = 10
    if (left + modalWidth > window.innerWidth) left = window.innerWidth - modalWidth - 10
    if (top < 10) top = rect.bottom + 10
    
    modal.style.left = left + 'px'
    modal.style.top = top + 'px'
    modal.style.position = 'fixed'
    
    modal.classList.add('show')
  }

  function hideFeatureModal() {
    modal.classList.remove('show')
  }

  function closeMobileModal() {
    hideFeatureModal()
    if (activeFeatureItem) {
      activeFeatureItem.classList.remove('active-touch')
      activeFeatureItem = null
    }
  }
}

// Add this to the end of the DOMContentLoaded event listener
window.addEventListener('resize', () => {
  // Reinitialize hover modals on resize to handle mobile/desktop switch
  setTimeout(() => {
    setupHoverModals()
  }, 100)
})