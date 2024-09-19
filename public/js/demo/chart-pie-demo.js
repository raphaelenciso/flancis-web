function generateColors(count) {
    var colors = [];
    var hue = 0;
    var saturation = 70;
    var lightness = 50;

    for (var i = 0; i < count; i++) {
        colors.push(`hsl(${hue}, ${saturation}%, ${lightness}%)`);
        hue += 360 / count;
    }

    return colors;
}

function LightenDarkenColor(col, amt) {
    var usePound = false;
    if (col[0] == "#") {
        col = col.slice(1);
        usePound = true;
    }
    var num = parseInt(col, 16);
    var r = (num >> 16) + amt;
    var b = ((num >> 8) & 0x00ff) + amt;
    var g = (num & 0x0000ff) + amt;
    r = r > 255 ? 255 : r < 0 ? 0 : r;
    b = b > 255 ? 255 : b < 0 ? 0 : b;
    g = g > 255 ? 255 : g < 0 ? 0 : g;
    return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16);
}

function createPieChart(ctx, data) {
    return new Chart(ctx, {
        type: "doughnut",
        data,
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: "#dddfeb",
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: true,
            },
            cutoutPercentage: 0,
        },
    });
}

// var myPieChart = new Chart(ctx, {
//     type: "doughnut",
//     data: {
//         labels: ["Direct", "Referral", "Social"],
//         datasets: [
//             {
//                 data: [55, 30, 15],
//                 backgroundColor: ["#4e73df", "#1cc88a", "#36b9cc"],
//                 hoverBackgroundColor: ["#2e59d9", "#17a673", "#2c9faf"],
//                 hoverBorderColor: "rgba(234, 236, 244, 1)",
//             },
//         ],
//     },
//     options: {
//         maintainAspectRatio: false,
//         tooltips: {
//             backgroundColor: "rgb(255,255,255)",
//             bodyFontColor: "#858796",
//             borderColor: "#dddfeb",
//             borderWidth: 1,
//             xPadding: 15,
//             yPadding: 15,
//             displayColors: false,
//             caretPadding: 10,
//         },
//         legend: {
//             display: false,
//         },
//         cutoutPercentage: 80,
//     },
// });
