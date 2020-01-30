##################################################
AACC 3 - Atividades Acadêmico-Científico-Culturais
##################################################

******************
Guia de instalação
******************

- Clone o sistema usando GIT: git clone https://github.com/s-apps/aacc3.git
- A partir da raiz do sistema, crie o seguinte diretório com permissão de escrita: assets/img/comprovantes
- Dentro do diretório application crie um arquivo com nome .env e insira as informações abaixo:
- Obs: Não inclua os comentários //comentário
| DB_HOST='localhost' //link servidor do banco de dados
| DB_USERNAME='username' //nome do usário
| DB_PASSWORD='password' //senha usuário
| DB_DATABASE='aacc3' //nome do banco
| DB_DRIVER='mysqli' //deixe essa linha como está
| EMAIL_HOST='host' //link servidor de email
| EMAIL_PORT=587 //porta do servidor
| EMAIL_USER='usuario' //usuário 
| EMAIL_PASS='senha' //senha
- Na raiz do sistema, instale as dependências do PHP usando composer: composer update
- Edite o arquivo application/config/config.php e altere $config['base_url'] conforme o exemplo abaixo:
- $config['base_url'] = 'http://aacc3.fatecgarca.edu.br/';
- Edite o arquivo assets/js/aacc/comum.js e altere a variavel base_url conforme o exemplo abaixo:
- var base_url = "http://aacc3.fatecgarca.edu.br/";
- Dúvidas ou problemas? contato@silverio.eti.br

###################
What is CodeIgniter
###################

CodeIgniter is an Application Development Framework - a toolkit - for people
who build web sites using PHP. Its goal is to enable you to develop projects
much faster than you could if you were writing code from scratch, by providing
a rich set of libraries for commonly needed tasks, as well as a simple
interface and logical structure to access these libraries. CodeIgniter lets
you creatively focus on your project by minimizing the amount of code needed
for a given task.

*******************
Release Information
*******************

This repo contains in-development code for future releases. To download the
latest stable release please visit the `CodeIgniter Downloads
<https://codeigniter.com/download>`_ page.

**************************
Changelog and New Features
**************************

You can find a list of all changes for each release in the `user
guide change log <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/changelog.rst>`_.

*******************
Server Requirements
*******************

PHP version 5.6 or newer is recommended.

It should work on 5.3.7 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.

************
Installation
************

Please see the `installation section <https://codeigniter.com/user_guide/installation/index.html>`_
of the CodeIgniter User Guide.

*******
License
*******

Please see the `license
agreement <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/license.rst>`_.

*********
Resources
*********

-  `User Guide <https://codeigniter.com/docs>`_
-  `Language File Translations <https://github.com/bcit-ci/codeigniter3-translations>`_
-  `Community Forums <http://forum.codeigniter.com/>`_
-  `Community Wiki <https://github.com/bcit-ci/CodeIgniter/wiki>`_
-  `Community Slack Channel <https://codeigniterchat.slack.com>`_

Report security issues to our `Security Panel <mailto:security@codeigniter.com>`_
or via our `page on HackerOne <https://hackerone.com/codeigniter>`_, thank you.

***************
Acknowledgement
***************

The CodeIgniter team would like to thank EllisLab, all the
contributors to the CodeIgniter project and you, the CodeIgniter user.
