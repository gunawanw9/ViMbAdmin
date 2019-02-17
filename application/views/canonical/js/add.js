var senderList = new Array();
var senderId = 1; // constantly increment it to make sure it is always unique on the page

$(document).ready( function()
{
    $("#address-popover").popover( { trigger: 'hover' } );
    $("#sender-popover").popover( { trigger: 'hover' } );

    $( '#sender_empty' ).keypress( function(e) {
        if( e.which == 13 )
        {
            e.preventDefault();
            if( $( '#sender_empty' ).val().indexOf( "@" ) != -1 )
                addSender();
        }
    });

    $( '#sender_empty' ).typeahead( {
        source: {$emails}
    })

    tempArr = {if $canonical->getSender()}'{$canonical->getSender()}'.split( ',' ){else}{}{/if};

    for( var i in tempArr )
    {
        senderItem = jQuery.trim( tempArr[i] );

        if( senderItem != '' )
            insertSender( senderItem );
    }

    {if isset($defaultSender)}$( '#sender_empty' ).val( '{$defaultSender}' );{/if}
}); // document onready


function insertSender( address )
{
    str = '<div id="sender-div-' + senderId + '" style="margin-top: 5px; margin-bottom: 5px;">' + "\n"
            + '<input type="text" name="sender[]" value="' + address + '" size="40" title="Sender" readonly="readonly" style="border-radius: 4px 0 0 4px;"/>' + "\n"
<<<<<<< HEAD
            + '<span title="Remove sender address" class="btn add-on" onclick="removeSender(' + senderId + ');" style="margin-left: -5px; height: 20px; border-radius: 0 4px 4px 0;" >' + "\n"
=======
            + '<span title="Remove got to" class="btn add-on" onclick="removeSender(' + senderId + ');" style="margin-left: -5px; height: 20px; border-radius: 0 4px 4px 0;" >' + "\n"
>>>>>>> c87cd109e1ec34d5317e254e44f327653ea759b2
            + '<i class="icon-minus"></i>' + "\n"
            + '</span>' + "\n"
            + '</div>';

    senderList[senderId] = address;
    senderId++;

<<<<<<< HEAD
    //jQuery( str ).appendTo( '#div-controls-sender' ).hide().show( 'fast' );
    jQuery( str ).replaceTo( '#div-controls-sender' ).hide().show( 'fast' );
=======
    jQuery( str ).appendTo( '#div-controls-sender' ).hide().show( 'fast' );
>>>>>>> c87cd109e1ec34d5317e254e44f327653ea759b2
}


function removeSender( id )
{
    $( '#sender-div-' + id ).hide( 'fast', function() { $(this).remove() } );
    delete senderList[id];
}


function addSender()
{
    address = jQuery.trim( $( '#sender_empty' ).val() );

    if( address != '' )
    {
        if( address.substr( 0, 1 ) == '@' && isValidEmailDomain( address.substr( 1 ) ) || isValidEmail( address ) )
        {
            if( senderList.indexOf( address ) == -1 )
            {
                insertSender( address );
                $( '#sender_empty' ).val( '' );
                $( '#help-sender' ).html( '' );
                $( '#div-form-sender' ).removeClass( "error" );
                return true;
            }
            else
            {
                $( '#help-sender' ).html( 'Already in sender list.' );
                return false;
            }
        }
        else
        {
            $( '#help-sender' ).html( 'Invalid email address.' );
            return false;
        }
    }

    return false;
}
