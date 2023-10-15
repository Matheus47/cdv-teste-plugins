<?php

/**
 * Plugin Name:     Registrador de Clique
 * Plugin URI:      http://meusite.com
 * Description:     Registra a data e hora do clique
 * Author:          Matheus Rodrigues
 * Author URI:      http://meusite.com
 * Text Domain:     cdv-button
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         cdv-button
 */

defined(constant_name: 'ABSPATH') || exit;

// Função para rastreamento de clique por shortcode
function registrar_clique()
{
    global $wpdb;

    //Recupera a url retornada pelo AJAX
    $urlAtual = isset($_POST['urlAtual']) ? $_POST['urlAtual'] : '';

    // Tabela onde os registros serão inseridos
    $tabela = $wpdb->prefix . 'registros_cliques';

    // Verifica se a tabela existe no banco de dados
    if ($wpdb->get_var("SHOW TABLES LIKE '$tabela'") != $tabela) {
        // Se a tabela não existir, faz a criação
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $tabela (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            data_hora datetime NOT NULL,
            url varchar(255) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    // Atribui os dados em seus respectivos campos
    $dados = array(
        'data_hora' => current_time('mysql'),
        'url' => $urlAtual
    );

    // Formatação
    $formato = array(
        '%s',
        '%s'
    );

    // Inserir os dados na tabela
    $wpdb->insert($tabela, $dados, $formato);
}

// Função para criar o shortcode
function botao_shortcode()
{
    ob_start();
?>

    <!-- Conteúdo do shortcode -->
    <button id="registrar-clique" class="button">Clique aqui</button>
    <script>
        // Adicione um evento ao clicar
        document.getElementById('registrar-clique').addEventListener('click', function() {
            //Obtem url do navegador
            var urlAtual = window.location.href;
            // AJAX para chamar a função 'registrar_clique"
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'registrar_clique',
                    urlAtual: urlAtual // Retorna a url atual
                },
                success: function(response) {
                    alert('Seu clique foi registrado no banco de dados!');
                }
            });
        });
    </script>
<?php

    return ob_get_clean();
}

// Registra o nome do shortcode para uso
//        Nome do shortcode   Nome da função
add_shortcode('cdv_button', 'botao_shortcode');

add_action('wp_ajax_registrar_clique', 'registrar_clique'); // Ação para usuários autenticados
add_action('wp_ajax_nopriv_registrar_clique', 'registrar_clique'); // Ação para usuários não autenticados