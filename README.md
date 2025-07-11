# Gestão de Aluno

Este projeto é um sistema de gestão desenvolvido para administrar informações de alunos, incluindo seus cursos e endereços. O sistema permite cadastrar, visualizar, atualizar e excluir dados de alunos, além de gerenciar os cursos que estão matriculados e seus respectivos endereços.


## Funcionalidades

- **Cadastro de Alunos**: Adicionar novos alunos ao sistema com informações como nome, CPF, data de nascimento, email/numero para contato, etc.
- **Gestão de Cursos**: Associar cursos aos alunos.
- **Endereço dos Alunos**: Cadastrar e gerenciar endereços dos alunos.
- **Consulta e Relatórios**: Visualizar listas de alunos, cursos e endereços.


## Módulos

Alunos

    GET /alunos → Listar todos os alunos

    GET /alunos/{id} → Buscar um aluno específico

    POST /alunos → Cadastrar um novo aluno

    PUT /alunos/{id} → Atualizar informações de um aluno

    DELETE /alunos/{id} → Remover aluno do sistema

Cursos

    GET /curso → Listar todos os cursos disponíveis

    GET /curso/{id} → Buscar curso por ID

    POST /curso → Cadastrar novo curso

    PUT /curso/{id} → Editar informações de um curso

Endereços

    GET /endereco → Listar todos os endereços

    GET /endereco/{id} → Ver detalhes de um endereço

    PUT /endereco/{id} → Atualizar informações de endereço
