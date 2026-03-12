//importamos el cliente de supabase para interactuar con la base de datos
// este cliente ya esta configurado con la url y la clave de acceso a nuestra instancia de supabase
import { supabase } from "./supabase.js";

const btnLoad = document.getElementById("btnLoad");
const tbody = document.getElementById("tbodyStudents");

btnLoad.addEventListener("click", async () => {
  const { data, error } = await supabase.from("estudiantes").select("id,nombre,apellido,correo,carrera");

  if (error) {
    console.error(error);
    alert("Error cargando estudiantes");
    return;
  }

  tbody.innerHTML = "";

  data.forEach((r) => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
        <td>${r.id ?? ""}</td>
        <td>${r.nombre ?? ""}</td>
        <td>${r.apellido ?? ""}</td>
        <td>${r.correo ?? ""}</td>
        <td>${r.carrera ?? ""}</td>
      `;
    tbody.appendChild(tr);
  });
});

 