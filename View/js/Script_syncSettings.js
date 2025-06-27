// File: js/syncSettings.js

/**
 * syncWithSettings()
 * ------------------
 * Lee las preferencias guardadas en localStorage bajo Settings
 * y aplica en tiempo real:
 *   1. Tema claro/oscuro
 *   2. Color de acento (--primary-color y variantes RGB)
 *   3. Tipografía (font-family y font-weight)
 *   4. Animaciones (activar/desactivar)
 *   5. Velocidad de animación (--animation-speed)
 *   6. Alto contraste (clase .high-contrast)
 *   7. Bordes redondeados (--card-radius etc.)
 *   8. Densidad de layout (.compact-layout, .spacious-layout)
 *   9. Color de hover (--hover-color)
 *  10. Preserva intactos los iconos FontAwesome
 */
function syncWithSettings() {
    console.log(
        "%c[syncSettings] ▶ Sincronizando Settings…",
        "color: teal; font-weight: bold;"
    );

    const root = document.documentElement;
    const body = document.body;

    // —— 1) TEMA claro/oscuro ——
    const theme = localStorage.getItem("theme") || "light";
    const darkMode =
        theme === "dark" || localStorage.getItem("darkMode") === "enabled";
    body.classList.toggle("dark-mode", darkMode);
    console.log(" • Tema:", darkMode ? "dark" : "light");

    // —— 2) COLOR DE ACENTO ——
    const accent = localStorage.getItem("accentColor");
    if (accent) {
        root.style.setProperty("--primary-color", accent);

        // Convertimos a RGB
        const hex = accent.replace(/^#/, "");
        const r = parseInt(hex.substr(0, 2), 16),
            g = parseInt(hex.substr(2, 2), 16),
            b = parseInt(hex.substr(4, 2), 16);
        const rgb = `${r}, ${g}, ${b}`;
        root.style.setProperty("--primary-color-rgb", rgb);
        root.style.setProperty("--primary-light", `rgba(${rgb}, 0.1)`);
        console.log(` • Acento: ${accent} (rgb: ${rgb})`);
    }

    // —— 3) TIPOGRAFÍA Y PESO ——
    const fontFamily = localStorage.getItem("fontFamily");
    const fontWeight = localStorage.getItem("fontWeight");
    if (fontFamily) {
        root.style.setProperty("--font-family", fontFamily);
        body.style.fontFamily = fontFamily;
        console.log(" • Fuente:", fontFamily);
    }
    if (fontWeight) {
        root.style.setProperty("--font-weight", fontWeight);
        body.style.fontWeight = fontWeight;
        console.log(" • Peso:", fontWeight);
    }
    // Aplicamos a todo menos iconos FA
    document.querySelectorAll("*").forEach((el) => {
        if (
            (el.tagName === "I" &&
                [...el.classList].some((c) => c.startsWith("fa"))) ||
            el.getAttribute("aria-hidden") === "true"
        )
            return;
        if (fontFamily) el.style.fontFamily = fontFamily;
        if (fontWeight) el.style.fontWeight = fontWeight;
    });

    // —— 4) ANIMACIONES ——
    const animationsOff = localStorage.getItem("animations") === "disabled";
    body.classList.toggle("no-animations", animationsOff);
    console.log(" • Animaciones:", animationsOff ? "off" : "on");

    // —— 5) VELOCIDAD DE ANIMACIÓN ——
    const speed = localStorage.getItem("animationSpeed") || "normal";
    let speedVal = "0.2s";
    if (speed === "slow") speedVal = "0.4s";
    if (speed === "fast") speedVal = "0.1s";
    root.style.setProperty("--animation-speed", speedVal);
    console.log(" • Velocidad animación:", speedVal);

    // —— 6) ALTO CONTRASTE ——
    const highContrast = localStorage.getItem("highContrast") === "enabled";
    body.classList.toggle("high-contrast", highContrast);
    console.log(" • Alto contraste:", highContrast);

    // —— 7) RADIO DE BORDES ——
    const borderStyle = localStorage.getItem("borderRadius");
    if (borderStyle) {
        let card = "16px",
            btn = "10px",
            inp = "10px";
        if (borderStyle === "rounded") {
            card = "20px";
            btn = "12px";
            inp = "12px";
        } else if (borderStyle === "square") {
            card = "4px";
            btn = "4px";
            inp = "4px";
        }
        root.style.setProperty("--card-radius", card);
        root.style.setProperty("--button-radius", btn);
        root.style.setProperty("--input-radius", inp);
        console.log(` • Bordes: ${borderStyle}`);
    }

    // —— 8) DENSIDAD DE LAYOUT ——
    body.classList.remove("compact-layout", "spacious-layout");
    const density = localStorage.getItem("layoutDensity");
    if (density === "compact") body.classList.add("compact-layout");
    else if (density === "spacious") body.classList.add("spacious-layout");
    console.log(" • Layout density:", density || "default");

    // —— 9) COLOR DE HOVER ——
    const hoverColor = localStorage.getItem("hoverColor");
    if (hoverColor) {
        root.style.setProperty("--hover-color", hoverColor);
        console.log(" • Hover color:", hoverColor);
    }

    console.log("%c[syncSettings] ✔ Hecho", "color: green; font-weight: bold;");
}

// —— Ejecuta en carga y en intervalos/eventos storage ——
syncWithSettings();
setInterval(syncWithSettings, 500);
window.addEventListener("storage", syncWithSettings);
