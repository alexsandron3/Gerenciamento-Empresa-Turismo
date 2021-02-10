//FORMATAÇÃO DOS CAMPOS INPUT PARA UM PADRÃO
$('input[name="cpfCliente"]').mask('000.000.000-00');
$('input[name="telefoneCliente"]').mask('0000000000000');
$('input[name="telefoneContato"]').mask('(00) 0 0000-0000'); 
$('input[name="rgCliente"]').mask('000000000000000'); 

//RESTRINGINDO OS VALORES DOS INPUTS
(function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  };
}(jQuery));


// INPUT FILTERS PADRÕES BASE
$("#intTextBox").inputFilter(function(value) {
  return /^-?\d*$/.test(value); });
$("#uintTextBox").inputFilter(function(value) {
  return /^\d*$/.test(value); });
$("#intLimitTextBox").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
$("#floatTextBox").inputFilter(function(value) {
  return /^-?\d*[.]?\d*$/.test(value); });
$("#currencyTextBox").inputFilter(function(value) {
  return /^-?\d*[.]?\d{0,2}$/.test(value); });
$("#latinTextBox").inputFilter(function(value) {
  return /^[a-z à-ù á-ú]*$/i.test(value); });
$("#hexTextBox").inputFilter(function(value) {
  return /^[0-9a-f]*$/i.test(value); });

    //TEXT
    $("#nomeCliente").inputFilter(function(value) {
      return /^[A-Z À-Ù Á-Ú ]*$/i.test(value); });
    $("#nomeContato").inputFilter(function(value) {
      return /^[A-Z À-Ù Á-Ú]*$/i.test(value); });
    $("#nomePasseio").inputFilter(function(value) {
      return /^[A-Z À-Ù Á-Ú]*$/i.test(value); });
    $("#LocalPasseiolatinTextBox").inputFilter(function(value) {
      return /^[a-z à-ù á-ú]*$/i.test(value); });
    //CURRENCY
    $("#valorIngresso").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorOnibus").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorIngresso").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorMicro").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorVan").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorEscuna").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorSeguroViagem").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorAlmocoCliente").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorAlmocoMotorista").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorEstacionamento").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorGuia").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorAutorizacaoTransporte").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorTaxi").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorMarketing").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorKitLanche").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorImpulsionamento").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#outros").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorVendido").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorPago").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorPendenteCliente").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#taxaPagamento").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorPasseio").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#novoValorPago").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    
  //INT
  $("#quantidadeIngresso").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeOnibus").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeMicro").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeVan").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeEscuna").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeAlmocoCliente").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeAlmocoMotorista").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeEstacionamento").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeGuia").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeAutorizacaoTransporte").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeTaxi").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeMarketing").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeKitLanche").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeImpulsionamento").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });


//CALCULANDO DATA DE NASCIMENTO
function ageCount(dataNasc) {
  split = dataNasc.split('-'); // ou use '/'
                var ano_aniversario = split[0] ;
                var mes_aniversario = split[1] ;
                var dia_aniversario = split[2] ;
                var dataAtual = new Date ;
                ano_atual = dataAtual.getFullYear() ;
                mes_atual = dataAtual.getMonth() + 1 ;
                dia_atual = dataAtual.getDate() ;

                quantos_anos = ano_atual - ano_aniversario;

                if (mes_atual < mes_aniversario || mes_atual == mes_aniversario && dia_atual < dia_aniversario) {
                    quantos_anos--;
                }
                document.getElementById('idadeCliente').value = quantos_anos;
}

