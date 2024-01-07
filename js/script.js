$(document).ready(function() {
    const currentYear = new Date().getFullYear();
    $('#ano').html(currentYear);
    // Função para monitorar as seleções de moedas e corretoras
    $('input[type="checkbox"]').change(function() {
        // Conta o número de moedas selecionadas
        var moedasSelecionadas = $('#moedas input[type="checkbox"]:checked').length;
        // Conta o número de corretoras selecionadas
        var corretorasSelecionadas = $('#corretoras input[type="checkbox"]:checked').length;
        // Desabilita corretoras não selecionadas se o limite for atingido
        if (moedasSelecionadas == 1 && corretorasSelecionadas >= 11) {
          $('#moedas input[type="checkbox"]:not(:checked)').prop('disabled', true);
          return;
        }
        if (moedasSelecionadas == 0) {
          $('#corretoras input[type="checkbox"]:not(:checked)').prop('disabled', false);
          $('#moedas input[type="checkbox"]:not(:checked)').prop('disabled', false);
          return;
        }
        if (moedasSelecionadas == 1 && corretorasSelecionadas <= 10) {
          $('#corretoras input[type="checkbox"]:not(:checked)').prop('disabled', false);
          $('#moedas input[type="checkbox"]:not(:checked)').prop('disabled', false);
          return;
        }
        if (moedasSelecionadas == 2 && corretorasSelecionadas >= 10) {
          $('#corretoras input[type="checkbox"]:not(:checked)').prop('disabled', true);
          $('#moedas input[type="checkbox"]:not(:checked)').prop('disabled', true);
          return;
        }
        if(moedasSelecionadas == 2 && corretorasSelecionadas <= 5){
          $('#moedas input[type="checkbox"]:not(:checked)').prop('disabled', false);
          $('#corretoras input[type="checkbox"]:not(:checked)').prop('disabled', false);
          return;
        }
        if(moedasSelecionadas == 2 && corretorasSelecionadas > 5){
          $('#moedas input[type="checkbox"]:not(:checked)').prop('disabled', true);
          $('#corretoras input[type="checkbox"]:not(:checked)').prop('disabled', false);
          return;
        }
        if (moedasSelecionadas >= 3 && corretorasSelecionadas >= 5) {
          $('#corretoras input[type="checkbox"]:not(:checked)').prop('disabled', true);
          return;
        }
        if (moedasSelecionadas >= 3 && corretorasSelecionadas <= 4) {
          $('#corretoras input[type="checkbox"]:not(:checked)').prop('disabled', false);
          $('#moedas input[type="checkbox"]:not(:checked)').prop('disabled', false);
          return;
        }
      });
})
let timeoutId;

async function enviaInfo() {
    const checkboxes = document.querySelectorAll('#moedas input[type="checkbox"]');
    const moedas = Array.from(checkboxes).filter(checkbox => checkbox.checked).map(checkbox => checkbox.value);
    const checkboxes2 = document.querySelectorAll('#corretoras input[type="checkbox"]');
    const corretoras = Array.from(checkboxes2).filter(checkbox => checkbox.checked).map(checkbox => checkbox.value);

    try {
        await new Promise(resolve => {
            $.ajax({
                url: 'api/controller/BuscaApiController.php',
                method: 'post',
                data: { moedas: moedas, corretoras: corretoras },
                beforeSend: function () {
                    $("#pesquisarBtn").prop('disabled', true);
                    $("#pesquisarBtn").html('Carregando... <span class="mdi mdi-download"></span>');
                    $("#loading").show();
                },
                success: function (data) {
                    $('#scripts').html(data);
                },
                complete: function () {
                    $("#pesquisarBtn").prop('disabled', false);
                    $("#pesquisarBtn").html('Pesquisar <span class="mdi mdi-magnify"></span>');
                    $("#loading").hide();
                    resolve(); // Resolva a Promise após a conclusão da chamada assíncrona
                }
            });
        });
    } catch (error) {
        console.error(error);
    }
    timeoutId = setTimeout(enviaInfo, 3000);
}

// Função para parar o intervalo após clique em input
function paraIntervalo() {
    clearTimeout(timeoutId);
}
