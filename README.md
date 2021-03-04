# GERENCIAMENTO DE EMPRESA DE TURISMO
Entre em contato para solicitar um teste.
alexsandro060299@outlook.com


## BREVE RESUMO:
  #### Este sistema foi projetado e está sendo desenvolido para uma agência de turismos. Foi entendido que os processos deles eram feitos INTEIRAMENTE por EXCEL, o que não era prático, poderia causar redundâncias e até informações erradas.
  ### ETAPA 0
  #### O sistema veio com a intenção de agilizar os processos dessa empresa. Foram feitas análises nos PDFs usados por eles e então criadas as funcionalidades.
  ### ETAPA 1
       A primeira a etapa foi criar/automatizar o que eles já tinham, então foi criado um sistema de gerenciamento de USUÁRIOS e PAGAMENTOS, PASSEIOS e suas DESPESAS.
  ###  ETAPA 2
       Após isso foram criados sistemas de controle. Por exemplo não é possível cadastrar um cliente com mesmo NOME  e CPF, assim como não é possível cadastrar um passeio com mesmo NOME e DATA DE REALIZAÇÃO. 
       Você pode conferir todos os ALERTAS na opção ALERTAS . 
  ### ETAPA 3
      Na etapa 3 foi iniciada a criação de relatórios. Então foi criada uma parte de relatórios financeiros, e outra parte de relatórios como  PONTOS DE EMBARQUE, LISTA DE PASSAGEIROS, PAGAMENTOS PENDENTES e SEGURO VIAGEM, sendo possível exportar todos esses para EXCEL.
  ### ETAPA 4
    Já na etapa 4 foi criada a parte de LOG do sistema, onde apenas usuários a partir de um NÍVEL DE ACESSO poderiam acessar essa parte, o log mostra todas operações feitas no sistema, sejam elas sucedidas ou não, detalhando também as informações da operação. Juntamente foram criados os níveis de acesso, onde existem usuários com poder de alteração e visualização completa, usuários com poder de alteração completa e usuários somente com poder de visualização, sem poder acessar ou alterar qualquer informação cadastrada no  banco de dados.
  
  #### Mais funcionalidades serão adicionadas como você poderá ver com detalhes em <a href="funcionalidadesPrevistas"> Funcionalidades Previstas <a>
  #### As Funcionalidades já prontas, você poderá ver com detalhes em <a href="funcionalidadesPrincipais"> Funcionalidades Principais </a>
  #### Os erros conhecidos e não corrigidos poderão ser vistos em <a href="bugs"> Bugs </a>









## FUNCIONALIDADES PRINCIPAIS
  * ## OPERAÇÕES BÁSICAS 
- [X] CADASTRAR, PESQUISAR, EDITAR E DESATIVAR CLIENTES 
- [X] CADASTRAR, PESQUISAR, EDITAR E <a href="#TIP1"> DELETAR* </a> PASSEIOS  
- [X] CADASTRAR, PESQUISAR E EDITAR DESPESAS 
- [X] CADASTRAR, PESQUISAR, EDITAR, TRANSFERIR E APAGAR PAGAMENTOS <p> 
- [X] CRIAR LISTA DE PASSEIO 
- [X] EXPORTAR SEGURO VIAGEM COMO EXCEL 


## FUNCIONALIDADES SECUNDÁRIAS

## BUGS CONHECIDOS <p id="TIP1" > </p>
 
##  V1.0 | 10.02.2021 <p id="010"> </p>
 * ### CADASTRAR
   * #### CLIENTE
     * VOCÊ PODE CADASTRAR UM CLIENTE
   * #### PASSEIO
     * IMPOSSÍVEL DE REGISTRAR DOIS PASSEIOS COM MESMO NOME E DATA
   * #### DESPESAS DO PASSEIO
     * É PRECISO TER UM PASSEIO REGISTRADO PARA QUE VOCÊ CONSIGA REGISTRAR AS DESPESAS
     * SOMA DOS CAMPOS FEITA AUTOMATICAMENTE
     * CASO JÁ EXISTAM DESPESAS CADASTRADAS PARA O TAL PASSEIO, VOCÊ SERÁ REDIRECIONADO PARA A PÁGINA DE EDIÇÃO DE DESPESAS
   * #### PAGAMENTO DO CLIENTE
     * PARA CADASTRAR UM PAGAMENTO VÁ PARA ÁREA DE PESQUISAS E CLIQUE EM "PAGAR" NO CLIENTE QUE PREFERIR
       * É PRECISO TER UM PASSEIO REGISTRADO PARA QUE VOCÊ CONSIGA EFETUAR UM PAGAMENTO
       * SOMA DOS CAMPOS FEITA AUTOMATICAMENTE
       * VOCÊ SERÁ REDIRECIONADO PARA PÁGINA DE ATUALIZAÇÃO DE PAGAMENTO CASO JÁ EXISTA UM PAGAMENTO DO CLIENTE PARA O PASSEIO SELECIONADO

 * ### EDITAR INFORMAÇÕES
   * #### CLIENTE
     * PARA EDITAR UM CLIENTE VÁ PARA ÁREA DE PESQUISAS E CLIQUE EM "EDITAR" NO CLIENTE QUE PREFERIR
   * #### PASSEIO
     * PARA EDITAR UM PASSEIO VÁ PARA ÁREA DE PESQUISAS E CLIQUE EM "EDITAR" NO PASSEIO QUE PREFERIR
   * #### DEPESA
     * PARA EDITAR UMA DESPESA VÁ PARA ÁREA DE CADASTRAS DESPESAS E SELECIONE A DESPESA QUE PREFERIR, CASO JÁ EXISTA UMA DESPESA CADASTRADA PARA O PASSEIO SELECIONADO, ENTÃO VOCÊ SERÁ REDIRECIONADO  
   * #### PAGAMENTO
     * PARA EDITAR UM PAGAMENTO VÁ LISTA DE PASSAGEIROS E CLIQUE NO "STATUS" DO CLIENTE QUE PREFERIR 
     
 * ### DELETAR
   * #### CLIENTE
     * IMPOSSÍVEL DE DELETAR CLIENTES
       * PARA DESATIVAR UM CLIENTE VÁ PARA ÁREA DE PESQUISAS E CLIQUE EM "DESATIVAR" NO CLIENTE QUE PREFERIR
   * #### PASSEIO
     * IMPOSSÍVEL DELETAR UM PASSEIO CASO EXISTAM PAGAMENTOS FEITOS NELE, RESOLVA AS PENDÊNCIAS DELE ANTES DE EFUTAR A DELEÇÃO
       * PARA DELETAR UM PASSEIO VÁ PARA ÁREA DE PESQUISAS E CLIQUE EM "DELETAR" NO PASSEIO QUE PREFERIR
 * ### PESQUISAR
   * #### CLIENTE
     * VOCÊ PODE PESQUISAR UM CLIENTE POR QUALQUER PARTE DO NOME 
     * VOCÊ PODE PESQUISAR UM CLIENTE PELO CPF NO FOMATO 000.000.000-00
   * #### PASSEIO
     * VOCÊ PODE PESQUSAR UM PASSEIO POR QUALQUER PARTE DO NOME DO PASSEIO
     * VOCÊ PODE PESQUSAR UM PASSEIO PELA DATA DO PASSEIO
     * VOCÊ PODE PESQUISAR UM PASSEIO PELO LOCAL DO PASSEIO
    
Criado por Alexsandro Xavier | Frontend e Backend
Outras funcionalidades serão e foram adicionadas.
Código para livre uso de qualquer pessoa
