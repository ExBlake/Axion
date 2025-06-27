

// Manejo de pestañas de configuración
document.addEventListener("DOMContentLoaded", () => {
    
    // Seleccionar elementos
    const tabLinks = document.querySelectorAll(".settings-nav li");
    const tabContents = document.querySelectorAll(".settings-tab");

    // Función para cambiar de pestaña
    function switchTab(tabId) {
        // Ocultar todas las pestañas
        tabContents.forEach((tab) => {
            tab.classList.remove("active");
        });

        // Desactivar todos los enlaces
        tabLinks.forEach((link) => {
            link.classList.remove("active");
        });

        // Activar la pestaña seleccionada
        document.getElementById(`${tabId}-tab`).classList.add("active");

        // Activar el enlace seleccionado
        document.querySelector(`[data-tab="${tabId}"]`).classList.add("active");

        // Actualizar la URL con el hash para permitir enlaces directos
        window.location.hash = tabId;
    }

    // Agregar event listeners a los enlaces de pestañas
    tabLinks.forEach((link) => {
        link.addEventListener("click", function () {
            const tabId = this.getAttribute("data-tab");
            switchTab(tabId);
        });
    });

    // Inicializar con la pestaña correcta basada en el hash de la URL o la primera pestaña
    function initializeTab() {
        let activeTab = "profile"; // Pestaña por defecto

        // Verificar si hay un hash en la URL
        const hash = window.location.hash.substring(1);
        if (hash && document.querySelector(`[data-tab="${hash}"]`)) {
            activeTab = hash;
        }

        switchTab(activeTab);
    }

    initializeTab();

    // ===== FUNCIONALIDAD DE APARIENCIA =====

    // 1. Manejo del tema (claro/oscuro/sistema)
    const themeOptions = document.querySelectorAll(".theme-option");
    const darkModeSwitch = document.getElementById("dark-mode-switch");

    // Función para aplicar el tema del sistema
    function applySystemTheme() {
        const prefersDarkMode = window.matchMedia(
            "(prefers-color-scheme: dark)"
        ).matches;
        if (prefersDarkMode) {
            document.body.classList.add("dark-mode");
            if (darkModeSwitch) darkModeSwitch.checked = true;
        } else {
            document.body.classList.remove("dark-mode");
            if (darkModeSwitch) darkModeSwitch.checked = false;
        }
    }

    // Inicializar el tema basado en la preferencia guardada
    function initializeTheme() {
        const savedTheme = localStorage.getItem("theme");

        // Eliminar la clase active de todas las opciones primero
        themeOptions.forEach((option) => {
            option.classList.remove("active");
        });

        if (savedTheme === "dark") {
            document.body.classList.add("dark-mode");
            if (darkModeSwitch) darkModeSwitch.checked = true;
            // Activar la opción de tema oscuro
            themeOptions[1].classList.add("active");
        } else if (savedTheme === "light") {
            document.body.classList.remove("dark-mode");
            if (darkModeSwitch) darkModeSwitch.checked = false;
            // Activar la opción de tema claro
            themeOptions[0].classList.add("active");
        } else if (savedTheme === "system") {
            applySystemTheme();
            // Activar la opción de tema del sistema
            themeOptions[2].classList.add("active");
        } else {
            // Si no hay preferencia guardada, usar el tema claro por defecto
            document.body.classList.remove("dark-mode");
            if (darkModeSwitch) darkModeSwitch.checked = false;
            // Activar la opción de tema claro
            themeOptions[0].classList.add("active");
        }
    }

    if (themeOptions.length > 0) {
        initializeTheme();

        // Manejar clics en las opciones de tema
        themeOptions.forEach((option, index) => {
            option.addEventListener("click", function () {
                // Desactivar todas las opciones
                themeOptions.forEach((opt) => opt.classList.remove("active"));

                // Activar la opción seleccionada
                this.classList.add("active");

                if (index === 0) {
                    // Tema claro
                    document.body.classList.remove("dark-mode");
                    localStorage.setItem("theme", "light");
                    localStorage.setItem("darkMode", "disabled"); // Para compatibilidad
                    if (darkModeSwitch) darkModeSwitch.checked = false;
                } else if (index === 1) {
                    // Tema oscuro
                    document.body.classList.add("dark-mode");
                    localStorage.setItem("theme", "dark");
                    localStorage.setItem("darkMode", "enabled"); // Para compatibilidad
                    if (darkModeSwitch) darkModeSwitch.checked = true;
                } else if (index === 2) {
                    // Tema del sistema
                    localStorage.setItem("theme", "system");
                    localStorage.removeItem("darkMode"); // Eliminar configuración antigua
                    applySystemTheme();
                }
            });
        });

        // Sincronizar el interruptor de modo oscuro con los temas
        if (darkModeSwitch) {
            darkModeSwitch.addEventListener("change", function () {
                if (this.checked) {
                    // Desactivar todas las opciones
                    themeOptions.forEach((opt) => opt.classList.remove("active"));
                    // Activar la opción de tema oscuro
                    themeOptions[1].classList.add("active");

                    document.body.classList.add("dark-mode");
                    localStorage.setItem("theme", "dark");
                    localStorage.setItem("darkMode", "enabled");
                } else {
                    // Desactivar todas las opciones
                    themeOptions.forEach((opt) => opt.classList.remove("active"));
                    // Activar la opción de tema claro
                    themeOptions[0].classList.add("active");

                    document.body.classList.remove("dark-mode");
                    localStorage.setItem("theme", "light");
                    localStorage.setItem("darkMode", "disabled");
                }
            });
        }

        // Escuchar cambios en la preferencia del sistema
        window
            .matchMedia("(prefers-color-scheme: dark)")
            .addEventListener("change", (e) => {
                if (localStorage.getItem("theme") === "system") {
                    applySystemTheme();
                }
            });
    }

    // 3. Manejar opciones de color
    const colorOptions = document.querySelectorAll(".color-option");

    // Función para convertir hex a rgb
    function hexToRgb(hex) {
        // Eliminar el # si existe
        if (hex.startsWith("#")) {
            hex = hex.substring(1);
        }

        // Convertir formato corto (#abc) a formato largo (#aabbcc)
        if (hex.length === 3) {
            hex = hex
                .split("")
                .map((char) => char + char)
                .join("");
        }

        const r = Number.parseInt(hex.substring(0, 2), 16);
        const g = Number.parseInt(hex.substring(2, 4), 16);
        const b = Number.parseInt(hex.substring(4, 6), 16);

        return { r, g, b };
    }

    // Inicializar el color de acento basado en la preferencia guardada
    function initializeAccentColor() {
        const savedColor = localStorage.getItem("accentColor");
        if (savedColor) {
            document.documentElement.style.setProperty("--primary-color", savedColor);

            // Actualizar el color claro para fondos
            const colorRGB = hexToRgb(savedColor);
            if (colorRGB) {
                const lightColor = `rgba(${colorRGB.r}, ${colorRGB.g}, ${colorRGB.b}, 0.1)`;
                document.documentElement.style.setProperty(
                    "--primary-light",
                    lightColor
                );
            }

            // Marcar la opción correspondiente como activa
            colorOptions.forEach((option) => {
                const optionColor =
                    option.style.getPropertyValue("--color").trim() ||
                    getComputedStyle(option).getPropertyValue("--color").trim();
                if (optionColor === savedColor) {
                    colorOptions.forEach((opt) => opt.classList.remove("active"));
                    option.classList.add("active");
                }
            });
        }
    }

    if (colorOptions.length > 0) {
        initializeAccentColor();

        colorOptions.forEach((option) => {
            option.addEventListener("click", function () {
                // Desactivar todas las opciones
                colorOptions.forEach((opt) => opt.classList.remove("active"));

                // Activar la opción seleccionada
                this.classList.add("active");

                // Obtener el color directamente del atributo style
                const color =
                    this.style.getPropertyValue("--color").trim() ||
                    getComputedStyle(this).getPropertyValue("--color").trim();
                document.documentElement.style.setProperty("--primary-color", color);
                localStorage.setItem("accentColor", color);

                // Actualizar el color claro para fondos
                const colorRGB = hexToRgb(color);
                if (colorRGB) {
                    const lightColor = `rgba(${colorRGB.r}, ${colorRGB.g}, ${colorRGB.b}, 0.1)`;
                    document.documentElement.style.setProperty(
                        "--primary-light",
                        lightColor
                    );
                    localStorage.setItem("accentLightColor", lightColor);
                }
            });
        });
    }

    // ===== NUEVAS FUNCIONALIDADES DE APARIENCIA =====

    // 1. Color personalizado
    const customColorInput = document.getElementById("custom-color");
    const colorHexInput = document.getElementById("color-hex");
    const colorPreview = document.getElementById("color-preview");
    const copyHexBtn = document.getElementById("copy-hex");
    const applyCustomColorBtn = document.getElementById("apply-custom-color");

    if (customColorInput && colorHexInput && colorPreview) {
        // Inicializar con el color guardado o el color actual
        const savedCustomColor = localStorage.getItem("customColor");
        if (savedCustomColor) {
            customColorInput.value = savedCustomColor;
            colorHexInput.value = savedCustomColor;
            colorPreview.style.backgroundColor = savedCustomColor;
        } else {
            const currentColor = getComputedStyle(document.documentElement)
                .getPropertyValue("--primary-color")
                .trim();
            customColorInput.value = currentColor;
            colorHexInput.value = currentColor;
            colorPreview.style.backgroundColor = currentColor;
        }

        // Actualizar cuando se cambia el color
        customColorInput.addEventListener("input", function () {
            colorHexInput.value = this.value;
            colorPreview.style.backgroundColor = this.value;
        });

        // Actualizar cuando se cambia el código hex
        colorHexInput.addEventListener("input", function () {
            // Validar que sea un código hex válido
            if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                customColorInput.value = this.value;
                colorPreview.style.backgroundColor = this.value;
            }
        });

        // Copiar el código hex al portapapeles
        if (copyHexBtn) {
            copyHexBtn.addEventListener("click", function () {
                colorHexInput.select();
                document.execCommand("copy");

                // Mostrar mensaje de éxito
                const originalIcon = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check"></i>';

                setTimeout(() => {
                    this.innerHTML = originalIcon;
                }, 1500);
            });
        }

        // Aplicar el color personalizado
        if (applyCustomColorBtn) {
            applyCustomColorBtn.addEventListener("click", function () {
                const color = customColorInput.value;

                // Aplicar el color personalizado
                document.documentElement.style.setProperty("--primary-color", color);

                // Actualizar el color claro para fondos
                const colorRGB = hexToRgb(color);
                if (colorRGB) {
                    const lightColor = `rgba(${colorRGB.r}, ${colorRGB.g}, ${colorRGB.b}, 0.1)`;
                    document.documentElement.style.setProperty(
                        "--primary-light",
                        lightColor
                    );
                }

                // Desactivar todas las opciones de color predefinidas
                colorOptions.forEach((opt) => opt.classList.remove("active"));

                // Guardar el color personalizado
                localStorage.setItem("customColor", color);
                localStorage.setItem("accentColor", color);

                // Mostrar mensaje de éxito
                const originalText = this.textContent;
                this.textContent = "¡Color aplicado!";
                this.disabled = true;

                setTimeout(() => {
                    this.textContent = originalText;
                    this.disabled = false;
                }, 1500);
            });
        }
    }

    // 3. Animaciones
    const animationsToggle = document.getElementById("animations-toggle");
    const animationSpeedContainer = document.getElementById(
        "animation-speed-container"
    );
    const animationSpeedOptions = document.querySelectorAll(
        ".animation-speed .toggle-option"
    );

    if (animationsToggle) {
        // Inicializar con el valor guardado o el valor por defecto
        const savedAnimations = localStorage.getItem("animations");
        if (savedAnimations === "disabled") {
            animationsToggle.checked = false;
            document.body.classList.add("no-animations");
            if (animationSpeedContainer) {
                animationSpeedContainer.style.display = "none";
            }
        } else {
            animationsToggle.checked = true;
            document.body.classList.remove("no-animations");
            if (animationSpeedContainer) {
                animationSpeedContainer.style.display = "block";
            }
        }

        // Inicializar velocidad de animación
        const savedSpeed = localStorage.getItem("animationSpeed");
        if (savedSpeed && animationSpeedOptions.length > 0) {
            animationSpeedOptions.forEach((opt) => opt.classList.remove("active"));
            const speedOption = document.querySelector(
                `.animation-speed .toggle-option[data-speed="${savedSpeed}"]`
            );
            if (speedOption) {
                speedOption.classList.add("active");

                // Aplicar la velocidad de animación
                let speedValue = "0.2s"; // normal por defecto
                if (savedSpeed === "slow") {
                    speedValue = "0.4s";
                } else if (savedSpeed === "fast") {
                    speedValue = "0.1s";
                }
                document.documentElement.style.setProperty(
                    "--animation-speed",
                    speedValue
                );
            }
        }

        // Actualizar cuando se cambia el toggle
        animationsToggle.addEventListener("change", function () {
            if (this.checked) {
                document.body.classList.remove("no-animations");
                localStorage.setItem("animations", "enabled");
                if (animationSpeedContainer) {
                    animationSpeedContainer.style.display = "block";
                }
            } else {
                document.body.classList.add("no-animations");
                localStorage.setItem("animations", "disabled");
                if (animationSpeedContainer) {
                    animationSpeedContainer.style.display = "none";
                }
            }
        });

        // Manejar opciones de velocidad de animación
        if (animationSpeedOptions.length > 0) {
            animationSpeedOptions.forEach((option) => {
                option.addEventListener("click", function () {
                    // Desactivar todas las opciones
                    animationSpeedOptions.forEach((opt) =>
                        opt.classList.remove("active")
                    );

                    // Activar la opción seleccionada
                    this.classList.add("active");

                    // Obtener la velocidad
                    const speed = this.getAttribute("data-speed");
                    localStorage.setItem("animationSpeed", speed);

                    // Aplicar la velocidad de animación
                    let speedValue = "0.2s"; // normal por defecto
                    if (speed === "slow") {
                        speedValue = "0.4s";
                    } else if (speed === "fast") {
                        speedValue = "0.1s";
                    }
                    document.documentElement.style.setProperty(
                        "--animation-speed",
                        speedValue
                    );
                });
            });
        }
    }

    // 4. Alto contraste
    const highContrastToggle = document.getElementById("high-contrast-toggle");

    if (highContrastToggle) {
        // Inicializar con el valor guardado o el valor por defecto
        const savedHighContrast = localStorage.getItem("highContrast");
        if (savedHighContrast === "enabled") {
            highContrastToggle.checked = true;
            document.body.classList.add("high-contrast");
        } else {
            highContrastToggle.checked = false;
            document.body.classList.remove("high-contrast");
        }

        // Actualizar cuando se cambia el toggle
        highContrastToggle.addEventListener("change", function () {
            if (this.checked) {
                document.body.classList.add("high-contrast");
                localStorage.setItem("highContrast", "enabled");
            } else {
                document.body.classList.remove("high-contrast");
                localStorage.setItem("highContrast", "disabled");
            }
        });
    }

    // 5. Tipografía
    const fontFamilySelect = document.getElementById("font-family-select");
    const fontWeightSelect = document.getElementById("font-weight-select");
    const fontPreview = document.querySelector(".font-preview");
    const fontWeightSamples = document.querySelectorAll(".font-weight-sample");

    // Función para aplicar la tipografía a toda la página
    function applyGlobalFontFamily(fontFamily) {
        // Aplicar al elemento raíz (html)
        document.documentElement.style.fontFamily = fontFamily;
        // Aplicar a body
        document.body.style.fontFamily = fontFamily;
        // Guardar en variables CSS
        document.documentElement.style.setProperty("--font-family", fontFamily);
        // Guardar en localStorage
        localStorage.setItem("fontFamily", fontFamily);

        // Aplicar a todos los elementos principales para asegurar que se aplique en toda la página
        const mainElements = document.querySelectorAll(
            "div, p, h1, h2, h3, h4, h5, h6, span, a, button, input, select, textarea, li, label"
        );
        mainElements.forEach((element) => {
            element.style.fontFamily = fontFamily;
        });
    }

    // Función para aplicar el peso de fuente a toda la página
    function applyGlobalFontWeight(fontWeight) {
        // Aplicar al elemento raíz (html)
        document.documentElement.style.fontWeight = fontWeight;
        // Aplicar a body
        document.body.style.fontWeight = fontWeight;
        // Guardar en variables CSS
        document.documentElement.style.setProperty("--font-weight", fontWeight);
        // Guardar en localStorage
        localStorage.setItem("fontWeight", fontWeight);

        // Aplicar a todos los elementos principales para asegurar que se aplique en toda la página
        // Excluimos headings (h1-h6) ya que normalmente tienen sus propios pesos
        const mainElements = document.querySelectorAll(
            "div, p, span, a, button, input, select, textarea, li, label"
        );
        mainElements.forEach((element) => {
            // No sobrescribir elementos que tengan un peso específico definido en una clase
            if (!element.classList.contains("font-weight-sample")) {
                element.style.fontWeight = fontWeight;
            }
        });
    }

    // Inicializar tipografía
    function initializeFontSettings() {
        if (!fontFamilySelect) return;

        const savedFontFamily = localStorage.getItem("fontFamily");
        if (savedFontFamily) {
            // Aplicar la fuente guardada a toda la página
            applyGlobalFontFamily(savedFontFamily);

            // Seleccionar la opción correspondiente en el select
            for (let i = 0; i < fontFamilySelect.options.length; i++) {
                if (fontFamilySelect.options[i].value === savedFontFamily) {
                    fontFamilySelect.selectedIndex = i;
                    break;
                }
            }
        }

        const savedFontWeight = localStorage.getItem("fontWeight");
        if (savedFontWeight && fontWeightSelect) {
            // Aplicar el peso de fuente guardado a toda la página
            applyGlobalFontWeight(savedFontWeight);

            // Seleccionar la opción correspondiente en el select
            for (let i = 0; i < fontWeightSelect.options.length; i++) {
                if (fontWeightSelect.options[i].value === savedFontWeight) {
                    fontWeightSelect.selectedIndex = i;
                    break;
                }
            }
        }

        // Actualizar la vista previa
        if (fontPreview) {
            fontPreview.style.fontFamily = getComputedStyle(
                document.documentElement
            ).getPropertyValue("--font-family");

            if (fontWeightSelect) {
                const mainText = fontPreview.querySelector(".font-preview-text");
                if (mainText) {
                    mainText.style.fontWeight = getComputedStyle(
                        document.documentElement
                    ).getPropertyValue("--font-weight");
                }
            }
        }
    }

    if (fontFamilySelect) {
        initializeFontSettings();

        // Cambiar la tipografía
        fontFamilySelect.addEventListener("change", function () {
            const fontFamily = this.value;

            // Aplicar la fuente a toda la página
            applyGlobalFontFamily(fontFamily);

            // Actualizar la vista previa
            if (fontPreview) {
                fontPreview.style.fontFamily = fontFamily;

                // Actualizar las muestras de peso
                if (fontWeightSamples) {
                    fontWeightSamples.forEach((sample) => {
                        sample.style.fontFamily = fontFamily;
                    });
                }
            }
        });
    }

    if (fontWeightSelect) {
        // Cambiar el peso de la fuente
        fontWeightSelect.addEventListener("change", function () {
            const fontWeight = this.value;

            // Aplicar el peso de fuente a toda la página
            applyGlobalFontWeight(fontWeight);

            // Actualizar la vista previa
            if (fontPreview) {
                const mainText = fontPreview.querySelector(".font-preview-text");
                if (mainText) {
                    mainText.style.fontWeight = fontWeight;
                }
            }
        });
    }

    // 6. Presets de apariencia
    const presetOptions = document.querySelectorAll(".preset-option");

    if (presetOptions.length > 0) {
        presetOptions.forEach((option) => {
            option.addEventListener("click", function () {
                const preset = this.getAttribute("data-preset");

                // Aplicar el preset
                switch (preset) {
                    case "default":
                        // Tema claro
                        themeOptions.forEach((opt) => opt.classList.remove("active"));
                        themeOptions[0].classList.add("active");
                        document.body.classList.remove("dark-mode");
                        localStorage.setItem("theme", "light");

                        // Color azul
                        document.documentElement.style.setProperty(
                            "--primary-color",
                            "#007AFF"
                        );
                        document.documentElement.style.setProperty(
                            "--primary-light",
                            "rgba(0, 122, 255, 0.1)"
                        );
                        localStorage.setItem("accentColor", "#007AFF");

                        // Tipografía
                        if (fontFamilySelect) {
                            for (let i = 0; i < fontFamilySelect.options.length; i++) {
                                if (
                                    fontFamilySelect.options[i].value ===
                                    '"SF Pro Display", -apple-system, BlinkMacSystemFont, sans-serif'
                                ) {
                                    fontFamilySelect.selectedIndex = i;
                                    break;
                                }
                            }
                        }
                        // Aplicar la fuente a toda la página
                        applyGlobalFontFamily(
                            '"SF Pro Display", -apple-system, BlinkMacSystemFont, sans-serif'
                        );

                        // Peso de fuente
                        if (fontWeightSelect) {
                            for (let i = 0; i < fontWeightSelect.options.length; i++) {
                                if (fontWeightSelect.options[i].value === "400") {
                                    fontWeightSelect.selectedIndex = i;
                                    break;
                                }
                            }
                        }
                        // Aplicar el peso de fuente a toda la página
                        applyGlobalFontWeight("400");

                        // Animaciones activadas
                        if (animationsToggle) {
                            animationsToggle.checked = true;
                            document.body.classList.remove("no-animations");
                            localStorage.setItem("animations", "enabled");

                            // Velocidad normal
                            document.documentElement.style.setProperty(
                                "--animation-speed",
                                "0.2s"
                            );
                            localStorage.setItem("animationSpeed", "normal");

                            if (animationSpeedContainer) {
                                animationSpeedContainer.style.display = "block";
                            }

                            // Actualizar UI de velocidad
                            animationSpeedOptions.forEach((opt) =>
                                opt.classList.remove("active")
                            );
                            const normalOption = document.querySelector(
                                '.animation-speed .toggle-option[data-speed="normal"]'
                            );
                            if (normalOption) normalOption.classList.add("active");
                        }

                        // Alto contraste desactivado
                        if (highContrastToggle) {
                            highContrastToggle.checked = false;
                            document.body.classList.remove("high-contrast");
                            localStorage.setItem("highContrast", "disabled");
                        }
                        break;

                    case "modern":
                        // Tema oscuro
                        themeOptions.forEach((opt) => opt.classList.remove("active"));
                        themeOptions[1].classList.add("active");
                        document.body.classList.add("dark-mode");
                        localStorage.setItem("theme", "dark");

                        // Color púrpura
                        document.documentElement.style.setProperty(
                            "--primary-color",
                            "#5856D6"
                        );
                        document.documentElement.style.setProperty(
                            "--primary-light",
                            "rgba(88, 86, 214, 0.1)"
                        );
                        localStorage.setItem("accentColor", "#5856D6");

                        // Tipografía
                        if (fontFamilySelect) {
                            for (let i = 0; i < fontFamilySelect.options.length; i++) {
                                if (
                                    fontFamilySelect.options[i].value === '"Poppins", sans-serif'
                                ) {
                                    fontFamilySelect.selectedIndex = i;
                                    break;
                                }
                            }
                        }
                        // Aplicar la fuente a toda la página
                        applyGlobalFontFamily('"Poppins", sans-serif');

                        // Peso de fuente
                        if (fontWeightSelect) {
                            for (let i = 0; i < fontWeightSelect.options.length; i++) {
                                if (fontWeightSelect.options[i].value === "500") {
                                    fontWeightSelect.selectedIndex = i;
                                    break;
                                }
                            }
                        }
                        // Aplicar el peso de fuente a toda la página
                        applyGlobalFontWeight("500");

                        // Animaciones rápidas
                        if (animationsToggle) {
                            animationsToggle.checked = true;
                            document.body.classList.remove("no-animations");
                            localStorage.setItem("animations", "enabled");

                            // Velocidad rápida
                            document.documentElement.style.setProperty(
                                "--animation-speed",
                                "0.1s"
                            );
                            localStorage.setItem("animationSpeed", "fast");

                            if (animationSpeedContainer) {
                                animationSpeedContainer.style.display = "block";
                            }

                            // Actualizar UI de velocidad
                            animationSpeedOptions.forEach((opt) =>
                                opt.classList.remove("active")
                            );
                            const fastOption = document.querySelector(
                                '.animation-speed .toggle-option[data-speed="fast"]'
                            );
                            if (fastOption) fastOption.classList.add("active");
                        }
                        break;

                    case "classic":
                        // Tema oscuro
                        themeOptions.forEach((opt) => opt.classList.remove("active"));
                        themeOptions[1].classList.add("active");
                        document.body.classList.add("dark-mode");
                        localStorage.setItem("theme", "dark");

                        // Color azul oscuro
                        document.documentElement.style.setProperty(
                            "--primary-color",
                            "#0A84FF"
                        );
                        document.documentElement.style.setProperty(
                            "--primary-light",
                            "rgba(10, 132, 255, 0.1)"
                        );
                        localStorage.setItem("accentColor", "#0A84FF");

                        // Tipografía
                        if (fontFamilySelect) {
                            for (let i = 0; i < fontFamilySelect.options.length; i++) {
                                if (fontFamilySelect.options[i].value === '"Georgia", serif') {
                                    fontFamilySelect.selectedIndex = i;
                                    break;
                                }
                            }
                        }
                        // Aplicar la fuente a toda la página
                        applyGlobalFontFamily('"Georgia", serif');

                        // Peso de fuente
                        if (fontWeightSelect) {
                            for (let i = 0; i < fontWeightSelect.options.length; i++) {
                                if (fontWeightSelect.options[i].value === "400") {
                                    fontWeightSelect.selectedIndex = i;
                                    break;
                                }
                            }
                        }
                        // Aplicar el peso de fuente a toda la página
                        applyGlobalFontWeight("400");

                        // Animaciones lentas
                        if (animationsToggle) {
                            animationsToggle.checked = true;
                            document.body.classList.remove("no-animations");
                            localStorage.setItem("animations", "enabled");

                            // Velocidad lenta
                            document.documentElement.style.setProperty(
                                "--animation-speed",
                                "0.4s"
                            );
                            localStorage.setItem("animationSpeed", "slow");

                            if (animationSpeedContainer) {
                                animationSpeedContainer.style.display = "block";
                            }

                            // Actualizar UI de velocidad
                            animationSpeedOptions.forEach((opt) =>
                                opt.classList.remove("active")
                            );
                            const slowOption = document.querySelector(
                                '.animation-speed .toggle-option[data-speed="slow"]'
                            );
                            if (slowOption) slowOption.classList.add("active");
                        }
                        break;

                    case "minimal":
                        // Tema claro
                        themeOptions.forEach((opt) => opt.classList.remove("active"));
                        themeOptions[0].classList.add("active");
                        document.body.classList.remove("dark-mode");
                        localStorage.setItem("theme", "light");

                        // Color gris
                        document.documentElement.style.setProperty(
                            "--primary-color",
                            "#8E8E93"
                        );
                        document.documentElement.style.setProperty(
                            "--primary-light",
                            "rgba(142, 142, 147, 0.1)"
                        );
                        localStorage.setItem("accentColor", "#8E8E93");

                        // Tipografía
                        if (fontFamilySelect) {
                            for (let i = 0; i < fontFamilySelect.options.length; i++) {
                                if (
                                    fontFamilySelect.options[i].value ===
                                    '"Roboto Mono", monospace'
                                ) {
                                    fontFamilySelect.selectedIndex = i;
                                    break;
                                }
                            }
                        }
                        // Aplicar la fuente a toda la página
                        applyGlobalFontFamily('"Roboto Mono", monospace');

                        // Peso de fuente
                        if (fontWeightSelect) {
                            for (let i = 0; i < fontWeightSelect.options.length; i++) {
                                if (fontWeightSelect.options[i].value === "400") {
                                    fontWeightSelect.selectedIndex = i;
                                    break;
                                }
                            }
                        }
                        // Aplicar el peso de fuente a toda la página
                        applyGlobalFontWeight("400");

                        // Sin animaciones
                        if (animationsToggle) {
                            animationsToggle.checked = false;
                            document.body.classList.add("no-animations");
                            localStorage.setItem("animations", "disabled");
                            if (animationSpeedContainer) {
                                animationSpeedContainer.style.display = "none";
                            }
                        }
                        break;
                }

                // Actualizar la vista previa de tipografía si existe
                if (fontPreview) {
                    fontPreview.style.fontFamily = getComputedStyle(
                        document.documentElement
                    ).getPropertyValue("--font-family");
                    const mainText = fontPreview.querySelector(".font-preview-text");
                    if (mainText) {
                        mainText.style.fontWeight = getComputedStyle(
                            document.documentElement
                        ).getPropertyValue("--font-weight");
                    }
                }

                // Mostrar mensaje de éxito
                const applyBtn = document.querySelector("#appearance-tab .btn-primary");
                if (applyBtn) {
                    const originalText = applyBtn.textContent;
                    applyBtn.textContent = "¡Preset aplicado!";
                    applyBtn.disabled = true;

                    setTimeout(() => {
                        applyBtn.textContent = originalText;
                        applyBtn.disabled = false;
                    }, 1500);
                }
            });
        });
    }

    // 7. Botones de acción para la sección de apariencia
    const applyChangesBtn = document.querySelector(
        "#appearance-tab .btn-primary"
    );
    const resetDefaultBtn = document.querySelector(
        "#appearance-tab .btn-secondary"
    );

    if (applyChangesBtn) {
        applyChangesBtn.addEventListener("click", function (e) {
            e.preventDefault();

            // Guardar todas las preferencias actuales
            // Tema
            if (themeOptions[0].classList.contains("active")) {
                localStorage.setItem("theme", "light");
                localStorage.setItem("darkMode", "disabled");
            } else if (themeOptions[1].classList.contains("active")) {
                localStorage.setItem("theme", "dark");
                localStorage.setItem("darkMode", "enabled");
            } else if (themeOptions[2].classList.contains("active")) {
                localStorage.setItem("theme", "system");
                localStorage.removeItem("darkMode");
            }

            // Color de acento
            const activeColorOption = document.querySelector(".color-option.active");
            if (activeColorOption) {
                const color =
                    activeColorOption.style.getPropertyValue("--color").trim() ||
                    getComputedStyle(activeColorOption)
                        .getPropertyValue("--color")
                        .trim();
                localStorage.setItem("accentColor", color);

                // Actualizar el color claro para fondos
                const colorRGB = hexToRgb(color);
                if (colorRGB) {
                    const lightColor = `rgba(${colorRGB.r}, ${colorRGB.g}, ${colorRGB.b}, 0.1)`;
                    localStorage.setItem("accentLightColor", lightColor);
                }
            }

            // Guardar configuración de animaciones
            if (animationsToggle) {
                localStorage.setItem(
                    "animations",
                    animationsToggle.checked ? "enabled" : "disabled"
                );

                // Guardar velocidad de animación
                const activeSpeedOption = document.querySelector(
                    ".animation-speed .toggle-option.active"
                );
                if (activeSpeedOption) {
                    localStorage.setItem(
                        "animationSpeed",
                        activeSpeedOption.getAttribute("data-speed")
                    );
                }
            }

            // Guardar configuración de alto contraste
            if (highContrastToggle) {
                localStorage.setItem(
                    "highContrast",
                    highContrastToggle.checked ? "enabled" : "disabled"
                );
            }

            // Guardar color personalizado
            if (customColorInput && customColorInput.value) {
                localStorage.setItem("customColor", customColorInput.value);
            }

            // Guardar tipografía
            if (fontFamilySelect) {
                localStorage.setItem("fontFamily", fontFamilySelect.value);
                // Aplicar la fuente a toda la página
                applyGlobalFontFamily(fontFamilySelect.value);
            }

            if (fontWeightSelect) {
                localStorage.setItem("fontWeight", fontWeightSelect.value);
                // Aplicar el peso de fuente a toda la página
                applyGlobalFontWeight(fontWeightSelect.value);
            }

            // Mostrar mensaje de éxito
            const originalText = this.textContent;
            this.textContent = "¡Cambios aplicados!";
            this.disabled = true;

            // Restaurar el texto original después de un tiempo
            setTimeout(() => {
                this.textContent = originalText;
                this.disabled = false;
            }, 2000);
        });
    }

    if (resetDefaultBtn) {
        resetDefaultBtn.addEventListener("click", function (e) {
            e.preventDefault();

            // Restablecer valores predeterminados
            // Tema
            themeOptions.forEach((opt) => opt.classList.remove("active"));
            themeOptions[0].classList.add("active");
            document.body.classList.remove("dark-mode");
            localStorage.setItem("theme", "light");
            localStorage.setItem("darkMode", "disabled");
            if (darkModeSwitch) darkModeSwitch.checked = false;

            // Color de acento
            const defaultColorOption = document.querySelector(
                '.color-option[style*="--color: #007AFF"]'
            );
            if (defaultColorOption) {
                colorOptions.forEach((opt) => opt.classList.remove("active"));
                defaultColorOption.classList.add("active");
                document.documentElement.style.setProperty(
                    "--primary-color",
                    "#007AFF"
                );
                document.documentElement.style.setProperty(
                    "--primary-light",
                    "rgba(0, 122, 255, 0.1)"
                );
                localStorage.setItem("accentColor", "#007AFF");
                localStorage.setItem("accentLightColor", "rgba(0, 122, 255, 0.1)");
            }

            // Restablecer animaciones
            if (animationsToggle) {
                animationsToggle.checked = true;
                document.body.classList.remove("no-animations");
                localStorage.setItem("animations", "enabled");

                // Restablecer velocidad de animación
                const speedOptions = document.querySelectorAll(
                    ".animation-speed .toggle-option"
                );
                speedOptions.forEach((opt) => opt.classList.remove("active"));
                const normalSpeedOption = document.querySelector(
                    '.animation-speed .toggle-option[data-speed="normal"]'
                );
                if (normalSpeedOption) {
                    normalSpeedOption.classList.add("active");
                    document.documentElement.style.setProperty(
                        "--animation-speed",
                        "0.2s"
                    );
                    localStorage.setItem("animationSpeed", "normal");
                }

                if (animationSpeedContainer) {
                    animationSpeedContainer.style.display = "block";
                }
            }

            // Restablecer alto contraste
            if (highContrastToggle) {
                highContrastToggle.checked = false;
                document.body.classList.remove("high-contrast");
                localStorage.setItem("highContrast", "disabled");
            }

            // Restablecer color personalizado
            if (customColorInput && colorHexInput && colorPreview) {
                customColorInput.value = "#007AFF";
                colorHexInput.value = "#007AFF";
                colorPreview.style.backgroundColor = "#007AFF";
                localStorage.setItem("customColor", "#007AFF");
            }

            // Restablecer tipografía
            if (fontFamilySelect) {
                for (let i = 0; i < fontFamilySelect.options.length; i++) {
                    if (
                        fontFamilySelect.options[i].value ===
                        '"SF Pro Display", -apple-system, BlinkMacSystemFont, sans-serif'
                    ) {
                        fontFamilySelect.selectedIndex = i;
                        break;
                    }
                }
                // Aplicar la fuente a toda la página
                applyGlobalFontFamily(
                    '"SF Pro Display", -apple-system, BlinkMacSystemFont, sans-serif'
                );
            }

            if (fontWeightSelect) {
                for (let i = 0; i < fontWeightSelect.options.length; i++) {
                    if (fontWeightSelect.options[i].value === "400") {
                        fontWeightSelect.selectedIndex = i;
                        break;
                    }
                }
                // Aplicar el peso de fuente a toda la página
                applyGlobalFontWeight("400");
            }

            // Mostrar mensaje de éxito
            const originalText = this.textContent;
            this.textContent = "¡Valores restablecidos!";
            this.disabled = true;

            // Restaurar el texto original después de un tiempo
            setTimeout(() => {
                this.textContent = originalText;
                this.disabled = false;
            }, 2000);
        });
    }
    
    
});

