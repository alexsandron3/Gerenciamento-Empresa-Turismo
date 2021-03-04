# GERENCIAMENTO DE EMPRESA DE TURISMO
Entre em contato para mais informações detalhadas sobre o sistema.
alexsandro060299@outlook.com

##Prévia do sistema
  http://alexsandroxavier.sytes.net/novosistema/login.php
  ### CLIQUE NO LINK "REGISTRE-SE AGORA" E EM SEGUIDA LOGUE NO SISTEMA

## BREVE RESUMO:
  #### Este sistema foi projetado e está sendo desenvolido para uma agência de turismos. Foi entendido que os processos deles eram feitos INTEIRAMENTE por EXCEL, o que não era prático, poderia causar redundâncias e até informações erradas.
  ### ETAPA 0
  #### O sistema veio com a intenção de agilizar os processos dessa empresa. Foram feitas análises nos PDFs usados por eles e então criadas as funcionalidades.
  ### ETAPA 1
       A primeira a etapa foi criar/automatizar o que eles já tinham, então foi criado um sistema de gerenciamento de USUÁRIOS e PAGAMENTOS, EVENTOS e suas DESPESAS.
  ###  ETAPA 2
       Após isso foram criados sistemas de controle. Por exemplo não é possível cadastrar um USUÁRIO com mesmo NOME  e CPF, assim como não é possível cadastrar um EVENTO com mesmo NOME e DATA DE REALIZAÇÃO. 
       Você pode conferir todos os ALERTAS na opção ALERTAS . 
  ### ETAPA 3
      Na etapa 3 foi iniciada a criação de relatórios. Então foi criada uma parte de relatórios financeiros, e outra parte de relatórios como  PONTOS DE EMBARQUE, LISTA DE PASSAGEIROS, PAGAMENTOS PENDENTES e SEGURO VIAGEM, sendo possível exportar todos esses para EXCEL.
  ### ETAPA 4
    Já na etapa 4 foi criada a parte de LOG do sistema, onde apenas usuários a partir de um NÍVEL DE ACESSO poderiam acessar essa parte, o log mostra todas operações feitas no sistema, sejam elas sucedidas ou não, detalhando também as informações da operação. Juntamente foram criados os níveis de acesso, onde existem usuários com poder de alteração e visualização completa, usuários com poder de alteração completa e usuários somente com poder de visualização, sem poder acessar ou alterar qualquer informação cadastrada no  banco de dados.
  
  #### Mais funcionalidades serão adicionadas como você poderá ver com detalhes em Funcionalidades Previstas 
  #### As Funcionalidades já prontas, você poderá ver com detalhes em Funcionalidades Principais 
  #### Os erros conhecidos e não corrigidos poderão ser vistos em Bugs 


## FUNCIONALIDADES PRINCIPAIS
  * ## OPERAÇÕES BÁSICAS 
- [X] CADASTRAR, PESQUISAR, EDITAR E DESATIVAR USUÁRIOS 
- [X] CADASTRAR, PESQUISAR, EDITAR, ENCERRAR/ATIVAR E DELETAR*  EVENTOS  
- [X] CADASTRAR, PESQUISAR E EDITAR DESPESAS 
- [X] CADASTRAR, PESQUISAR, EDITAR, TRANSFERIR E APAGAR PAGAMENTOS
- [X] RELATÓRIOS FINANCEIROS, PONTOS DE EMBARQUE, SEGURO VIAGEM E LISTA DE PASSAGEIROS 
- [X] EXPORTAR RELATÓRIOS PARA EXCEL 

## FUNCIONALIDADES PREVISTAS
- [X] CRIAÇÃO DE PÁGINA INTERATIVA PARA ORGANIZAR CLIENTES E SUAS POLTRONAS NOS MEIOS DE TRANSPORTE
- [X] AVISO DE PAGAMENTOS PENDENTES AO ENTRAR NO SISTEMA
- [X] OPÇÃO DE DESISTÊNCIA PARA USUÁRIO QUE JÁ REALIZOU PAGAMENTO E FOI INSERIDO À UM EVENTO
- [X] ORGANIZAR PONTO DE EMBARQUE POR GRUPOS

## ALERTAS
- [X] ALERTA APÓS QUALQUER OPERAÇÃO RETORNANDO SE ESTA FOI SUCEDIDA OU NÃO
- [X] ALERTA DE VAGAS RESTANTES TODA VEZ QUE UM USUÁRIO É INCLUÍDO À UM EVENTO

## CONTROLE
  * ### USUÁRIO
    - [X] NÃO PODE EXISITIR UM USUÁRIO COM MESMO NOME E CPF SENDO REDIRECIONADO PARA O USUÁRIO QUE JÁ EXISTE INVÉS DE CRIAR UM NOVO
  * ### EVENTO
    - [X] NÃO PODE EXISTIR UM EVENTO COM MESMO NOME E DATA DE REALIZAÇÃO SENDO REDIRECIONADO PARA O EVENTO QUE JÁ EXISTE INVÉS DE CRIAR UM NOVO
    - [X] IMPOSSÍVEL DE CADASTRAR NOVOS PAGAMENTOS QUANDO A QUANTIDADE DE VAGAS ESTIPULADAS NO CADASTRO DO EVENTO FOR ATINGIDA
  * ### DESPESA
    - [X] NÃO PODERÁ EXISTIR MAIS DE 1 BLOCO DE DESPESAS PARA UM EVENTO SENDO REDIRECIONADO PARA A DESPESA QUE JÁ EXISTE INVÉS DE CRIAR UMA NOVA
  * ### PAGAMENTO
    - [X] UM CLIENTE NÃO PODERÁ FAZER MAIS DE UM PAGAMENTO A UM EVENTO, SENDO REDIRECIONADO PARA O PAGAMENTO QUE JÁ EXISTE INVÉS DE CRIAR UM NOVO
  * ### LOG
    - [X] É GERADA UM REGISTRO DE TODAS AÇÕES FEITAS DENTRO DO SISTEMA, INFORMANDO O HORÁRIO DA REALIZAÇÃO DA AÇÃO, QUAL AÇÃO FOI FEITA E ONDE FOI FEITA (ATUALIZAÇÃO DE EVENTOS, TRASFERÊNCIA DE PAGAMENTOS, ETC)
  * ### NÍVEL DE ACESSO 
    - [X] EXISTEM NÍVEIS DE ACESSO QUE RESTRINGEM COMO UM USUÁRIO PODERÁ INTERAGIR COM O SISTEMA
      USUÁRIOS COM NÍVEL DE ACESSO 0 TEM ACESSO COMPLETO AO SISTEMA E AO LOG DO SISTEMA
      USUÁRIOS COM NIVEL DE ACESSO 1 TEM ACESSO A TODAS OPERAÇÕES COM EXCEÇÃO DOS LOGS
      USUÁRIOS COM NÍVEL DE ACESSO 2 TEM ACESSO APENAS A OPERAÇÕES DE VISUALIZAÇÃO DO SISTEMA, NÃO PODENDO REALIZAR ALTERAÇÕES NEM INCLUSÕES

## BUGS CONHECIDOS 
 
    
Criado por Alexsandro Xavier | Frontend e Backend
Outras funcionalidades serão e foram adicionadas.
Código para livre uso de qualquer pessoa