//CALCULO DESPESAS PASSEIO
function calculoTotalDespesas(){
    var valorIngresso                                        = document.getElementById('valorIngresso').value;
    valorIngresso                                            = parseFloat(valorIngresso);
    document.getElementById('valorIngresso').value           = valorIngresso.toFixed(2);
    var quantidadeIngresso                                   = document.getElementById('quantidadeIngresso').value;
    valorTotalIngresso                                       = quantidadeIngresso * valorIngresso;
    document.getElementById('valorTotalIngresso').value      = valorTotalIngresso.toFixed(2);


    var valorOnibus                                          = document.getElementById('valorOnibus').value;
    valorOnibus                                              = parseFloat(valorOnibus);
    document.getElementById('valorOnibus').value             = valorOnibus.toFixed(2);
    var quantidadeOnibus                                     = document.getElementById('quantidadeOnibus').value;
    valorTotalOnibus                                         = quantidadeOnibus * valorOnibus;
    document.getElementById('valorTotalOnibus').value        = valorTotalOnibus.toFixed(2);


    var valorMicro                                           = document.getElementById('valorMicro').value;
    valorMicro                                               = parseFloat(valorMicro);
    document.getElementById('valorMicro').value              = valorMicro.toFixed(2);
    var quantidadeMicro                                      = document.getElementById('quantidadeMicro').value;
    valorTotalMicro                                          = quantidadeMicro * valorMicro;
    document.getElementById('valorTotalMicro').value         = valorTotalMicro.toFixed(2);
    


    var valorVan                                             = document.getElementById('valorVan').value;
    valorVan                                                 = parseFloat(valorVan);
    document.getElementById('valorVan').value                = valorVan.toFixed(2);
    var quantidadeVan                                        = document.getElementById('quantidadeVan').value;
    valorTotalVan                                            = quantidadeVan * valorVan;
    document.getElementById('valorTotalVan').value           = valorTotalVan.toFixed(2);
    

    var valorEscuna                                          = document.getElementById('valorEscuna').value;
    valorEscuna                                              = parseFloat(valorEscuna);
    document.getElementById('valorEscuna').value             = valorEscuna.toFixed(2);
    var quantidadeEscuna                                     = document.getElementById('quantidadeEscuna').value;
    valorTotalEscuna                                         = quantidadeEscuna * valorEscuna;
    document.getElementById('valorTotalEscuna').value        = valorTotalEscuna.toFixed(2);
    

    var valorAlmocoCliente                                   = document.getElementById('valorAlmocoCliente').value;
    valorAlmocoCliente                                       = parseFloat(valorAlmocoCliente);
    document.getElementById('valorAlmocoCliente').value      = valorAlmocoCliente.toFixed(2);
    var quantidadeAlmocoCliente                              = document.getElementById('quantidadeAlmocoCliente').value;
    valorTotalAlmocoCliente                                  = quantidadeAlmocoCliente * valorAlmocoCliente;
    document.getElementById('valorTotalAlmocoCliente').value = valorTotalAlmocoCliente.toFixed(2);
    

    var valorAlmocoMotorista                                 = document.getElementById('valorAlmocoMotorista').value;
    valorAlmocoMotorista                                     = parseFloat(valorAlmocoMotorista);
    document.getElementById('valorAlmocoMotorista').value    = valorAlmocoMotorista.toFixed(2);
    var quantidadeAlmocoMotorista                            = document.getElementById('quantidadeAlmocoMotorista').value;
    valorTotalAlmocoMotorista                                = quantidadeAlmocoMotorista * valorAlmocoMotorista;
    document.getElementById('valorTotalAlmocoMotorista').value = valorTotalAlmocoMotorista.toFixed(2);

    
    var valorEstacionamento                                  = document.getElementById('valorEstacionamento').value;
    valorEstacionamento                                      = parseFloat(valorEstacionamento);
    document.getElementById('valorEstacionamento').value     = valorEstacionamento.toFixed(2);
    var quantidadeEstacionamento                             = document.getElementById('quantidadeEstacionamento').value;
    valorTotalEstacionamento                                 = quantidadeEstacionamento * valorEstacionamento;
    document.getElementById('valorTotalEstacionamento').value= valorTotalEstacionamento.toFixed(2);


    var valorGuia                                            = document.getElementById('valorGuia').value;
    valorGuia                                                = parseFloat(valorGuia);
    document.getElementById('valorGuia').value               = valorGuia.toFixed(2);
    var quantidadeGuia                                       = document.getElementById('quantidadeGuia').value;
    valorTotalGuia                                           = quantidadeGuia * valorGuia;
    document.getElementById('valorTotalGuia').value          = valorTotalGuia.toFixed(2);
    

    var valorAutorizacaoTransporte                           = document.getElementById('valorAutorizacaoTransporte').value;
    valorAutorizacaoTransporte                               = parseFloat(valorAutorizacaoTransporte);
    document.getElementById('valorAutorizacaoTransporte').value             = valorAutorizacaoTransporte.toFixed(2);
    var quantidadeAutorizacaoTransporte                      = document.getElementById('quantidadeAutorizacaoTransporte').value;
    valorTotalTransporte                                     = quantidadeAutorizacaoTransporte * valorAutorizacaoTransporte;
    document.getElementById('valorTotalTransporte').value    = valorTotalTransporte.toFixed(2);
    

    var valorTaxi                                            = document.getElementById('valorTaxi').value;
    valorTaxi                                                = parseFloat(valorTaxi);
    document.getElementById('valorTaxi').value               = valorTaxi.toFixed(2);
    var quantidadeTaxi                                       = document.getElementById('quantidadeTaxi').value;
    valorTotalTaxi                                           = quantidadeTaxi * valorTaxi;
    document.getElementById('valorTotalTaxi').value          = valorTotalTaxi.toFixed(2);
    

    var valorMarketing                                       = document.getElementById('valorMarketing').value;
    valorMarketing                                           = parseFloat(valorMarketing);
    document.getElementById('valorMarketing').value          = valorMarketing.toFixed(2);
    var quantidadeMarketing                                  = document.getElementById('quantidadeMarketing').value;
    valorTotalMarketing                                      = quantidadeMarketing * valorMarketing;
    document.getElementById('valorTotalMarketing').value     = valorTotalMarketing.toFixed(2);
    

    var valorKitLanche                                       = document.getElementById('valorKitLanche').value;
    valorKitLanche                                           = parseFloat(valorKitLanche);
    document.getElementById('valorKitLanche').value          = valorKitLanche.toFixed(2);
    var quantidadeKitLanche                                  = document.getElementById('quantidadeKitLanche').value;
    valorTotalKitLanche                                      = quantidadeKitLanche * valorKitLanche;
    document.getElementById('valorTotalKitLanche').value     = valorTotalKitLanche.toFixed(2);

    
    var valorImpulsionamento                                 = document.getElementById('valorImpulsionamento').value;
    valorImpulsionamento                                     = parseFloat(valorImpulsionamento);
    document.getElementById('valorImpulsionamento').value    = valorImpulsionamento.toFixed(2);
    var quantidadeImpulsionamento                            = document.getElementById('quantidadeImpulsionamento').value;    
    valorTotalImpulsionamento                                = quantidadeImpulsionamento * valorImpulsionamento;
    document.getElementById('valorTotalImpulsionamento').value = valorTotalImpulsionamento.toFixed(2);

    var valorSeguroViagem                                    = document.getElementById('valorSeguroViagem').value;
    valorSeguroViagem                                        = parseFloat(valorSeguroViagem);
    document.getElementById('valorSeguroViagem').value       = valorSeguroViagem.toFixed(2);
    var quantidadeSeguroViagem                               = document.getElementById('quantidadeSeguroViagem').value;
    valorTotalSeguroViagem                                   = quantidadeSeguroViagem * valorSeguroViagem;
    document.getElementById('valorTotalSeguroViagem').value  = valorTotalSeguroViagem.toFixed(2);


    var outros                                               = document.getElementById('outros').value;
    outros                                     = parseFloat(outros);
    document.getElementById('outros').value    = outros.toFixed(2); 


    
    var valorTotal                  = Number(valorIngresso) * Number(quantidadeIngresso)  + Number(valorOnibus) * Number(quantidadeOnibus) + Number(valorMicro) * Number(quantidadeMicro) + Number(valorVan) * Number(quantidadeVan) + Number(valorEscuna) * Number(quantidadeEscuna) + Number(valorSeguroViagem) * Number(quantidadeSeguroViagem)
                                    + Number(valorAlmocoCliente) * Number(quantidadeAlmocoCliente) + Number(valorAlmocoMotorista) * Number(quantidadeAlmocoMotorista) + Number(valorEstacionamento) * Number(quantidadeEstacionamento) + Number(valorGuia) * Number(quantidadeGuia) 
                                    + Number(valorAutorizacaoTransporte) * Number(quantidadeAutorizacaoTransporte) + Number(valorTaxi) * Number(quantidadeTaxi) + Number(valorMarketing) * Number(quantidadeMarketing)  + Number(valorImpulsionamento) * Number(quantidadeImpulsionamento) 
                                    + Number(outros)  + Number(valorKitLanche) * Number(quantidadeKitLanche);
   console.log(valorTotal);
   if(valorTotal) {
       document.getElementById('totalDespesas').value = valorTotal.toFixed(2);
   }else{   
        document.getElementById('totalDespesas').value = 0; 
    }
}

