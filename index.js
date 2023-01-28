$(document).ready(function () {
    modal()
    display_product_index()

    function display_product_index() {
        $.ajax({
            type: "POST",
            url: "controleur.php",
            data: {
                'display_product_index': true
            },
            success: function (response) {
                // console.table(response)
                $.each(response, function (key, value) {
                    $('.display_product').append(`<div class="col-lg-2 mt-3">\
                    <div class="text-center">\
                        <img src="${value.product_img}" style="height: 150px">\
                    </div>\
                    <h2 class="text-center">${value.product_name}</h2>\
                    <h2 class="text-center">${value.product_prix} ar</h2>\
                    </div>`);
                });
            }
        });
    }

    $('.formulaire').submit(function (e) { 
        e.preventDefault();
        const name = $('.nom').val();
        const last_name = $('.prenom').val();
        const cin = $('.cin').val();
        const email = $('.email').val();
        const tel = $('.tel').val();
        const mdp = $('.mdp').val();
        $.ajax({
            type: "post",
            url: "controleur.php",
            data: {
                nom : name,
                prenom : last_name,
                cin : cin,
                email : email,
                tel : tel,
                mdp : mdp,
                add_user : true
            },
            success: function (response) {
                $('.nom').val('');
                $('.prenom').val('');
                $('.cin').val('');
                $('.email').val('');
                $('.tel').val('');
                $('.mdp').val('');
                $('.message').html(response);
                const reload = setTimeout(reload_page, 3000);
                function reload_page () {
                    location.reload()
                }
            }
        });
    });
});

const modal = () => {
    var modal = document.getElementById('log')
    var modal1 = document.getElementById('form')
    var modal2= document.getElementById('admin')
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        } else if (event.target == modal1) {
            modal1.style.display = "none";
        }
        else if (event.target == modal2){
          modal2.style.display = "none";
        }
    }
}