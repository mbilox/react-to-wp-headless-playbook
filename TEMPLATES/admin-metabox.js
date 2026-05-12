(function($) {
    'use strict';

    // ============================================================
    // MEDIA FRAME PARA IMÁGENES
    // ============================================================
    
    var heroFrame;
    
    $(document).on('click', '#hero-select-image', function(e) {
        e.preventDefault();
        
        if (heroFrame) {
            heroFrame.open();
            return;
        }
        
        heroFrame = wp.media({
            title: 'Seleccionar imagen',
            button: { text: 'Usar esta imagen' },
            multiple: false,
            library: { type: 'image' }
        });
        
        heroFrame.on('select', function() {
            var attachment = heroFrame.state().get('selection').first().toJSON();
            
            // Actualizar hidden input y preview
            $('#hero-image-id').val(attachment.id);
            $('#hero-image-preview').html('<img src="' + attachment.sizes.thumbnail.url + '" alt="" />');
            $('#hero-remove-image').show();
        });
        
        heroFrame.open();
    });
    
    $(document).on('click', '#hero-remove-image', function(e) {
        e.preventDefault();
        $('#hero-image-id').val('');
        $('#hero-image-preview').html('');
        $(this).hide();
    });

    // ============================================================
    // MANEJO DE REPEATERS DINÁMICOS
    // ============================================================

    /**
     * Re-indexa los atributos name y data-index después de eliminar una fila
     * para mantener el array PHP continuo.
     */
    function reindexItems(container) {
        container.find('.PREFIX-repeater-item').each(function(index) {
            $(this).attr('data-index', index);
            
            $(this).find('input, textarea, select').each(function() {
                var name = $(this).attr('name');
                if (name) {
                    // Reemplazar el primer número entre corchetes con el nuevo index
                    // Ej: PREFIX_rooms[services][4][title] -> PREFIX_rooms[services][2][title]
                    var newName = name.replace(/\[\d+\]/g, '[' + index + ']');
                    $(this).attr('name', newName);
                }
            });
        });
    }

    // Añadir fila
    $(document).on('click', '.PREFIX-add-item', function() {
        var $btn = $(this);
        var template = $btn.data('template'); // ej: "services"
        var $container = $btn.siblings('.PREFIX-repeater-items');
        var index = $container.find('.PREFIX-repeater-item').length;
        
        // Obtener HTML del template y reemplazar {index}
        var html = $('#template-' + template).html();
        html = html.replace(/{index}/g, index);
        
        $container.append(html);
    });

    // Eliminar fila
    $(document).on('click', '.PREFIX-remove-item', function() {
        var $item = $(this).closest('.PREFIX-repeater-item');
        var $container = $item.closest('.PREFIX-repeater-items');
        
        if (confirm('¿Estás seguro de eliminar este elemento?')) {
            $item.remove();
            reindexItems($container);
        }
    });

})(jQuery);