//CALCULO PAGAMENTO CLIENTE
function calculoPagamentoCliente(){
  
    var valorVendido                                   = document.getElementById('valorVendido').value;
    valorVendido                                       = parseFloat(valorVendido); 
    document.getElementById('valorVendido').value      = valorVendido.toFixed(2);

    

    var valorPago                                      = document.getElementById('valorPago').value;
    valorPago                                          = parseFloat(valorPago); 
    document.getElementById('valorPago').value         = valorPago.toFixed(2);

 
    

    this.novoValorPago = function (){
      var valorAntigo = document.getElementById('valorAntigo').value;
      valorAntigo = parseFloat(valorAntigo);
      var novoValor = document.getElementById('novoValorPago').value;
      novoValor = parseFloat(novoValor);
      document.getElementById('novoValorPago').value = novoValor.toFixed(2);
      var novoValorPago = Number(valorPago.toFixed(2)) + Number(novoValor.toFixed(2));

      var historicoPagamentoAntigo = document.getElementById('historicoPagamentoAntigo').value;
     
      if(novoValor == 0){
        document.getElementById('valorPago').value = valorAntigo;
        document.getElementById('historicoPagamento').innerHTML = historicoPagamentoAntigo;

      }else{
        var now = new Date();                           
        var currentY= now.getFullYear();                
        var currentM= now.getMonth();                   
        var currentD= now.getDate();
        //console.log(now);
        document.getElementById('valorPago').value = novoValorPago;
        document.getElementById('historicoPagamento').innerHTML = historicoPagamentoAntigo + "\n " + currentD + "-" + (currentM+1) + "-" + currentY+ " R$: " + novoValor.toFixed(2);
      }
      //console.log(novoValorPago);
    }
    var taxaPagamento                                  = document.getElementById('taxaPagamento').value;
    taxaPagamento                                      = parseFloat(taxaPagamento);
    document.getElementById('taxaPagamento').value     = taxaPagamento.toFixed(2);
    
    var valorPendenteCliente                           = Number(valorPago.toFixed(2)) + Number(taxaPagamento.toFixed(2)) - Number(valorVendido.toFixed(2));
    valorPendenteClienteArredondado                   = parseFloat(valorPendenteCliente.toFixed(2)); 
    document.getElementById('valorPendenteCliente').value= valorPendenteClienteArredondado;
    
    var clienteParceiro = document.querySelector('input[name="clienteParceiro"]:checked').value;
;
    console.log(clienteParceiro);
    if(clienteParceiro == 1){
      document.getElementById('statusPagamento').value = 3;
      console.log(3);
    }else{
      if(valorPendenteCliente < 0 && valorPago == 0){
          document.getElementById('valorPendenteCliente').value =  valorPendenteCliente.toFixed(2);
          console.log("NÃO PAGO");
          document.getElementById('statusPagamento').value = 0;  //NÃO PAGO
      }else if(valorPendenteCliente == 0){
          document.getElementById('statusPagamento').value = 1; //PAGO
          document.getElementById('valorPendenteCliente').value =  valorPendenteCliente.toFixed(2);
      }else if(valorPendenteCliente < 0 && valorPago > 0){
        document.getElementById('statusPagamento').value = 2; //INTERESSADO
        console.log("interessado");
          //document.getElementById('valorPendenteCliente').value = "INTERESSADO";
      }else{
        document.getElementById('valorPendenteCliente').value = "VALOR INCORRETO";
      }
      //console.log(Number( valorPendenteCliente.toFixed(2)));
    }

}

    
//DEFININDO PASSEIO DO SELECT
function idPasseioSelecionadoFun(){
    var idPasseioSelecionado = document.getElementById('selectIdPasseio').value;  
    console.log(idPasseioSelecionado);

    document.getElementById('idPasseioSelecionado').value = idPasseioSelecionado;
    
}


