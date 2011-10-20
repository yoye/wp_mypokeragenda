	<style>
	.ui-autocomplete-category {
		font-weight: bold;
		padding: .2em .4em;
		margin: .8em 0 .2em;
		line-height: 1.5;
	}
	</style>

<div class="wrap">

    <h2>Créer votre liste</h2>

    <form action="<?php echo $action ?>" method="post">

        <table class="form-table">

            <tr valign="top">
                <th scope="row"><?php _e('Description') ?></th>
                <td>
                    <input type="text" id="agenda-name" name="agenda[name]" />
                    <span class="description"><?php _e('Petite description de votre widget.') ?></span>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php _e('Recherche') ?><span class="required">*</span></th>
                <td>
                    <input type="text" id="agenda-search" name="agenda[search]" />
                    <span class="description"><?php _e("Recherchez le nom d'un casino, le nom du salle en ligne ou le nom d'une série de tournois") ?></span>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php _e('Nombre max. de résultats') ?></th>
                <td>
                    <input type="text" id="agenda-max" name="agenda[max]" />
                    <span class="description"><?php _e('Combien de résultats voulez vous afficher ?') ?></span>
                </td>
            </tr>

        </table>

        <input type="hidden" id="agenda-remote_id" name="agenda[remote_id]" value="" />
        <input type="hidden" id="agenda-type" name="agenda[type]" value="" />
        
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>

    </form>
    
    <table class="widefat">
        <thead>
            <tr>
                <th><?php _e('Nom') ?></th>
                <th><?php _e('Type') ?></th>
                <th><?php _e('Code') ?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th><?php _e('Nom') ?></th>
                <th><?php _e('Type') ?></th>
                <th><?php _e('Code') ?></th>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach ($rows as $row) : ?>
            <tr>
                <td><?php echo $row->name ?></td>
                <td><?php echo $row->type ?></td>
                <td>[mypokeragenda id="<?php echo $row->id ?>"]</td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<script>
    function wpOnload() {
        jQuery(function($) {
            
            $.widget( "custom.catcomplete", $.ui.autocomplete, {
                _renderMenu: function( ul, items ) {
                    var self = this,
                    currentCategory = "";
                    $.each( items, function( index, item ) {
                        if ( item.type != currentCategory ) {
                            ul.append( "<li class='ui-autocomplete-category'>" + item.type + "</li>" );
                            currentCategory = item.type;
                        }
                        self._renderItem( ul, item );
                    });
                }
            });
            
            var availableTags = <?php echo json_encode($parser->getAll(), true) ?>;
            
            $("#agenda-search").catcomplete({
                source: availableTags,
                select: function(event, ui) {
                    $("#agenda-search").val(ui.item.label);
                    $("#agenda-remote_id").val(ui.item.id);
                    $("#agenda-type").val(ui.item.type);
                    
                    return false;
                }
            });
        });
    }
</script>