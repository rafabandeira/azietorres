/**
 * Lógica para o botão "Carregar Mais" com AJAX no WordPress.
 */
jQuery(document).ready(function($) {
    // Seleciona o botão pelo ID
    var loadMoreButton = $('#load-more-btn');

    // Adiciona o evento de clique ao botão
    loadMoreButton.on('click', function() {
        var button = $(this);
        var page = button.data('page'); // Pega a página atual do data-attribute
        var max_pages = button.data('max-pages'); // Pega o total de páginas
        var post_id = button.data('post-id'); // Pega o ID do post a ser excluído

        // Mostra um feedback visual para o usuário e desabilita o botão
        button.text('Carregando...'); 
        button.prop('disabled', true);

        // Inicia a chamada AJAX
        $.ajax({
            url: ajax_params.ajax_url, // URL fornecida pelo wp_localize_script
            type: 'post',
            data: {
                action: 'load_more_posts', // Ação definida no add_action do functions.php
                page: page,
                post_id: post_id
            },
            success: function(response) {
                if (response.trim() !== '') {
                    // Adiciona os novos posts ao container
                    $('#ajax-posts-container').append(response);
                    
                    // Atualiza o número da próxima página a ser carregada
                    button.data('page', page + 1);

                    // Reabilita o botão e restaura o texto original
                    button.text('CARREGAR MAIS');
                    button.prop('disabled', false);

                    // Se a página atual for a última, remove o botão
                    if (page + 1 > max_pages) {
                        button.remove();
                    }
                } else {
                    // Se não houver mais posts, remove o botão
                    button.remove();
                }
            },
            error: function() {
                // Em caso de erro na requisição, informa o usuário
                button.text('Ocorreu um erro. Tente novamente.');
                button.prop('disabled', false); // Reabilita para nova tentativa
            }
        });
    });
});