//DEFININDO DATA ATUAL DEFAULT NO CAMPO dataConsulta
function setInputDate(_id){
    var _dat = document.querySelector(_id);
    var hoy = new Date(),
        d = hoy.getDate(),
        m = hoy.getMonth()+1, 
        y = hoy.getFullYear(),
        data;

    if(d < 10){
        d = "0"+d;
    };
    if(m < 10){
        m = "0"+m;
    };

    data = y+"-"+m+"-"+d;
    console.log(data);
    _dat.value = data;
};

//CONDIÇÕES DO RADIO
function changeInputDate(){
    var radio = document.getElementsByName('cpfConsultado');

    for (var i = 0, length = radio.length; i < length; i++){
        if (radio[0].checked){
            setInputDate("#dataCpfConsultado");
            break;
        }
        else{
            document.getElementById('dataCpfConsultado').value = "mm/dd/yyyy";
            break;
        }
    } 
}


//TRASNFORMANDO TEXT EM UPPERCASE
function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}

//VERIFICAÇÃO DE DATA DO PASSEIO
function verificaDataPasseio(){
  anoPasseio = document.getElementById('dataPasseio').value;
  if(anoPasseio < "2017-01-01"){
    document.getElementById('dataPasseio').value = "yyyy-MM-dd" ;
    var idadeConfirm = confirm("DATA INVÁLIDA");
  }
  
  console.log(anoPasseio);
}



