<?php

/**
 * Plugin Name:     Retorna Lista
 * Plugin URI:      meusite.com
 * Description:     Retorna a lista dos 20 ultimos registros criados pelo plugin cdv-buton
 * Author:          Matheus Rodrigues
 * Author URI:      Matheus Rodrigues
 * Text Domain:     retorna-lista
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Retorna_Lista
 */

defined(constant_name: 'ABSPATH') || exit;

if (defined('WP_CLI') && WP_CLI) {
    class Listar extends WP_CLI_Command
    {
        /**
         * Exibe os últimos 20 registros da tabela registros_cliques.
         */
        public function exibir()
        {
            global $wpdb;

            // Tabela onde os registros estão armazenados
            $tabela = $wpdb->prefix . 'registros_cliques';

            // Consulta para buscar os últimos 20 registros
            $resultados = $wpdb->get_results("SELECT * FROM $tabela ORDER BY id DESC LIMIT 20");

            if (empty($resultados)) {
                WP_CLI::line('Nenhum registro encontrado.');
            } else {
                foreach ($resultados as $registro) {
                    WP_CLI::line('ID: ' . $registro->id . ' || Data/Hora: ' . $registro->data_hora . ' || URL do Clique: ' . $registro->url);
                }
            }
        }
    }

    WP_CLI::add_command('retorna-lista', 'Listar');
}
