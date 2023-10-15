# cdv-teste-plugins
Criação de plugins wordpress para registrar clique em botão e apresentar resultados via WP-CLI

## Plugin retorna-lista

== Descrição ==

Retorna os 20 ultimos registros criados pelo plugin cdv-cdv_button via wp-cli

== Execução ==

Instalar o plugin no wordpress atráves do upload do arquivo
-- ZIPAR a pasta retorna-lista antes de fazer o upload.

Basta ativar o plugin e usar o comando "wp retorna-lista exibir" no terminal 

## Plugin cdv-button

== Descrição ==

O plugin tem o intuito de registrar a data, hora e URL atual no banco local, na tabela registros_cliques ao clicar no botão.

== Instalação ==

Instalar o plugin no wordpress atráves do upload do arquivo
-- ZIPAR a pasta cdv-button antes de fazer o upload.

Ative o plugin e depois basta inserir o shortcode no local desejado do site.
Shortcode => [cdv_button]