function confirmationDelete(anchor)
{
   var conf = confirm('VOCÊ TEM CERTEZA QUE DESEJA DESATIVAR ESTE CLIENTE??');
   if(conf)
      window.location=anchor.attr("href");
}

//VERIFICANDO CLIQUE NA SELEÇÃO DE PÁGINA ------------------------------------------------------
function cliquePrimeirPagina(){
  var checarPrimeiraPagina = document.getElementById('clickPaginaPrimeira')
    checarPrimeiraPagina.onclick = function (){
      if(checarPrimeiraPagina.onclick){
        var status = 1;
        var paginaPrimeira = document.getElementById('paginaPrimeira').value;
        document.getElementById('paginaSelecionada').value = paginaPrimeira;
        window.location.href = 'pesquisarCliente.php?pagina='+document.getElementById('paginaPrimeira').value;

      }else{
        var status = 0;

      }
      return status;
    };
    if(clickPaginaPrimeira.onclick() == 1){

      
    }else{
      
    }
  
}

function cliquePaginaAnterior(){
  var checarPaginaAnterior = document.getElementById('clickPaginaAnterior')
  checarPaginaAnterior.onclick = function (){
      if(checarPaginaAnterior.onclick){
        var status = 1;
        var paginaAnterior = document.getElementById('paginaAnterior').value;
        if(isNaN(paginaAnterior)){
            console.log("NaN")
        }else{
          window.location.href = 'pesquisarCliente.php?pagina='+document.getElementById('paginaAnterior').value;

        }
      }else{
        var status = 0;

      }
      return status;
    };

  
}

