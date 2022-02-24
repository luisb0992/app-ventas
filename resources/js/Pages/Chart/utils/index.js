/**
 * Gestiona el comportamiento de los elementos de la página de gráficos
 *
 * @author Luisbardev <luisbardev@gmail.com> luisbardev.com
 */

import { randomKey } from "@/utils/functions.js";
import { Chart, registerables } from "chart.js";
import { reactive, ref } from "vue";
Chart.register(...registerables);

//clases para activar o inactivar botones
const classes = {
    active: "py-2.5 px-5 mr-2 mb-2 text-sm font-medium rounded-full border focus:z-10 focus:ring-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-blue-300",
    inactive:
        "py-2.5 px-5 mr-2 mb-2 text-sm font-medium rounded-full border focus:z-10 focus:ring-2 text-gray-900 bg-white border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700",
};

// computed data doughnut
export const chartData = (objBrand) => {
    return  reactive({
        labels: objBrand.labels,
        datasets: [
            {
                data: objBrand.totalSales,
                backgroundColor: [
                    "#3e95cd",
                    "#FF9200",
                    "#8e5ea2",
                    "#3cba9f",
                    "#c45850",
                    "#97B0C4",
                    "#123E6B",
                    "#FFB400",
                    "#28B328",
                ],
            },
        ],
    });
};

// opciones de configuración del chart
export const chartOptions = ref({
    responsive: true,
    plugins: {
        legend: {
            display: false,
        },
    },
});

/**
 * Filtra los datos según sea su tipo
 * Ya sea por dia, mes o año
 *
 * @param {HTMLBaseElement} event - el elemento que dispara el evento
 * @param {Number} type -           el tipo de filtro a ejecutar
 */
export const setData = async (event, type, objBrand) => {
    // desactivar todos los botones
    document
        .querySelectorAll("#btns button")
        .forEach((btn) => (btn.className = classes.inactive));

    // activar el botón presionado
    event.target.className = classes.active;

    try {
        // yearly data
        const data = await axios.get(route("brands.data.date", type));

        // setear los datos principales
        objBrand.totalSales = await data.data.map((brand) => brand.sumSales);

        // sumar el monto total de ventas de todas las marcas
        objBrand.sumAllSales = await data.data.reduce(
            (total, brand) => total + brand.sumSales,
            0
        );

        objBrand.brands = randomKey(data.data);
    } catch (error) {
        console.log(error);
    }
};
