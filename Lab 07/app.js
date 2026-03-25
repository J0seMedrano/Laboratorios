import { supabase } from "./supabase.js";

// ─────────────────────────────────────────
// Referencias al DOM
// ─────────────────────────────────────────
const txtSearch  = document.getElementById("txtSearch");
const selOrder   = document.getElementById("selOrder");
const btnLoad    = document.getElementById("btnLoad");
const btnClear   = document.getElementById("btnClear");
const tbody      = document.getElementById("tbodyStudents");
const statusMsg  = document.getElementById("statusMsg");

// ─────────────────────────────────────────
// Eventos  (addEventListener, sin inline)
// ─────────────────────────────────────────
btnLoad.addEventListener("click", () => consultarEstudiantes());
btnClear.addEventListener("click", () => limpiar());

// Búsqueda en vivo mientras el usuario escribe
txtSearch.addEventListener("input", () => consultarEstudiantes());

// Re-consultar al cambiar el orden
selOrder.addEventListener("change", () => consultarEstudiantes());

// ─────────────────────────────────────────
// Helpers de estado
// ─────────────────────────────────────────
/**
 * Muestra un mensaje de estado en pantalla.
 * @param {string} texto  - Mensaje a mostrar.
 * @param {'muted'|'loading'|'empty'|'error'} tipo - Clase visual.
 */
const mostrarEstado = (texto, tipo = "muted") => {
  statusMsg.textContent = texto;
  statusMsg.className = `status status-${tipo}`;
  statusMsg.style.display = "block";
};

const ocultarEstado = () => {
  statusMsg.style.display = "none";
};

// ─────────────────────────────────────────
// Render de la tabla
// ─────────────────────────────────────────
/**
 * Genera las filas de la tabla a partir del arreglo de estudiantes.
 * @param {Array} data - Arreglo de objetos estudiante.
 */
const renderTabla = (data) => {
  tbody.innerHTML = "";

  data.forEach((r) => {
    const tr = document.createElement("tr");
    tr.setAttribute("data-id", r.id);

    // Nombre completo con badge de carrera
    ["nombre", "apellido", "correo"].forEach((campo) => {
      const td = document.createElement("td");
      td.textContent = r[campo] ?? "";
      tr.appendChild(td);
    });

    const tdCarrera = document.createElement("td");
    if (r.carrera) {
      const badge = document.createElement("span");
      badge.className = "badge";
      badge.textContent = r.carrera;
      tdCarrera.appendChild(badge);
    }
    tr.appendChild(tdCarrera);

    tbody.appendChild(tr);
  });
};

// ─────────────────────────────────────────
// Consulta principal
// ─────────────────────────────────────────
const consultarEstudiantes = async () => {
  const search = txtSearch.value.trim();
  const orden  = selOrder.value; // "asc" | "desc"

  mostrarEstado("Cargando...", "loading");
  tbody.innerHTML = "";

  // Construir la query
  const query = supabase
    .from("estudiantes")
    .select("id, nombre, apellido, correo, carrera")
    .order("nombre", { ascending: orden === "asc" });

  // Filtro por nombre o apellido (búsqueda parcial, sin importar mayúsculas)
  if (search.length > 0) {
    query.or(`nombre.ilike.%${search}%,apellido.ilike.%${search}%`);
  }

  const { data, error } = await query;

  // ── Manejo de errores ──
  if (error) {
    console.error("Error Supabase:", error);
    mostrarEstado(`Error al cargar los datos: ${error.message}`, "error");
    return;
  }

  // ── Sin resultados ──
  if (!data || data.length === 0) {
    mostrarEstado(
      search.length > 0
        ? `No se encontraron estudiantes con "${search}".`
        : "No hay estudiantes registrados.",
      "empty"
    );
    return;
  }

  // ── Resultados OK ──
  ocultarEstado();
  renderTabla(data);
};

// ─────────────────────────────────────────
// Limpiar búsqueda y tabla
// ─────────────────────────────────────────
const limpiar = () => {
  txtSearch.value = "";
  selOrder.value  = "asc";
  tbody.innerHTML = "";
  ocultarEstado();
};

// ─────────────────────────────────────────
// Carga inicial al abrir la página
// ─────────────────────────────────────────
consultarEstudiantes();