// Aplica las variables guardadas en localStorage
(function applyUserSettingsInline() {
    const root = document.documentElement;
  
    // ——— Tema ———
    const theme = localStorage.getItem("theme") || "light";
    if (theme === "dark") {
      root.style.setProperty("--panel-color", "#2c2c2e");
      root.style.setProperty("--text-color", "#ffffff");
      root.style.setProperty("--text-secondary", "#a0a0a0");
      root.style.setProperty("--border-color", "#3c3c3e");
    } else {
      root.style.setProperty("--panel-color", "#ffffff");
      root.style.setProperty("--text-color", "#000000");
      root.style.setProperty("--text-secondary", "#6e6e73");
      root.style.setProperty("--border-color", "#e5e5ea");
    }
  
    // ——— Color de acento ———
    const accent = localStorage.getItem("accentColor") || "#007AFF";
    root.style.setProperty("--primary-color", accent);
    // Calcular RGB para transparencia
    const hex = accent.replace(/^#/, "");
    const r = parseInt(hex.substr(0, 2), 16),
          g = parseInt(hex.substr(2, 2), 16),
          b = parseInt(hex.substr(4, 2), 16);
    root.style.setProperty("--primary-color-rgb", `${r}, ${g}, ${b}`);
    root.style.setProperty("--primary-light", `rgba(${r}, ${g}, ${b}, 0.1)`);
  
    // ——— Tipografía ———
    const fontFamily = localStorage.getItem("fontFamily") 
                         || "'SF Pro Display', -apple-system, sans-serif";
    const fontWeight = localStorage.getItem("fontWeight") || "400";
    root.style.setProperty("--font-family", fontFamily);
    root.style.setProperty("--font-weight", fontWeight);
    document.body.style.fontFamily = fontFamily;
    document.body.style.fontWeight = fontWeight;
  })();
  


