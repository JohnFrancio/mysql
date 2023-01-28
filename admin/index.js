$(document).ready(function () {
    graphe()

    function graphe() {
        $.ajax({
            type: "post",
            url: "../controleur.php",
            data: {
                graphe: true
            },
            success: function (response) {
                $.each(response, function (key, value) {
                    chart(value.num_produit, value.num_com)
                    recherche();
                });
            }
        });
    }
});

function chart(numOne, numTwo) {
    // bar
    const ctx = document.getElementById('graphe');
    const dataset = [numOne, numTwo];
    // console.log(data);
    const data = {
        labels: ["Nombre de produit", "Nombre de commande"],
        datasets: [{
            data: dataset,
            fillColor: (
                "rgba(255,99,132,0.2)",
                "rgba(151,187,205,0.5)"
            ),
            strokeColor: (
                "rgba(255,99,132,1)",
                "rgba(151,187,205,1)"
            )
        }]
    }
    const myLine = new Chart(ctx.getContext("2d")).Bar(data);
    // doghnut
    var doughnutData = [{
        value: dataset[0],
        color: "#F7464A"
    },
    {
        value: dataset[1],
        color: "#000"
    }
    ];
    var myDoughnut = new Chart(document.getElementById("graphe1").getContext("2d")).Doughnut(doughnutData);

}