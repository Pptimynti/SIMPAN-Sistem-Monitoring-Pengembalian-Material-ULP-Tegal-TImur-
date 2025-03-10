import "./bootstrap";

import "flowbite";
import "flowbite-datepicker";
import Swal from "sweetalert2";

window.Swal = Swal;

import Chart from "chart.js/auto";

window.Chart = Chart;

import "tom-select/dist/css/tom-select.css";
import TomSelect from "tom-select";
window.TomSelect = TomSelect;

document.querySelectorAll(".tom-select").forEach(function (el) {
    new TomSelect(el, {
        placeholder: "Pilih material...",
    });
});
