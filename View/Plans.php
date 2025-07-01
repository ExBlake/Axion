<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planes</title>
    <link rel="icon" type="image/x-icon" href="Icono">
    <link rel="stylesheet" href="Estilos_Menu">
    <link rel="stylesheet" href="Estilos_Planes">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500&display=swap">
    <!-- Fuentes adicionales -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&display=swap">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include 'Layout/HeaderLeft.php'; ?>
        <!-- Main Content -->
        <div class="main-content">

            <!-- Plans Content -->
            <div class="dashboard-content">
                <!-- Main Content Views -->
                <div id="overview-view" class="content-view active">
                    <!-- Plans Grid -->
                    <div class="plans-section">
                        <div class="section-header">
                            <h2>Planes</h2>
                            <div class="section-actions">
                                <button class="btn btn-secondary" id="export-btn">
                                    <i class="fas fa-download"></i>
                                    Export
                                </button>
                                <button class="btn btn-primary" id="add-plan-btn">
                                    <i class="fas fa-plus"></i>
                                    Add Plan
                                </button>
                            </div>
                        </div>

                        <div class="plans-grid">
                            <!-- Plan 1: Starter -->
                            <div class="plan-card" data-plan="starter">
                                <div class="plan-header">
                                    <div class="plan-title">
                                        <div>
                                            <h3>Starter</h3>
                                            <p>Perfect for small teams getting started</p>
                                        </div>
                                    </div>
                                    <div class="plan-pricing">
                                        <div class="pricing-top-row">
                                            <div class="price-original">US$ 29</div>
                                            <div class="discount-badge">SAVE 34%</div>
                                        </div>
                                        <div class="price-main">
                                            <span class="currency">US$</span>
                                            <span class="amount">19</span>
                                            <span class="period">/mo</span>
                                        </div>
                                        <div class="price-term">For 12-month term</div>
                                        <button class="btn btn-quote">
                                            <i class="fas fa-comments"></i>
                                            Choose plan
                                        </button>
                                        <p class="price-note">Renews at US$ 19/mo for 1 year. Cancel anytime.</p>
                                    </div>
                                </div>

                                <div class="plan-separator"></div>

                                <div class="plan-features">
                                    <div class="feature-item included" data-modal-title="User Limit" data-modal-content="This plan allows up to 3 users to access your workspace. Perfect for small teams or individual projects that need basic collaboration features.">
                                        <i class="fas fa-check"></i>
                                        <span>Up to 3 users</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="Storage Space" data-modal-content="Get 5GB of secure cloud storage for all your files, documents, and project data. Ideal for storing essential documents and small media files.">
                                        <i class="fas fa-check"></i>
                                        <span>5GB storage</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="Email Support" data-modal-content="Receive support through email during business hours (9 AM - 6 PM, Monday to Friday). Our team typically responds within 24-48 hours.">
                                        <i class="fas fa-check"></i>
                                        <span>Email support</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="Basic Features" data-modal-content="Access to core platform features including basic project management, file sharing, and standard templates to get you started.">
                                        <i class="fas fa-check"></i>
                                        <span>Basic features</span>
                                    </div>
                                    <div class="feature-item excluded" data-modal-title="Analytics Dashboard" data-modal-content="Advanced analytics and reporting tools are not available in the Starter plan. Upgrade to Professional or higher to access detailed insights and performance metrics.">
                                        <i class="fas fa-times"></i>
                                        <span>Analytics dashboard</span>
                                    </div>
                                    <div class="feature-item excluded" data-modal-title="Priority Support" data-modal-content="24/7 priority customer support is not included in the Starter plan. This feature is available in Professional and higher plans.">
                                        <i class="fas fa-times"></i>
                                        <span>Priority support</span>
                                    </div>
                                </div>

                                <div class="plan-separator"></div>

                                <div class="plan-actions">
                                    <button class="btn btn-secondary btn-small add-company-btn" data-plan="starter">
                                        <i class="fas fa-plus"></i>
                                        Add Company
                                    </button>
                                    <button class="btn btn-primary btn-small view-companies-btn" data-plan="starter">
                                        <i class="fas fa-eye"></i>
                                        View Companies
                                    </button>
                                </div>
                            </div>

                            <!-- Plan 2: Professional -->
                            <div class="plan-card popular" data-plan="professional">
                                <div class="popular-badge">Tu Plan</div>
                                <div class="plan-header">
                                    <div class="plan-title">
                                        <div>
                                            <h3>Professional</h3>
                                            <p>Ideal for growing businesses</p>
                                        </div>
                                    </div>
                                    <div class="plan-pricing">
                                        <div class="pricing-top-row">
                                            <div class="price-original">US$ 75</div>
                                            <div class="discount-badge">SAVE 35%</div>
                                        </div>
                                        <div class="price-main">
                                            <span class="currency">US$</span>
                                            <span class="amount">49</span>
                                            <span class="period">/mo</span>
                                        </div>
                                        <div class="price-term">For 24-month term</div>
                                        <button class="btn btn-quote popular">
                                            <i class="fas fa-comments"></i>
                                            Choose plan
                                        </button>
                                        <p class="price-note">Renews at US$ 49/mo for 2 years. Cancel anytime.</p>
                                    </div>
                                </div>

                                <div class="plan-separator"></div>

                               

                                <div class="plan-features">
                                    <div class="feature-item included" data-modal-title="User Limit" data-modal-content="This plan supports up to 15 users, making it perfect for growing teams that need enhanced collaboration and project management capabilities.">
                                        <i class="fas fa-check"></i>
                                        <span>Up to 15 users</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="Storage Space" data-modal-content="Get 50GB of secure cloud storage for all your files, documents, media, and project data. Suitable for medium-sized projects and teams.">
                                        <i class="fas fa-check"></i>
                                        <span>50GB storage</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="Priority Support" data-modal-content="Get faster response times and priority in our support queue. Our team responds within 12-24 hours during business days.">
                                        <i class="fas fa-check"></i>
                                        <span>Priority support</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="Advanced Features" data-modal-content="Access to advanced platform features including custom workflows, advanced project templates, team collaboration tools, and enhanced security options.">
                                        <i class="fas fa-check"></i>
                                        <span>Advanced features</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="Analytics Dashboard" data-modal-content="Comprehensive analytics and reporting dashboard with insights into team performance, project progress, and resource utilization.">
                                        <i class="fas fa-check"></i>
                                        <span>Analytics dashboard</span>
                                    </div>
                                    <div class="feature-item excluded" data-modal-title="Custom Integrations" data-modal-content="Custom integrations with third-party applications and services are not available in the Professional plan. This feature is available in Business and higher plans.">
                                        <i class="fas fa-times"></i>
                                        <span>Custom integrations</span>
                                    </div>
                                </div>

                                <div class="plan-separator"></div>

                                <div class="plan-actions">
                                    <button class="btn btn-secondary btn-small add-company-btn" data-plan="professional">
                                        <i class="fas fa-plus"></i>
                                        Add Company
                                    </button>
                                    <button class="btn btn-primary btn-small view-companies-btn" data-plan="professional">
                                        <i class="fas fa-eye"></i>
                                        View Companies
                                    </button>
                                </div>
                            </div>

                            <!-- Plan 3: Business -->
                            <div class="plan-card" data-plan="business">
                                <div class="plan-header">
                                    <div class="plan-title">
                                        <div>
                                            <h3>Business</h3>
                                            <p>Advanced features for established companies</p>
                                        </div>
                                    </div>
                                    <div class="plan-pricing">
                                        <div class="pricing-top-row">
                                            <div class="price-original">US$ 149</div>
                                            <div class="discount-badge">SAVE 34%</div>
                                        </div>
                                        <div class="price-main">
                                            <span class="currency">US$</span>
                                            <span class="amount">99</span>
                                            <span class="period">/mo</span>
                                        </div>
                                        <div class="price-term">For 12-month term</div>
                                        <button class="btn btn-quote">
                                            <i class="fas fa-comments"></i>
                                            Choose plan
                                        </button>
                                        <p class="price-note">Renews at US$ 99/mo for 1 year. Cancel anytime.</p>
                                    </div>
                                </div>

                                <div class="plan-separator"></div>

                              
                                <div class="plan-features">
                                    <div class="feature-item included" data-modal-title="User Limit" data-modal-content="Support for up to 50 users, perfect for medium to large teams that need comprehensive collaboration and management tools.">
                                        <i class="fas fa-check"></i>
                                        <span>Up to 50 users</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="Storage Space" data-modal-content="Get 200GB of secure cloud storage for all your business data, large files, media assets, and comprehensive project archives.">
                                        <i class="fas fa-check"></i>
                                        <span>200GB storage</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="24/7 Support" data-modal-content="Round-the-clock customer support available 24/7 via phone, email, and live chat. Our dedicated support team is always ready to help.">
                                        <i class="fas fa-check"></i>
                                        <span>24/7 support</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="All Features" data-modal-content="Access to all platform features and capabilities including advanced project management, team collaboration, reporting, and business intelligence tools.">
                                        <i class="fas fa-check"></i>
                                        <span>All features</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="Custom Integrations" data-modal-content="Connect with third-party applications and services through custom integrations. Seamlessly integrate with your existing business tools and workflows.">
                                        <i class="fas fa-check"></i>
                                        <span>Custom integrations</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="API Access" data-modal-content="Full API access for custom development and integration with your existing systems. Build custom solutions and automate workflows.">
                                        <i class="fas fa-check"></i>
                                        <span>API access</span>
                                    </div>
                                </div>

                                <div class="plan-separator"></div>

                                <div class="plan-actions">
                                    <button class="btn btn-secondary btn-small add-company-btn" data-plan="business">
                                        <i class="fas fa-plus"></i>
                                        Add Company
                                    </button>
                                    <button class="btn btn-primary btn-small view-companies-btn" data-plan="business">
                                        <i class="fas fa-eye"></i>
                                        View Companies
                                    </button>
                                </div>
                            </div>

                            <!-- Plan 4: Premium -->
                            <div class="plan-card" data-plan="premium">
                                <div class="plan-header">
                                    <div class="plan-title">
                                        <div>
                                            <h3>Premium</h3>
                                            <p>Premium features with white-label options</p>
                                        </div>
                                    </div>
                                    <div class="plan-pricing">
                                        <div class="pricing-top-row">
                                            <div class="price-original">US$ 265</div>
                                            <div class="discount-badge">SAVE 25%</div>
                                        </div>
                                        <div class="price-main">
                                            <span class="currency">US$</span>
                                            <span class="amount">199</span>
                                            <span class="period">/mo</span>
                                        </div>
                                        <div class="price-term">For 24-month term</div>
                                        <button class="btn btn-quote">
                                            <i class="fas fa-comments"></i>
                                            Choose plan
                                        </button>
                                        <p class="price-note">Renews at US$ 199/mo for 2 years. Cancel anytime.</p>
                                    </div>
                                </div>

                                <div class="plan-separator"></div>

                            

                                <div class="plan-features">
                                    <div class="feature-item included" data-modal-title="User Limit" data-modal-content="Support for up to 100 users, ideal for large organizations that need extensive collaboration and management capabilities across multiple departments.">
                                        <i class="fas fa-check"></i>
                                        <span>Up to 100 users</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="Storage Space" data-modal-content="Get 500GB of secure cloud storage for enterprise-level data management, large media files, and comprehensive business archives.">
                                        <i class="fas fa-check"></i>
                                        <span>500GB storage</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="Dedicated Support" data-modal-content="Dedicated support representative assigned to your account with guaranteed response times and personalized assistance for your business needs.">
                                        <i class="fas fa-check"></i>
                                        <span>Dedicated support</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="Premium Features" data-modal-content="Access to premium features including advanced automation, custom branding options, enhanced security features, and priority feature requests.">
                                        <i class="fas fa-check"></i>
                                        <span>Premium features</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="White-label Solution" data-modal-content="Customize the platform with your own branding, logos, and color schemes. Present the solution as your own to your clients and partners.">
                                        <i class="fas fa-check"></i>
                                        <span>White-label solution</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="Advanced Analytics" data-modal-content="Advanced analytics with detailed insights, custom reporting, predictive analytics, and business intelligence tools to drive data-driven decisions.">
                                        <i class="fas fa-check"></i>
                                        <span>Advanced analytics</span>
                                    </div>
                                </div>

                                <div class="plan-separator"></div>

                                <div class="plan-actions">
                                    <button class="btn btn-secondary btn-small add-company-btn" data-plan="premium">
                                        <i class="fas fa-plus"></i>
                                        Add Company
                                    </button>
                                    <button class="btn btn-primary btn-small view-companies-btn" data-plan="premium">
                                        <i class="fas fa-eye"></i>
                                        View Companies
                                    </button>
                                </div>
                            </div>

                            <!-- Plan 5: Enterprise -->
                            <div class="plan-card" data-plan="enterprise">
                                <div class="plan-header">
                                    <div class="plan-title">
                                        <div>
                                            <h3>Enterprise</h3>
                                            <p>Custom solutions for large organizations</p>
                                        </div>
                                    </div>
                                    <div class="plan-pricing">
                                        <div class="price-main custom">
                                            <span class="amount">Custom</span>
                                            <span class="period">Pricing</span>
                                        </div>
                                        <div class="price-term">Tailored to your needs</div>
                                        <button class="btn btn-quote enterprise">
                                            <i class="fas fa-phone"></i>
                                            Contact Sales
                                        </button>
                                        <p class="price-note">Custom solution • Annual contract</p>
                                    </div>
                                </div>

                                <div class="plan-separator"></div>

                  

                                <div class="plan-features">
                                    <div class="feature-item included" data-modal-title="Unlimited Users" data-modal-content="No limit on the number of users in your organization. Scale your team without restrictions and manage large enterprise deployments.">
                                        <i class="fas fa-check"></i>
                                        <span>Unlimited users</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="Unlimited Storage" data-modal-content="No limit on storage space for your data. Store unlimited files, documents, media, and business data with enterprise-grade security.">
                                        <i class="fas fa-check"></i>
                                        <span>Unlimited storage</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="Enterprise Support" data-modal-content="Enterprise-grade support with guaranteed response times, dedicated account management, and priority escalation for critical issues.">
                                        <i class="fas fa-check"></i>
                                        <span>Enterprise support</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="All Features" data-modal-content="Access to all current and future features and capabilities. Get early access to new features and beta programs.">
                                        <i class="fas fa-check"></i>
                                        <span>All features</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="Custom Development" data-modal-content="Custom development and feature implementation tailored to your specific business requirements. Our development team works with you to build custom solutions.">
                                        <i class="fas fa-check"></i>
                                        <span>Custom development</span>
                                    </div>
                                    <div class="feature-item included" data-modal-title="SLA Guarantee" data-modal-content="Service Level Agreement with guaranteed uptime (99.9%), performance metrics, and compensation for any service disruptions.">
                                        <i class="fas fa-check"></i>
                                        <span>SLA guarantee</span>
                                    </div>
                                </div>

                                <div class="plan-separator"></div>

                                <div class="plan-actions">
                                    <button class="btn btn-secondary btn-small add-company-btn" data-plan="enterprise">
                                        <i class="fas fa-plus"></i>
                                        Add Company
                                    </button>
                                    <button class="btn btn-primary btn-small view-companies-btn" data-plan="enterprise">
                                        <i class="fas fa-eye"></i>
                                        View Companies
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Companies View -->
                <div id="companies-view" class="content-view">
                    <div class="companies-section">
                        <div class="section-header">
                            <h2>All Companies</h2>
                            <div class="section-actions">
                                <select id="plan-filter" class="filter-select">
                                    <option value="">All Plans</option>
                                    <option value="starter">Starter</option>
                                    <option value="professional">Professional</option>
                                    <option value="business">Business</option>
                                    <option value="premium">Premium</option>
                                    <option value="enterprise">Enterprise</option>
                                    <option value="unassigned">Unassigned</option>
                                </select>
                                <button class="btn btn-primary" id="add-company-main-btn">
                                    <i class="fas fa-plus"></i>
                                    Add Company
                                </button>
                            </div>
                        </div>

                        <div class="companies-grid-main" id="companies-grid-main">
                            <!-- Companies will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Modal -->
    <div id="feature-modal" class="feature-modal">
        <div class="feature-modal-content">
            <h4 id="feature-modal-title"></h4>
            <p id="feature-modal-description"></p>
        </div>
    </div>

    <!-- Companies Table Modal -->
    <div id="companies-modal" class="modal">
        <div class="modal-content large">
            <div class="modal-header">
                <h2 id="modal-plan-title">Companies in Plan</h2>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-container">
                    <table class="companies-table">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Industry</th>
                                <th>Start Date</th>
                                <th>Next Payment</th>
                                <th>Billing Cycle</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="companies-table-body">
                            <!-- Table rows will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Company to Plan Modal -->
    <div id="add-company-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="add-company-modal-title">Add Company to Plan</h2>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="available-companies" id="available-companies">
                    <!-- Available companies will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Add New Company Modal -->
    <div id="new-company-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Company</h2>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <form id="new-company-form">
                    <div class="form-group">
                        <label for="company-name">Company Name</label>
                        <input type="text" id="company-name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="company-industry">Industry</label>
                        <select id="company-industry" class="form-control" required>
                            <option value="">Select Industry</option>
                            <option value="Technology">Technology</option>
                            <option value="Finance">Finance</option>
                            <option value="Healthcare">Healthcare</option>
                            <option value="E-commerce">E-commerce</option>
                            <option value="Education">Education</option>
                            <option value="Entertainment">Entertainment</option>
                            <option value="Manufacturing">Manufacturing</option>
                            <option value="Retail">Retail</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="company-plan">Assign to Plan (Optional)</label>
                        <select id="company-plan" class="form-control">
                            <option value="">No Plan</option>
                            <option value="starter">Starter</option>
                            <option value="professional">Professional</option>
                            <option value="business">Business</option>
                            <option value="premium">Premium</option>
                            <option value="enterprise">Enterprise</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" id="cancel-new-company">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Company</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Notification -->
    <div id="notification" class="notification">
        <div class="notification-content">
            <i class="fas fa-check-circle"></i>
            <span id="notification-message">Action completed successfully!</span>
        </div>
    </div>

    <script src="Funcion_Menu"></script>
    <script src="Funcion_Sincronizacion"></script>
    <script src="Funcion_Planes"></script>
</body>
</html>