function cliquePaginaDepois(){
  var checarPaginaDepois = document.getElementById('clickPaginaDepois')
  checarPaginaDepois.onclick = function (){
      if(checarPaginaDepois.onclick){
        var status = 1;
        var paginaDepois = document.getElementById('paginaDepois').value;
        document.getElementById('paginaSelecionada').value = paginaDepois;
        window.location.href = 'pesquisarCliente.php?pagina='+document.getElementById('paginaDepois').value;


      }else{
        var status = 0;

      }
      return status;
    };
    if(checarPaginaDepois.onclick() == 1){
      console.log("PÁGINA DEPOIS");
    }else{
      
    }
  
}
function cliquePaginaUltima(){
  var checarPaginaUltima = document.getElementById('clickPaginaUltima')
  checarPaginaUltima.onclick = function (){
      if(checarPaginaUltima.onclick){
        var status = 1;
        var paginaUltima = document.getElementById('paginaUltima').value;
        document.getElementById('paginaSelecionada').value = paginaUltima;
        window.location.href = 'pesquisarCliente.php?pagina='+document.getElementById('paginaUltima').value;
      }else{
        var status = 0;

      }
      return status;
    };
    if(checarPaginaUltima.onclick() == 1){
      console.log("PÁGINA ÚLTIMA");
    }else{
      
    }
  
}

//CONVERTENDO VALOR PARA FLOAT

function converterParaFloat(){

  var valorPasseio                           = document.getElementById('valorPasseio').value;
  valorPasseio                               = parseFloat(valorPasseio);
  document.getElementById('valorPasseio').value= valorPasseio.toFixed(2);

}


function tituloListagem(){
  var clientesConfirmados = document.getElementById("clientesConfirmados").value;
  document.getElementById("confirmados").innerHTML = "CONFIRMADOS: " +clientesConfirmados;
  
  var interessados = document.getElementById("clientesInteressados").value;
  document.getElementById("interessados").innerHTML = "INTERESSADOS: " +interessados;

  var totalVagasDisponiveis = document.getElementById("totalVagasDisponiveis").value;
  document.getElementById("vagasDisponiveis").innerHTML = "DISPONÍVEIS:  " +totalVagasDisponiveis;

  var clientesParceiros = document.getElementById("clientesParceiros").value;
  document.getElementById("parceiros").innerHTML = "PARCEIROS:  " +clientesParceiros;

  var clientesCriancas = document.getElementById("clientesCriancas").value;
  document.getElementById("criancas").innerHTML = "CRIANÇAS:  " +clientesCriancas;
  

}

function Export() {
  var conf = confirm("Exportar para EXCEL?");
  if(conf == true){
    var idPasseio = document.getElementById('idPasseio').value;
    console.log("ok");
    window.open("SCRIPTS/exportarExcel.php?id="+ idPasseio, '_blank');
  }
}

function verificaDePrevisaoPagamento(){
  var previsaoPagamento = document.getElementById("previsaoPagamento").value;
  //console.log(previsaoPagamento);
  var data = new Date();
  var mes = data.getMonth() +1;
  var dia = data.getDate();
  var ano = data.getFullYear();
  if(mes < 10){
    mes = "0" + mes;
  }
  var dataCompleta = ano + "-" + mes + "-" + dia;
  if(dataCompleta == previsaoPagamento){
    alert("HOJE É O DIA DO PAGAMENTO");
  }
  //console.log(dataCompleta);

  
  
}
function verificaDataDePrevisaoPagamento(){
  var previsaoPagamento = document.getElementById("previsaoPagamento").value;
  //console.log(previsaoPagamento);
  var data = new Date();
  var mes = data.getMonth() +1;
  var dia = data.getDate();
  var ano = data.getFullYear();
  if(mes < 10){
    mes = "0" + mes;
  }
  var dataCompleta = ano + "-" + mes + "-" + dia;
  if(previsaoPagamento < dataCompleta){
    alert("DATA DE PAGAMENTO INVÁLIDA");

  }
  //console.log(dataCompleta);

  
  
}


